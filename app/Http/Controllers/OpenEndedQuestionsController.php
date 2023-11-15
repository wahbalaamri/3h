<?php

namespace App\Http\Controllers;

use App\Models\OpenEndedQuestions;
use App\Http\Requests\StoreOpenEndedQuestionsRequest;
use App\Http\Requests\UpdateOpenEndedQuestionsRequest;

class OpenEndedQuestionsController extends Controller
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
     * @param  \App\Http\Requests\StoreOpenEndedQuestionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOpenEndedQuestionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OpenEndedQuestions  $openEndedQuestions
     * @return \Illuminate\Http\Response
     */
    public function show(OpenEndedQuestions $openEndedQuestions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OpenEndedQuestions  $openEndedQuestions
     * @return \Illuminate\Http\Response
     */
    public function edit(OpenEndedQuestions $openEndedQuestions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOpenEndedQuestionsRequest  $request
     * @param  \App\Models\OpenEndedQuestions  $openEndedQuestions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOpenEndedQuestionsRequest $request, OpenEndedQuestions $openEndedQuestions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OpenEndedQuestions  $openEndedQuestions
     * @return \Illuminate\Http\Response
     */
    public function destroy(OpenEndedQuestions $openEndedQuestions)
    {
        //
    }
}
