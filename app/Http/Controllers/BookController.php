<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Profile;
use App\Models\LogVisit;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Review;
use App\Models\Report;
use App\Models\Bookmark;
use App\Models\Notification;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use DB;
use File;

class BookController extends Controller
{
    public function __construct() {
        $this->metaTags = [
            'title' => 'Digital Library',
            'description' => 'Unlock the World of Knowledge!',
        ];
    }
    public function validateError()
    {
        if(isset($validator) && $validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // filter
        if(Auth::user()) {
            if(Auth::user()->email_verified_at == null) {
                return redirect('/email/verify');
            }
            if(!Auth::user()->profile) {
                return redirect('/profile');
            }
            if(Auth::user()->profile->role == 'student') {
                $books = Book::where('status', 'active')->where('access', '!=','teacher_only')->orderByDesc('created_at')->filter(request(['search']))->paginate(12);
            } else {
                $books = Book::where('status', 'active')->orderByDesc('created_at')->filter(request(['search']))->paginate(12);
            }
        } else {
            $books = Book::where('status', 'active')->where('access', 'open')->orderByDesc('created_at')->filter(request(['search']))->paginate(12);
        }

        // most visited
        // $most_visited = (object)[];
        // $logVisit = LogVisit::select('book_id')
        //     ->groupBy('book_id')->orderBy(DB::raw('count(book_id)'))->limit(5)->get();
        // foreach($logVisit as $key => $item) {
        //     $book = Book::where('id', $item->book_id)->where('status','active')->first();
        //     if($book != null) { 
        //         $most_visited->$key = $book; 
        //     }
        // }
        // $most_visited = (array)$most_visited;
        
        $most_visited = Book::where('status', 'active')->whereHas('logVisit', function (Builder $query) {
            return $query->whereDate('created_at', '>=', date('Y-m-d', strtotime('seven days ago')));
        })->withCount('logVisit')->orderBy('log_visit_count', 'desc')->limit(5)->get();

        // notifications
        $notification = $this->buildNotification();

        return view('book.index', [
            'dashboard_header' => '<i class="bx bx-book-content me-3"></i><span>Windows of Knowledge</span>',
            'metaTags' => $this->metaTags,
            'page_title' => 'Digital Library',
            'books' => $books,
            'books_count' => count(Book::get()),
            'most_visited' => $most_visited,
            'categories' => Category::orderBy('name')->get(),
            'keyword' => request('search'),
            'notification' => $notification,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.create', [
            'dashboard_header' => '<i class="bx bx-mail-send me-3"></i><span>Post a New Book</span>',
            'metaTags' => $this->metaTags,
            'page_title' => 'Digital Library | Submit',
            'categories' => Category::orderByDesc('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        $this->validateError();
        $user = User::find($request->user_id);
        
        // category
        if($request->category == null || ($request->category == 'other' && $request->category_other == null)) {
            return response()->json([
                'message' => "please select the book's category",
            ], 400);
        } 
        $get_category = ($request->category == 'other') ? $request->category_other : $request->category;
        $category = Category::where('name', $get_category)->first();
        if(!$category) {
            $category = Category::create(['name'=>$get_category]);
        }

        // access
        if($request->access == 'open' && $request->source == null) {
            return response()->json([
                'message' => "please state the source of this book",
            ], 400);
        }

        // image
        $imageName = '';
        if($request->image) {
            $imageName = 'cover-'.time().'.'.$request->image->extension();  
            $storeImage = $request->image->move(public_path('img/covers'), $imageName);
        }

        // create book
        $create_book = Book::create([
            'user_id' => $request->user_id,
            'category_id' => $category->id,
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'publication_year' => $request->publication_year,
            'isbn' => $request->isbn,
            'summary' => $request->summary,
            'description' => $request->description,
            'image' => $imageName,
            'url' => $request->url,
            'keywords' => $request->keywords,
            'source' => $request->source,
            'access' => ($user->profile->role == 'student') ? 'limited' : $request->access,
            'status' => ($user->profile->role == 'student') ? 'confirmation' : 'active',
        ]);

        // chapters
        $i = 1;
        foreach($request->chapter_url as $key => $url) {
            if($url != null) {
                $create_chapter = Chapter::create([
                    'book_id' => $create_book->id,
                    'number' => $i,
                    'title' => ($request->chapter_title[$key] != null) ? $request->chapter_title[$key] : 'Chapter - '.$request->chapter_number[$key],
                    'url' => $request->chapter_url[$key],
                ]);
                $i++;
            }
        }

        return response()->json([
            'message' => 'successfully adding a book!',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        if($book->status == 'confirmation') { 
            if(!Auth::check() || (Auth::check() && Auth::user()->profile->role == 'student' && Auth::user()->id != $book->user->id)) {
                return redirect('/book')->with('info', 'This book is still not published yet'); 
            }
        }
        $review = ''; $alerts = []; $report = '';
        if(!Auth::check() && $book->access != 'open') {
            return redirect('/book')->with('error', 'This book is not open for guest');
        } if(Auth::check()) {
            $review = Review::where('user_id', Auth::user()->id)->where('book_id', $book->id)->first();
            $report = Report::where('user_id', Auth::user()->id)->where('book_id', $book->id)->where('solved', 0)->first();
            if(Auth::user()->profile->role == 'student' && $book->access == 'teacher_only') {
                return redirect('/book')->with('error', 'This book is not for student');
            }
        }
        $keywords = explode(',', $book->keywords);
        $bookmark = (Auth::check()) ? Bookmark::where('user_id', Auth::user()->id)->where('book_id', $book->id)->first() : '';
        $reviews = Review::where('book_id', $book->id)->orderByDesc('created_at')->get();

        if($book->status == 'confirmation') {
            $alerts[] = "This book requires confirmation before it's accessible to the public";
        } if($book->status == 'rejected') {
            $alerts[] = "This book is not accessible";
        }
        return view('book.show', [
            'dashboard_header' => '<i class="bx bx-book-content me-3"></i><span>Book Detail</span>',
            'metaTags' => $this->metaTags,
            'page_title' => 'Digital Library | Detail',
            'book' => $book,
            'keywords' => $keywords,
            'rating' => $reviews->sum('rating'),
            'reviews' => $reviews,
            'review' => $review,
            'reports' => Report::where('book_id', $book->id)->where('solved', 0)->orderByDesc('created_at')->get(),
            'report' => $report,
            'bookmark' => $bookmark,
            'records' => LogVisit::where('book_id', $book->id)->orderByDesc('created_at')->get(),
            'alerts' => $alerts,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('book.edit', [
            'dashboard_header' => '<i class="bx bx-edit-alt me-3"></i><span>Edit Book Data</span>',
            'metaTags' => $this->metaTags,
            'page_title' => 'Digital Library | Edit',
            'categories' => Category::orderByDesc('name')->get(),
            'book' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $this->validateError();
        $user = Auth::user();
        
        // category
        if($request->category == null || ($request->category == 'other' && $request->category_other == null)) {
            return response()->json([
                'message' => "please select the book's category",
            ], 400);
        } 
        $get_category = ($request->category == 'other') ? $request->category_other : $request->category;
        $category = Category::where('name', $get_category)->first();
        if(!$category) {
            $category = Category::create(['name'=>$get_category]);
        }

        // access
        if($request->access == 'open' && $request->source == null) {
            return response()->json([
                'message' => "please state the source of this book",
            ], 400);
        }
        
        // image
        $oldImage = ($book->image) ? $book->image : null;
        if($request->imageBase64) {
            $imageParts = explode(";base64,", $request->imageBase64);
            $imageTypeAux = explode("image/", $imageParts[0]);
            $imageType = $imageTypeAux[1];
            $imageBase64 = base64_decode($imageParts[1]);
            $imageName = 'cover-'.time().'.'.$imageType;
            $path = public_path('img/covers/'.$imageName);
            $storeImage = file_put_contents($path, $imageBase64);
            if($oldImage != null) {
                $path = public_path('img/covers/'.$oldImage);
                if(File::exists($path)) {
                    $delete = unlink($path);
                }
            }
        }
        $imageName = ($request->imageBase64) ? $imageName : $book->image;

        // update book
        $update = $book->update([
            'category_id' => $category->id,
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'publication_year' => $request->publication_year,
            'isbn' => $request->isbn,
            'summary' => $request->summary,
            'description' => $request->description,
            'image' => $imageName,
            'url' => $request->url,
            'keywords' => $request->keywords,
            'source' => $request->source,
            'access' => ($user->profile->role == 'student') ? 'limited' : $request->access,
        ]);
        
        // chapters
        $clear_chapter = Chapter::where('book_id', $book->id)->delete();
        $i = 1;
        if($request->chapter_url) {
            foreach($request->chapter_url as $key => $url) {
                if($url != null) {
                    $create_chapter = Chapter::create([
                        'book_id' => $book->id,
                        'number' => $i,
                        'title' => ($request->chapter_title[$key] != null) ? $request->chapter_title[$key] : 'Chapter - '.$request->chapter_number[$key],
                        'url' => $request->chapter_url[$key],
                    ]);
                    $i++;
                }
            }
        }

        // Book::where('access', 'limited')->update(['updated_at' => date('Y-m-d h:i:s', time())]);

        return response()->json([
            'message' => 'book updated successfully!',
        ], 200);
    }

    public function visit($book_id, $chapter_id)
    {
        $book = Book::find($book_id);
        if($book->status == 'rejected') { 
            return redirect('/book')->with('info', 'This book is not accessible');
        }
        if(Auth::check()) {
            $user = Auth::user();
            $logVisit = LogVisit::where('user_id', $user->id)->where('book_id', $book_id)->whereDate('created_at', date('Y-m-d'))->first();
            if(!$logVisit) {
                $role = ($user->profile) ? $user->profile->role : '-';
                if($user->profile && $user->profile->role == 'student') {
                    $grade = $user->profile->grade + date('Y') - $user->profile->year_join;
                    if($grade <= 6) {
                        $grade_level = 'elementary';
                    } elseif ($grade >= 7 && $grade <= 9) {
                        $grade_level = 'junior';
                    } elseif ($grade >= 9 && $grade <= 12) {
                        $grade_level = 'senior';
                    } else {
                        $grade_level = 'alumni';
                    }
                }
                $create_logVisit = LogVisit::create([
                    'user_id' => $user->id,
                    'book_id' => $book_id,
                    'role' => $role,
                    'grade' => (isset($grade)) ? $grade : null,
                    'grade_level' => (isset($grade_level)) ? $grade_level : null,
                ]);
            }
        }
        $url = ($chapter_id == 0) ? Book::find($book_id)->url : Chapter::find($chapter_id)->url;
        return redirect()->away($url);
    }
    public function quick_update(Request $request)
    {
        // update book
        $book = Book::find($request->book_id);
        $category_id = ($request->category_id != null) ? $request->category_id : $book->category_id;
        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'publication_year' => $request->publication_year,
            'isbn' => $request->isbn,
            'description' => $request->description,
            'url' => $request->url,
            'keywords' => $request->keywords,
            'source' => $request->source,
            'category_id' => $category_id,
        ]);
        return redirect('/book')->with('success', 'Book data updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
    public function delete($book_id)
    {
        $book = Book::find($book_id);
        if($book->image) {
            $path = public_path('img/covers/'.$book->image);
            if(File::exists($path)) {
                $delete_cover = unlink($path);
            }
        }
        $delete_book = Book::find($book_id)->delete();
        $delete_bookmark = Bookmark::where('book_id', $book_id)->delete();
        $delete_chapter = Chapter::where('book_id', $book_id)->delete();
        $delete_review = Review::where('book_id', $book_id)->delete();

        return redirect('/book')->with('success', 'Book deleted');
    }
    public function buildNotification()
    {
        $notification = [];
        $book_confirmation = Book::where('status', 'confirmation')->get();
        if(count($book_confirmation) > 0) {
            foreach($book_confirmation as $book) {
                $notification[] = "a newly submitted book with title : <a href='/book/".$book->id."' target='_blank' class='text-primary'>".$book->title."</a> requires confirmation, please check it";
            }
        }
        $reports = Report::where('solved', 0)->get();
        if(count($reports) > 0) {
            foreach($reports as $report) {
                $notification[] = "<a href='/user/".$report->user->id."' class='fw-bold'>".$report->user->profile->full_name."</a> reported an issue with a book titled : <a class='fw-bold' href='/book/".$report->book->id."'>".$report->book->title."</a>, please check it";
            }
        }
        $unconfirmed = User::where('confirmation', 0)->whereHas('profile', function(Builder $query) {
            $query->where('role', '!=', 'student');
        })->get();
        if(count($unconfirmed) > 0) {
            foreach($unconfirmed as $user) {
                $notification[] = '<a href="/user/'.$user->id.'">'.$user->email.'</a> is trying to register as a '.$user->profile->role.', is this email realy belongs to a '.$user->profile->role.'? <a href="/user/'.$user->id.'/confirm" class="fw-bold hover-underline">Yes</a>';
            }
        }
        return $notification;
    }
    public function action(Request $request)
    {
        switch($request->action) {
            case 'confirm_book':
                $book = Book::find($request->book_id);
                $message = $request->message;
                $book->update([
                    'status' => ($request->confirmed) ? 'active' : 'rejected',
                ]);
                Notification::create([
                    'user_id' => $book->user_id,
                    'subject' => ($request->confirmed) ? 'The book you submitted is now live' : 'Book submission rejected',
                    'message' => $message,
                ]);
                return response()->json([
                    'message' => 'Book status updated',
                    'additional_message' => $message,
                    'confirmed' => $request->confirmed,
                ], 200);
            break;
        }
    }
}
