<?php

namespace App\Http\Controllers;

use App\Models\SendingSurveySettings;
use App\Http\Requests\StoreSendingSurveySettingsRequest;
use App\Http\Requests\UpdateSendingSurveySettingsRequest;

class SendingSurveySettingsController extends Controller
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
     * @param  \App\Http\Requests\StoreSendingSurveySettingsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSendingSurveySettingsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SendingSurveySettings  $sendingSurveySettings
     * @return \Illuminate\Http\Response
     */
    public function show(SendingSurveySettings $sendingSurveySettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SendingSurveySettings  $sendingSurveySettings
     * @return \Illuminate\Http\Response
     */
    public function edit(SendingSurveySettings $sendingSurveySettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSendingSurveySettingsRequest  $request
     * @param  \App\Models\SendingSurveySettings  $sendingSurveySettings
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSendingSurveySettingsRequest $request, SendingSurveySettings $sendingSurveySettings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SendingSurveySettings  $sendingSurveySettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(SendingSurveySettings $sendingSurveySettings)
    {
        //
    }
}
