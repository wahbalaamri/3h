<?php

namespace App\Http\Controllers;

use App\Http\Requests\PracticeQuestionStoreRequest;
use App\Http\Requests\PracticeQuestionUpdateRequest;
use App\Models\FunctionPractice;
use App\Models\PartnerShipPlans;
use App\Models\PracticeQuestions;
use Illuminate\Http\Request;

class PracticeQuestionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $PracticeQuestions = PracticeQuestions::all();
        $plans = PartnerShipPlans::all();
        $remotePracticesQuestions = array();
        $functionID = null;
        return view('PracticeQuestions.index', compact('PracticeQuestions', 'remotePracticesQuestions', 'plans', 'functionID'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('PracticeQuestions.create');
    }
    public function CreateNewQuestion (Request $request,$id)
    {
        return view('PracticeQuestions.create',compact('id'));
    }

    /**
     * @param \App\Http\Requests\PracticeQuestionsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PracticeQuestionStoreRequest $request)
    {
        $practiceQuestion = PracticeQuestions::create();

        $plan_id = $practiceQuestion->functionPractice->functions->partnerShipPlans->id;
        return redirect()->route('partner-ship-plans.show', $plan_id);
    }
    public function SaveNewQuestion(PracticeQuestionStoreRequest $request, $plan_id)
    {
        $practiceQuestion = PracticeQuestions::create();
        $plan_id = $practiceQuestion->functionPractice->functions->partnerShipPlans->id;
        return redirect()->route('partner-ship-plans.show', $plan_id);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PracticeQuestions $practiceQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PracticeQuestions $practiceQuestion)
    {
        return view('PracticeQuestions.show', compact('practiceQuestion'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PracticeQuestions $practiceQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PracticeQuestions $practiceQuestion)
    {
        $practices = FunctionPractice::all();
        return view('PracticeQuestions.edit', compact('practiceQuestion', 'practices'));
    }

    /**
     * @param \App\Http\Requests\PracticeQuestionsUpdateRequest $request
     * @param \App\Models\PracticeQuestions $practiceQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(PracticeQuestionUpdateRequest $request, PracticeQuestions $practiceQuestion)
    {
        $practiceQuestion->update($request->validated());
        $plan_id = $practiceQuestion->functionPractice->functions->partnerShipPlans->id;
        return redirect()->route('partner-ship-plans.show', $plan_id);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PracticeQuestions $practiceQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PracticeQuestions $practiceQuestion)
    {
        $practiceQuestion->delete();

        return redirect()->route('PracticeQuestions.index');
    }
    public function GetPractice($id)
    {
        $functions = FunctionPractice::where('FunctionId', $id)->get();
        return response()->json($functions);
    }
    public function search(Request $request)
    {
        // Log::info($request->get('PlanID'));
        $remotePracticesQuestionArry = array();
        $search = $request->get('FunctionID');
        $ids = FunctionPractice::where('FunctionId', '=', $search)->pluck('id')->all();
        $PracticeQuestions = PracticeQuestions::whereIn('PracticeId', $ids)->get();
        foreach ($ids as $id) {
            $remotePracticesQuestions = $this->GetremotePracticeQuestion($id);
            foreach ($remotePracticesQuestions as $remotePracticesQuestion) {
                array_push($remotePracticesQuestionArry, $remotePracticesQuestion);
            }
        }
        $remotePracticesQuestions = $remotePracticesQuestionArry;
        $plans = PartnerShipPlans::all();
        $functionID = $search;
        return view('PracticeQuestions.index', compact('PracticeQuestions', 'remotePracticesQuestions', 'plans', 'functionID'));
    }
    private function GetremotePracticeQuestion($id)
    {
        $Questions = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.hrfactoryapp.com/Admin/PracticeQuestions/GetPracticeQuestions?practiceId=$id");
        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Get the response and close the channel.
        $response = curl_exec($ch);
        $result = json_decode($response);
        curl_close($ch);
        if (is_array($result)) {
            foreach ($result as $quetion) {
                if (PracticeQuestions::find(intval($quetion->Id)) != null)
                    continue;
                // dd($quetion);
                $remoteQuestion = new PracticeQuestions();
                $remoteQuestion->id = $quetion->Id;
                $remoteQuestion->Question = $quetion->Question;
                $remoteQuestion->QuestionAr = $quetion->QuestionAr;
                $remoteQuestion->PracticeId = $quetion->Practice;
                $remoteQuestion->Respondent = $quetion->Respondent;
                $remoteQuestion->Status = $quetion->Status;

                array_push($Questions, $remoteQuestion);
            }
        }
        return $Questions;
    }
    public function saveQuestions(Request $request, $id)
    {

        $ids = FunctionPractice::where('FunctionId', '=', $id)->pluck('id')->all();
        foreach ($ids as $id) {
            $remotePracticesQuestions = $this->GetremotePracticeQuestion($id);
            foreach ($remotePracticesQuestions as $remotePracticesQuestion) {
                $remotePracticesQuestion->save();
            }
        }
        //redirect to index function
        return redirect()->route('practice-questions.index');
    }
    public function getQuestions($id)
    {

        $questions = PracticeQuestions::where('PracticeId', $id)->get();
        //datatable
        return Datatables()->of($questions)
            ->addIndexColumn()
            // ->addColumn('action', function ($question) {
            //     $button = '<a href="' . route('practice-questions.edit', $question->id) . '" class="btn btn-primary btn-sm">Edit</a>';
            //     $button .= '&nbsp;&nbsp;';
            //     $button .= '<a href="' . route('practice-questions.show', $question->id) . '" class="btn btn-primary btn-sm">Show</a>';
            //     $button .= '&nbsp;&nbsp;';
            //     $button .= '<form action="' . route('practice-questions.destroy', $question->id) . '" method="POST" style="display:inline-block">';
            //     $button .= csrf_field();
            //     $button .= method_field('DELETE');
            //     $button .= '<button type="submit" class="btn btn-danger btn-sm">Delete</button>';
            //     $button .= '</form>';
            //     return $button;
            // })
            ->editColumn('Status', function ($row) {

                return $row->Status ? "Active" : "Inactive";
            })
            // ->rawColumns(['action'])
            ->make(true);
    }
}
