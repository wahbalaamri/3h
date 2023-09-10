<?php

namespace App\Http\Controllers;

use App\Models\SurveySettings;
use App\Http\Requests\StoreSurveySettingsRequest;
use App\Http\Requests\UpdateSurveySettingsRequest;

class SurveySettingsController extends Controller
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
     * @param  \App\Http\Requests\StoreSurveySettingsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSurveySettingsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SurveySettings  $surveySettings
     * @return \Illuminate\Http\Response
     */
    public function show(SurveySettings $surveySettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SurveySettings  $surveySettings
     * @return \Illuminate\Http\Response
     */
    public function edit(SurveySettings $surveySettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSurveySettingsRequest  $request
     * @param  \App\Models\SurveySettings  $surveySettings
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSurveySettingsRequest $request, SurveySettings $surveySettings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SurveySettings  $surveySettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(SurveySettings $surveySettings)
    {
        //
    }
}
