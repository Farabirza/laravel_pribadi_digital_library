<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Bookmark;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBookmarkRequest;
use App\Http\Requests\UpdateBookmarkRequest;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookmarkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookmarkRequest $request)
    {
        $bookmark = Bookmark::where('user_id', $request->user_id)->where('book_id', $request->book_id)->first();
        $exist = false;
        $message = "";
        if(!$bookmark) {
            $create = Bookmark::create([
                'user_id' => $request->user_id,
                'book_id' => $request->book_id,
            ]);
            $exist = true;
            $message = "Bookmarked";
        } else {
            $bookmark->delete();
            $message = "Bookmark removed";
        }
        return response()->json([
            'message' => $message,
            'exist' => $exist,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function show(Bookmark $bookmark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function edit(Bookmark $bookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookmarkRequest  $request
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookmarkRequest $request, Bookmark $bookmark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bookmark $bookmark)
    {
        //
    }
}
