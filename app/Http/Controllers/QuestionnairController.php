<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use App\Models\freeSurveyAnswers;
use App\Models\Functions;
use App\Models\PartnerShipPlans;
use App\Models\PrioritiesAnswers;
use App\Models\SurveyAnswers;
use App\Models\Surveys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QuestionnairController extends Controller
{
    //
    public function index($id)
    {
        $emailDetails = Emails::find($id);
        if ($emailDetails == null) {
            return view('errors.404');
        }
        $answerBythisEmail = SurveyAnswers::where('AnsweredBy', $id)->count();
        if ($answerBythisEmail > 0) {
            return view('errors.completed');
        }
        $SurveyId = $emailDetails->SurveyId;
        $survey = Surveys::where([['id', $SurveyId], ['SurveyStat', '=', true]])->first();
        if ($survey == null) {
            return view('errors.404');
        }
        $planId = $survey->plan->id;
        $functions = Functions::where([['Status', '=', 1], ['PlanId', '=', $survey->PlanId]])->get();
        $user_type = $emailDetails->EmployeeType;
        $can_ansewer_to_priorities = false;
        // foreach ($functions as $function) {
        //     if ($user_type == 3) {
        //         if ($function->Respondent == 2 || $function->Respondent == 4 || $function->Respondent == 5 || $function->Respondent == 7 || $function->Respondent == 8) {
        //             $can_ansewer_to_priorities = true;
        //         }
        //     }
        //     if ($user_type == 2) {
        //         if ($function->Respondent == 1 || $function->Respondent == 4 || $function->Respondent == 6 || $function->Respondent == 7 || $function->Respondent == 8) {
        //             $can_ansewer_to_priorities = true;
        //         }
        //     }
        //     if ($user_type == 1) {
        //         if ($function->Respondent == 3 || $function->Respondent == 5 || $function->Respondent == 6 || $function->Respondent == 7 || $function->Respondent == 8) {
        //             $can_ansewer_to_priorities = true;
        //         }
        //     }
        // }
        $data = [
            'functions' => $functions,
            'user_type' => $user_type,
            'can_ansewer_to_priorities' => $can_ansewer_to_priorities,
            'SurveyId' => $SurveyId,
            'email_id' => $id,
            'plan_id' => $planId,
        ];
        return view('Questions.index')->with($data);
    }
    public function saveAnswer(Request $request)
    {
        $reply = ($request->reply);
        $QuestionAnswers = $reply[0]['answers'];
        $SurveyId = $reply[0]['survey_id'];
        $PlanId = $reply[0]['PlanID'];
        $EmailId = $reply[0]['EmailId'];
        $priorities = $reply[0]['priorities'];

        if ($SurveyId == null) {
            $Count = freeSurveyAnswers::select('SurveyId')->distinct('SurveyId')->count('SurveyId');
            foreach ($QuestionAnswers as $key => $value) {
                $free_survey_answer = new freeSurveyAnswers();
                $free_survey_answer->SurveyId = "FreeSurvey-" . ($Count + 1);
                $free_survey_answer->PlanId = $PlanId;
                $free_survey_answer->QuestionId = $value['question_id'];
                $free_survey_answer->Answer_value = $value['answer'];
                $free_survey_answer->save();
            }
            $data = [
                'msg' => 'success',
                'message' => 'Your answers has been saved successfully',
                'url' => route('survey-answers.freeSurveyResult', "FreeSurvey-" . ($Count + 1)),
            ];
            return response()->json($data);
        } else {
            foreach ($QuestionAnswers as $key => $value) {
                $survey_answer = new SurveyAnswers();
                $survey_answer->SurveyId = $SurveyId;
                $survey_answer->AnsweredBy = $EmailId;
                $survey_answer->QuestionId = $value['question_id'];
                $survey_answer->AnswerValue = $value['answer'];
                $survey_answer->save();
            }
            if ($priorities != null) {
                foreach ($priorities as $key => $value) {
                    $Priority_answer = new PrioritiesAnswers();
                    $Priority_answer->SurveyId = $SurveyId;
                    $Priority_answer->AnsweredBy = $EmailId;
                    $Priority_answer->QuestionId = $value['function'];
                    $Priority_answer->AnswerValue = $value['priority'];
                    Log::info($Priority_answer);
                    $Priority_answer->save();
                }
            }
        }
        $data = [
            'msg' => 'success',
            'message' => 'Your answers has been saved successfully',
            'url' => '',
        ];
        return response()->json($data);
    }
    public function fressSurvey()
    {
        $free_plan = PartnerShipPlans::where([['PaymentMethod', '=', 1], ['Status', '=', 1]])->first();
        $functions = $free_plan->functions;
        $data = [
            'functions' => $functions,
            'user_type' => null,
            'can_ansewer_to_priorities' => false,
            'SurveyId' => null,
            'email_id' => null,
            'plan_id' => $free_plan->id,
        ];
        return view('Questions.index')->with($data);
    }
    function generateSurveyUrlForm()
    {
        return view('Surveys.generateSurveyURl');
    }
    function generateSurveyUrl(Request $request){
        //get email id from request
        $email_id = $request->email;
        //get mobile number from request
        $mobile_number = $request->mobile;
        //get employee id from request
        // $employee_id = $request->employee_id;
        //check any of them not null and add it to where elequent querey
        $where = [];
        if($email_id != null){
            $where[] = ['Email','=',$email_id];
        }
        if($mobile_number != null){
            $where[] = ['Mobile','=',$mobile_number];
        }
        // if($employee_id != null){
        //     $where[] = ['Emp_id','=',$employee_id];
        // }
        //check is $where is empty return back with error
        if(empty($where)){
            return back()->with('error',__('Please enter at least one of the following: email, mobile number or employee id'));
        }
        //get email details from database
        $id=Emails::where($where)->first();
        //check if email details is null return back with error
        if($id == null){
            return back()->with('error',__('No email found with this data'));
        }
        //redirect to survey page with email id
        return redirect()->route('survey',$id->id);

    }
    public function surveyQRCode()
    {
        $data = QrCode::generate(
            route('survey.generateSurveyUrlForm'),
        );
        return view('home.QRcode', compact('data'));
    }
    function testRadio()
    {
        $survey = Surveys::where([['id', 11], ['SurveyStat', '=', true]])->first();
        $planId = $survey->plan->id;
        $functions = Functions::where([['Status', '=', 1], ['PlanId', '=', $survey->PlanId]])->get();
        $can_ansewer_to_priorities = false;
        $data = [
            'functions' => $functions,
            // 'user_type' => $user_type,
            'can_ansewer_to_priorities' => $can_ansewer_to_priorities,
            'SurveyId' => 11,
            // 'email_id' => $id,
            'plan_id' => $planId,
        ];
        return view('Surveys.testing')->with($data);
    }
}
