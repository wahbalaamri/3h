<?php

namespace App\Http\Controllers;

use App\Exports\PrioritiesAnswersExport;
use App\Exports\SurveyAnswersExport;
use App\Http\Requests\SurveyStoreRequest;
use App\Http\Requests\SurveyUpdateRequest;
use App\Models\EmailContent;
use App\Models\PrioritiesAnswers;
use App\Models\SurveyAnswers;
use App\Models\Surveys;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SurveysController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $surveys = Surveys::all();

        return view('Surveys.index', compact('surveys'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [
            'clients' => \App\Models\Clients::all(),
            'plans' => \App\Models\PartnerShipPlans::all(),
        ];
        return view('Surveys.create')->with($data);
    }

    /**
     * @param \App\Http\Requests\SurveysStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SurveyStoreRequest $request)
    {
        $survey = Surveys::create($request->validated());

        return redirect()->route('clients.show',$survey->ClientId);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Surveys $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Surveys $survey)
    {
        return view('Surveys.show', compact('survey'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Surveys $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Surveys $survey)
    {
        $plans=\App\Models\PartnerShipPlans::all();
        $clients=\App\Models\Clients::all();
        return view('Surveys.edit', compact('survey','plans','clients'));
    }

    /**
     * @param \App\Http\Requests\SurveysUpdateRequest $request
     * @param \App\Models\Surveys $survey
     * @return \Illuminate\Http\Response
     */
    public function update(SurveyUpdateRequest $request, Surveys $survey)
    {
        $survey->update($request->validated());

        return redirect()->route('clients.show',$survey->ClientId);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Surveys $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Surveys $survey)
    {
        $id = $survey->id;
        $survey->delete();
        $result = EmailContent::where('survey_id', $id)->delete();
        // email content

        return redirect()->route('surveys.index');
    }
    public function CreateNewSurvey(Request $request, $id)
    {
        $data = [
            'client_id' => $id,
            'clients' => \App\Models\Clients::all(),
            'plans' => \App\Models\PartnerShipPlans::all(),
        ];
        return view('Surveys.create')->with($data);
    }
    public function ChangeCheck(Request $request)
    {
        $survey = Surveys::find($request->id);
        $survey->SurveyStat = !$survey->SurveyStat;
        $survey->save();
        return response()->json(['message' => 'Status change successfully.']);
    }
    public function DownloadSurvey($id)
    {

        return Excel::download(new SurveyAnswersExport($id), 'SurveyAnswersExport.xlsx');
    }
    public function DownloadPriorities($id)
    {
        return Excel::download(new PrioritiesAnswersExport($id), 'PrioritiesAnswersExport.xlsx');
        # code...
    }
}
