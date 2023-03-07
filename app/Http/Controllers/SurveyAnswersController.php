<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyAnswerStoreRequest;
use App\Http\Requests\SurveyAnswerUpdateRequest;
use App\Models\Emails;
use App\Models\freeSurveyAnswers;
use App\Models\Functions;
use App\Models\PartnerShipPlans;
use App\Models\PrioritiesAnswers;
use App\Models\SurveyAnswers;
use App\Models\Surveys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Termwind\Components\Dd;

class SurveyAnswersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'ShowFreeResult']);
    }
    public function index(Request $request)
    {
        $surveys = Surveys::all();
        $free_surveys = freeSurveyAnswers::select('SurveyId')->distinct('SurveyId')->get();
        $data = [
            'surveys' => $surveys,
            'free_surveys' => $free_surveys,
        ];
        return view('SurveyAnswers.index')->with($data);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('SurveyAnswers.create');
    }

    /**
     * @param \App\Http\Requests\SurveyAnswersStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SurveyAnswerStoreRequest $request)
    {
        $surveyAnswer = SurveyAnswers::create($request->validated());

        return redirect()->route('SurveyAnswers.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SurveyAnswers $surveyAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SurveyAnswers $surveyAnswer)
    {
        return view('SurveyAnswers.show', compact('SurveyAnswer'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SurveyAnswers $surveyAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SurveyAnswers $surveyAnswer)
    {
        return view('SurveyAnswers.edit', compact('SurveyAnswer'));
    }

    /**
     * @param \App\Http\Requests\SurveyAnswersUpdateRequest $request
     * @param \App\Models\SurveyAnswers $surveyAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(SurveyAnswerUpdateRequest $request, SurveyAnswers $surveyAnswer)
    {
        $surveyAnswer->update($request->validated());

        return redirect()->route('SurveyAnswers.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SurveyAnswers $surveyAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SurveyAnswers $surveyAnswer)
    {
        $surveyAnswer->delete();

        return redirect()->route('SurveyAnswers.index');
    }
    public function result($id)
    {
        $surveyEmails = Emails::where('SurveyId', $id)->get();
        $leaders_email = array();
        $hr_teames_email = array();
        $employees_email = array();
        foreach ($surveyEmails as $surveyEmail) {
            if ($surveyEmail->EmployeeType == 1) {
                array_push($leaders_email, $surveyEmail->id);
            }
            if ($surveyEmail->EmployeeType == 2) {
                array_push($hr_teames_email, $surveyEmail->id);
            }
            if ($surveyEmail->EmployeeType == 3) {
                array_push($employees_email, $surveyEmail->id);
            }
        }
        $leaders_answers = SurveyAnswers::where('SurveyId', '=', $id)->whereIn('AnsweredBy', $leaders_email)->get();
        $hr_teames_answers = SurveyAnswers::where('SurveyId', '=', $id)->whereIn('AnsweredBy', $hr_teames_email)->get();
        $employees_answers = SurveyAnswers::where('SurveyId', '=', $id)->whereIn('AnsweredBy', $employees_email)->get();
        $Answers_by_leaders = collect($leaders_answers)->unique('AnsweredBy')->count();
        $Answers_by_hr = collect($hr_teames_answers)->unique('AnsweredBy')->count();
        $Answers_by_emp = collect($employees_answers)->unique('AnsweredBy')->count();
        if ($Answers_by_leaders < count($leaders_email) || $Answers_by_hr < count($hr_teames_email) || $Answers_by_emp < count($employees_email)) {
            $data = [
                'leaders' => count($leaders_email),
                'hr' => count($hr_teames_email),
                'emp' => count($employees_email),
                'leaders_answers' => $Answers_by_leaders,
                'hr_answers' => $Answers_by_hr,
                'emp_answers' => $Answers_by_emp,
                'total' => count($surveyEmails),
                'total_answers' => $Answers_by_leaders + $Answers_by_hr + $Answers_by_emp,
            ];
            return view('SurveyAnswers.notComplet')->with($data);
        }
        $planID = Surveys::where('id', $id)->first()->PlanId;

        $SurveyResult = SurveyAnswers::where('SurveyId', '=', $id)->get();
        if ($SurveyResult->count() == 0 && $surveyEmails->count() == 0) {
            $data = [
                'leaders' => 1,
                'hr' => 1,
                'emp' => 1,
                'leaders_answers' => 0,
                'hr_answers' => 0,
                'emp_answers' => 0,
                'total' => 1,
                'total_answers' => 0 + 0 + 0,
            ];
            return view('SurveyAnswers.notComplet')->with($data);
        }
        $sumxx = $SurveyResult->sum('AnswerValue');
        $countxx = $SurveyResult->count();
        $avgxx = $countxx == 0 ? 0 : $sumxx / $countxx;
        $overallResult = $avgxx / 6;
        $overallResult = round($overallResult, 2) * 100;

        $Number_of_leaders = $SurveyResult->whereIn('AnsweredBy', $leaders_email)->count();
        $Number_of_hr = $SurveyResult->whereIn('AnsweredBy', $hr_teames_email)->count();
        $Number_of_emp = $SurveyResult->whereIn('AnsweredBy', $employees_email)->count();

        $functions = Functions::where('PlanId', $planID)->get();
        $prioritiesRes = PrioritiesAnswers::where('SurveyId', $id)->get();
        $priorities = array();
        $priority = array();
        $performences_ = array();
        $performence_ = array();
        //leader
        $leader_performences_ = array();
        $leader_performence_ = array();
        //hr
        $hr_performences_ = array();
        $hr_performence_ = array();
        //emp
        $emp_performences_ = array();
        $emp_performence_ = array();

        $overall_Practices = array();
        $leaders_practices = array();
        $hr_practices = array();
        $emp_practices = array();
        $function_Lables = array();
        Log::info($SurveyResult);
        foreach ($functions as $function) {
            $function_Lables[] = $function->FunctionTitle;
            $total = 0;
            $leaders_total = 0;
            $hr_total = 0;
            $emp_total = 0;
            $counter = 0;
            $overall_Practice = array();
            $leaders_practice = array();
            $hr_practice = array();
            $emp_practice = array();
            foreach ($function->functionPractices as $functionPractice) {

                $answers = $SurveyResult->where('QuestionId', '=', $functionPractice->practiceQuestions->id)->whereIn('AnsweredBy', $leaders_email)->sum('AnswerValue');
                $count = $SurveyResult->where('QuestionId', '=', $functionPractice->practiceQuestions->id)->whereIn('AnsweredBy', $leaders_email)->count();
                $leaders_Pract_w = $count == 0 ? 0 : ($answers / $count) / 6;
                $leaders_total += $leaders_Pract_w;

                $counter++;

                $practiceName = $functionPractice->PracticeTitle;

                $practiceAns = $SurveyResult->where('QuestionId', '=', $functionPractice->practiceQuestions->id)->sum('AnswerValue');
                if ($function->id == 8) {
                    Log::alert('===ee');
                    Log::info($SurveyResult->where('QuestionId', '=', $functionPractice->practiceQuestions->id));
                    Log::alert("test:". $functionPractice->practiceQuestions->id);
                }
                $practiceAnsCount = $SurveyResult->where('QuestionId', '=', $functionPractice->practiceQuestions->id)->count();
                $practiceWeight = $practiceAnsCount == 0 ? 0 : round((($practiceAns / $practiceAnsCount) / 6), 2);

                $overall_Practice = [
                    'name' => $practiceName,
                    'weight' => $practiceWeight,
                    'function_id' => $function->id,
                ];
                $leaders_practice = [
                    'name' => $practiceName,
                    'weight' => round($leaders_Pract_w, 2),
                    'function_id' => $function->id,
                ];
                $hr_practice_ans = $SurveyResult->where('QuestionId', '=', $functionPractice->practiceQuestions->id)->whereIn('AnsweredBy', $hr_teames_email)->sum('AnswerValue');
                $hr_practice_ans_count = $SurveyResult->where('QuestionId', '=', $functionPractice->practiceQuestions->id)->whereIn('AnsweredBy', $hr_teames_email)->count();
                $hr_practice_weight = $hr_practice_ans_count == 0 ? 0 : round((($hr_practice_ans / $hr_practice_ans_count) / 6), 2);
                $hr_total += $hr_practice_weight;

                $hr_practice = [
                    'name' => $practiceName,
                    'weight' => $hr_practice_weight,
                    'function_id' => $function->id,
                ];
                $emp_practice_ans = $SurveyResult->where('QuestionId', '=', $functionPractice->practiceQuestions->id)->whereIn('AnsweredBy', $employees_email)->sum('AnswerValue');
                $emp_practice_ans_count = $SurveyResult->where('QuestionId', '=', $functionPractice->practiceQuestions->id)->whereIn('AnsweredBy', $employees_email)->count();
                $emp_practice_weight = $emp_practice_ans_count == 0 ? 0 : round((($emp_practice_ans / $emp_practice_ans_count) / 6), 2);
                $emp_total += $emp_practice_weight;

                $emp_practice = [
                    'name' => $practiceName,
                    'weight' => $emp_practice_weight,
                    'function_id' => $function->id,
                ];
                if (count($leaders_email) > 0 && count($hr_teames_email) > 0 && count($employees_email) > 0)
                    $total += ($leaders_Pract_w + $hr_practice_weight + $emp_practice_weight) / 3;
                elseif (count($leaders_email) > 0 && count($hr_teames_email) > 0)
                    $total += ($leaders_Pract_w + $hr_practice_weight) / 2;
                elseif (count($leaders_email) > 0  && count($employees_email) > 0)
                    $total += ($leaders_Pract_w + $emp_practice_weight) / 2;
                elseif (count($hr_teames_email) > 0  && count($employees_email) > 0)
                    $total += ($hr_practice_weight + $emp_practice_weight) / 2;
                else
                    $total += $leaders_Pract_w;
                array_push($overall_Practices, $overall_Practice);
                array_push($leaders_practices, $leaders_practice);
                array_push($hr_practices, $hr_practice);
                array_push($emp_practices, $emp_practice);
            }

            $performence = round(($total / $counter), 2);

            //leader performence
            $leader_performence = round(($leaders_total / $counter), 2);
            //hr performence
            $hr_performence = round(($hr_total / $counter), 2);
            //emp performence
            $emp_performence = round(($emp_total / $counter), 2);
            $total_answers = $prioritiesRes->where('QuestionId', $function->id)->whereIn('AnsweredBy', $leaders_email)->sum('AnswerValue');
            $count_answers = $prioritiesRes->where('QuestionId', $function->id)->whereIn('AnsweredBy', $leaders_email)->count();
            $priorityVal = round((($total_answers / $count_answers) / 3), 2);
            //Log::info("priorityVal: " . $priorityVal);
            $priority = ["priority" => $priorityVal, "function" => $function->FunctionTitle, "function_id" => $function->id, "performance" => $leader_performence];
            array_push($priorities, $priority);
            $performence_ = ["function" => $function->FunctionTitle, "function_id" => $function->id, "performance" => ($performence * 100), 'overall_Practices' => $overall_Practices, 'leaders_practices' => $leaders_practices, 'hr_practices' => $hr_practices, 'emp_practices' => $emp_practices];
            array_push($performences_, $performence_);
            //leader
            $leader_performence_ = ["function" => $function->FunctionTitle, "function_id" => $function->id, "performance" => ($leader_performence * 100)];
            array_push($leader_performences_, $leader_performence_);
            //hr
            $hr_performence_ = ["function" => $function->FunctionTitle, "function_id" => $function->id, "performance" => ($hr_performence * 100)];
            array_push($hr_performences_, $hr_performence_);
            //emp
            $emp_performence_ = ["function" => $function->FunctionTitle, "function_id" => $function->id, "performance" => ($emp_performence * 100)];
            array_push($emp_performences_, $emp_performence_);
        }
        Log::alert($overall_Practices);
        $overAllpractice = $overall_Practices;
        //sorte overAllpractice Asc
        usort($overAllpractice, function ($a, $b) {
            return $a['weight'] <=> $b['weight'];
        });
        $unsorted_performences = $performences_;
        $sorted_leader_performences = $leader_performences_;
        $sorted_hr_performences = $hr_performences_;
        $sorted_emp_performences = $emp_performences_;
        //sorte sorted_leader_performences descending
        usort($sorted_leader_performences, function ($a, $b) {
            return $b['performance'] <=> $a['performance'];
        });
        //sorte sorted_hr_performences descending
        usort($sorted_hr_performences, function ($a, $b) {
            return $b['performance'] <=> $a['performance'];
        });
        //sorte sorted_emp_performences descending
        usort($sorted_emp_performences, function ($a, $b) {
            return $b['performance'] <=> $a['performance'];
        });
        //sort performances_
        usort($performences_, function ($a, $b) {
            return $a['performance'] <=> $b['performance'];
        });
        $asc_perform = $performences_;
        usort($performences_, function ($a, $b) {
            return $b['performance'] <=> $a['performance'];
        });
        $leaders_perform_only = array();
        $hr_perform_only = array();
        $count_z = 0;
        foreach ($functions as $function) {
            if ($leader_performences_[$count_z]['function_id'] == $function->id) {
                array_push($leaders_perform_only, $leader_performences_[$count_z]['performance']);
            }
            if ($hr_performences_[$count_z]['function_id'] == $function->id) {
                array_push($hr_perform_only, $hr_performences_[$count_z++]['performance']);
            }
        }
        $desc_perfom = $performences_;
        $data = [
            'functions' => $functions,
            'priorities' => $priorities,
            'overallResult' => $overallResult,
            'asc_perform' => $asc_perform,
            'desc_perfom' => $desc_perfom,
            'overall_Practices' => $overall_Practices,
            'overAllpractice' => $overAllpractice,
            // 'overall_PracticesAsc' => $overall_PracticesAsc,
            'unsorted_performences' => $unsorted_performences,
            'sorted_leader_performences' => $sorted_leader_performences,
            'sorted_hr_performences' => $sorted_hr_performences,
            'sorted_emp_performences' => $sorted_emp_performences,
            'function_Lables' => $function_Lables,
            'leaders_perform_only' => $leaders_perform_only,
            'hr_perform_only' => $hr_perform_only,
            "id"=>$id
        ];
        return view('SurveyAnswers.result')->with($data);
    }
    public function ShowFreeResult($id)
    {
        $SurveyResult = freeSurveyAnswers::where('SurveyId', $id)->get();
        $functions = Functions::where('PlanId', $SurveyResult->first()->PlanId)->get();
        $overall_Practices = array();
        $sumxx = $SurveyResult->sum('Answer_value');
        $countxx = $SurveyResult->count();
        $avgxx = $sumxx / $countxx;
        $overallResult = $avgxx / 6;
        $overallResult = round($overallResult, 2) * 100;
        $performences_ = array();
        $performence_ = array();
        $hr_performences_ = array();
        $hr_performence_ = array();
        foreach ($functions as $function) {
            $total = 0;
            $counter = 0;
            $hr_total = 0;
            $overall_Practice = array();

            foreach ($function->functionPractices as $functionPractice) {

                $counter++;

                $practiceName = $functionPractice->PracticeTitle;

                $practiceAns = $SurveyResult->where('QuestionId', '=', $functionPractice->practiceQuestions->id)->sum('Answer_value');
                $practiceAnsCount = $SurveyResult->where('QuestionId', '=', $functionPractice->practiceQuestions->id)->count();
                $practiceWeight = round((($practiceAns / $practiceAnsCount) / 6), 2);

                $overall_Practice = [
                    'name' => $practiceName,
                    'weight' => $practiceWeight,
                    'function_id' => $function->id,
                ];
                $hr_practice_ans = $SurveyResult->where('QuestionId', '=', $functionPractice->practiceQuestions->id)->sum('Answer_value');
                $hr_practice_ans_count = $SurveyResult->where('QuestionId', '=', $functionPractice->practiceQuestions->id)->count();
                $hr_practice_weight = round((($hr_practice_ans / $hr_practice_ans_count) / 6), 2);
                $hr_total += $hr_practice_weight;
                $hr_practice = [
                    'name' => $practiceName,
                    'weight' => $hr_practice_weight,
                    'function_id' => $function->id,
                ];
                array_push($overall_Practices, $overall_Practice);
                $total += $practiceWeight;
            }
            $performence = round(($total / $counter), 2);

            $performence_ = ["function" => $function->FunctionTitle, "function_id" => $function->id, "performance" => ($performence * 100), 'overall_Practices' => $overall_Practices];
            array_push($performences_, $performence_);
            $hr_performence = round(($hr_total / $counter), 2);
            $hr_performence_ = ["function" => $function->FunctionTitle, "function_id" => $function->id, "performance" => ($hr_performence * 100)];
            array_push($hr_performences_, $hr_performence_);
        }
        //sorte performences_ ascending
        usort($performences_, function ($a, $b) {
            return $a['performance'] <=> $b['performance'];
        });
        //sorte hr_performences_ descending
        usort($hr_performences_, function ($a, $b) {
            return $b['performance'] <=> $a['performance'];
        });

        // dd($plan);
        $data = [
            'functions' => $functions,
            'SurveyResult' => $SurveyResult,
            'overall_Practices' => $overall_Practices,
            'overallResult' => $overallResult,
            'asc_perform' => $performences_,
            'sorted_hr_performences' => $hr_performences_,
        ];
        return view('SurveyAnswers.freeResult')->with($data);
    }
}
