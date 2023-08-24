<?php

namespace App\Http\Controllers;

use App\Models\LogVisit;
use App\Http\Requests\StoreLogVisitRequest;
use App\Http\Requests\UpdateLogVisitRequest;

class LogVisitController extends Controller
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
     * @param  \App\Http\Requests\StoreLogVisitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLogVisitRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LogVisit  $logVisit
     * @return \Illuminate\Http\Response
     */
    public function show(LogVisit $logVisit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogVisit  $logVisit
     * @return \Illuminate\Http\Response
     */
    public function edit(LogVisit $logVisit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLogVisitRequest  $request
     * @param  \App\Models\LogVisit  $logVisit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLogVisitRequest $request, LogVisit $logVisit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogVisit  $logVisit
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogVisit $logVisit)
    {
        //
    }
}
