<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Report;
use App\Models\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;

class ReportController extends Controller
{
    public function __construct() {
        $this->metaTags = [
            'title' => 'Digital Library',
            'description' => 'Unlock the World of Knowledge!',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
     * @param  \App\Http\Requests\StoreReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $report = Report::where('user_id', Auth::user()->id)->where('book_id', $request->book_id)->first();
        if($report) {
            $report->update([
                'subject' => $request->subject,
                'comment' => ($request->comment) ? $request->comment : '-',
                'solved' => 0,
            ]);
        } else {
            $create = report::create([
                'user_id' => Auth::user()->id,
                'book_id' => $request->book_id,
                'subject' => $request->subject,
                'comment' => ($request->comment) ? $request->comment : '-',
            ]);
        }
        $book = Book::find($request->book_id);
        $notification = Notification::create([
            'user_id' => $book->user->id,
            'subject' => "An issue is found in the book you submitted",
            'message' => "<a href='/user/".Auth::user()->id."' class='text-primary'>".Auth::user()->profile->full_name."</a> flagged a book you submitted with title : <a href='/book/".$book->id."' class='text-primary'>".$book->title.",</a> please check it",
        ]);

        return back()->with('success', "Thank you for your feedback");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReportRequest  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
    public function delete($book_id)
    {
        $report = Report::where('book_id', $book_id)->where('user_id', Auth::user()->id)->delete();
        return back()->with('success', 'Report removed');
    }
    public function action(Request $request)
    {
        switch($request->action) {
            case 'solved':
                $report = Report::find($request->report_id);
                $report->update([ 'solved' => 1, ]);
                $notification = Notification::create([
                    'user_id' => $report->user_id,
                    'subject' => "Your report has been processed",
                    'message' => "Thank you for your feedback regarding a book titled : ".($report->book ? $report->book->title : '').", the issue has been solved and you can now access the book with ease :)",
                ]);
                return response()->json([
                    'message' => 'Problem solved',
                ], 200);
            break;
        }
    }
}
