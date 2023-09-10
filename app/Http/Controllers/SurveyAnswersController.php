<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyAnswerStoreRequest;
use App\Http\Requests\SurveyAnswerUpdateRequest;
use App\Models\Companies;
use App\Models\Departments;
use App\Models\Emails;
use App\Models\freeSurveyAnswers;
use App\Models\FunctionPractice;
use App\Models\Functions;
use App\Models\PartnerShipPlans;
use App\Models\PracticeQuestions;
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
        $term = '';
        $term1 = '';
        $term2 = '';
        $surveyEmails = Emails::where('SurveyId', $id)->get();
        $respondent = $surveyEmails->pluck('id')->all();
        $client = Surveys::find($id)->clients;
        $sectors = $client->sectors;
        $companies = null;
        $result_per_sector = array();
        $fun_sector_result = array();
        $result_per_company = array();
        $overall_per_fun = array();
        $overall_per_practice = array();
        $used_scale = 5;
        $companies_list = [];
        $deps_list = [];
        $respondent_answers = SurveyAnswers::where('SurveyId', '=', $id)->whereIn('AnsweredBy', $respondent)->get();
        //substract 1 from respondent_answers->AnswerValue
        $respondent_answers->transform(function ($item, $key) {
            $item->AnswerValue = $item->AnswerValue - 1;
            return $item;
        });
        //get count of distinct AnsweredBy
        $count_respondent_answers = $respondent_answers->unique('AnsweredBy')->count();
        if ($count_respondent_answers < 1) {
            $data = [
                'respondent' => 1,
                'respondent_answers' => $count_respondent_answers,
                'leaders' => 1,
                'hr' => 1,
                'emp' => 1,
                'leaders_answers' => 0,
                'hr_answers' => 0,
                'emp_answers' => 0,
                'total' => 1,
                'total_answers' => 0,
            ];
            return view('SurveyAnswers.notComplet')->with($data);
        }
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
                'total_answers' => 0,
            ];
            return view('SurveyAnswers.notComplet')->with($data);
        }
        $planID = Surveys::where('id', $id)->first()->PlanId;
        $functions = Functions::where('PlanId', $planID)->get();
        $driver_functions = $functions->where('IsDriver', true);
        // driver_function_Ids
        $driver_function_Ids = $driver_functions->pluck('id')->all();
        //foreach
        foreach ($driver_functions as $d_function) {
            $discription = "";
            if ($d_function->FunctionTitle == 'Head')
                $discription = __('Intellectual Stimulation');
            elseif ($d_function->FunctionTitle == 'Hand')
                $discription = __('Enablement');
            else
                $discription = __('Emotional Connection');
            //get function_practices IDs
            $function_practices_ids = FunctionPractice::where('FunctionId', $d_function->id)->pluck('id')->all();
            //get Practice questions
            $practices_questions = PracticeQuestions::whereIn('PracticeId', $function_practices_ids)->pluck('id')->all();
            //get client all average AnswerValue
            $client_all_avg = $respondent_answers->whereIn('QuestionId', $practices_questions)->avg('AnswerValue');
            $function_result = [
                'fun_title' => App()->getLocale() == 'en' ? $d_function->FunctionTitle : $d_function->FunctionTitleAr,
                'fun_des' => $discription,
                'fun_id' => $d_function->id,
                'fun_perc' => round(($client_all_avg / $used_scale), 2) * 100,
            ];
            array_push($overall_per_fun, $function_result);
            foreach ($function_practices_ids as $fp_id) {
                $practice = FunctionPractice::find($fp_id);
                $practice_questions = PracticeQuestions::where('PracticeId', $fp_id)->pluck('id')->all();
                $practice_avg = $respondent_answers->whereIn('QuestionId', $practice_questions)->avg('AnswerValue');
                $practice_result = [
                    'PracticeId' => $fp_id,
                    'FunctionId' => $d_function->id,
                    'PracticeTitle' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                    'practice_perc' => round(($practice_avg / $used_scale), 2) * 100,
                ];
                array_push($overall_per_practice, $practice_result);
            }
        }

        foreach ($sectors as $sector) {

            $sector_emails = [];;
            $companies = $sector->companies;
            $companies_list = array_merge($companies_list, $companies->toArray());

            foreach ($companies as $company) {
                //get Departments for Each Company
                $deps_list = array_merge($deps_list, $company->departments->toArray());
                $departments = $company->departments->pluck('id')->all();
                //get all employees for each department
                $Emails = Emails::whereIn('dep_id', $departments)->pluck('id')->all();
                //push each id in $emails to Sector Emails
                foreach ($Emails as $em) {
                    array_push($sector_emails, $em);
                }

                // //get all employees answers for each department with format
                // $company_avg = round($respondent_answers->whereIn('QuestionId', $practices_questions)->whereIn('AnsweredBy', $Emails)->avg('AnswerValue'), 2);
                // //formate the $company_avg
                // $company_result = [
                //     'company_name_en' => $company->company_name_en,
                //     'company_name_ar' => $company->company_name_ar,
                //     'company_perc' => round(($company_avg / $used_scale), 2) * 100,
                // ];
                // array_push($result_per_company, $company_result);
            }
            //get all employees answers for each department with format
            foreach ($driver_functions as $d_fun) {
                //get function_practices IDs
                $function_practices_ids = FunctionPractice::where('FunctionId', $d_fun->id)->pluck('id')->all();
                //get Practice questions
                $practices_questions = PracticeQuestions::whereIn('PracticeId', $function_practices_ids)->pluck('id')->all();
                $sector_avg = round($respondent_answers->whereIn('QuestionId', $practices_questions)->whereIn('AnsweredBy', $sector_emails)->avg('AnswerValue'), 2);
                //formate the $company_avg
                $sector_fun_result = [
                    //add functiontitle
                    'FunctionTitle' => App()->getLocale() == 'en' ? $d_fun->FunctionTitle : $d_fun->FunctionTitleAr,
                    'fun_id' => $d_fun->id,
                    'sect_perc' => round(($sector_avg / $used_scale), 2) * 100,
                ];
                array_push($fun_sector_result, $sector_fun_result);
            }
            $sector_result = [
                'sector_name' => App()->getLocale() == 'en' ? $sector->sector_name_en : $sector->sector_name_ar,
                'functions' => $fun_sector_result
            ];
            array_push($result_per_sector, $sector_result);
        }
        //get function_practices IDs
        $EE_index_Practices_id = FunctionPractice::where('FunctionId', $functions->where('IsDriver', false)->first()->id)->pluck('id')->all();
        //get Practice questions
        $EE_index_questions = PracticeQuestions::whereIn('PracticeId', $EE_index_Practices_id)->pluck('id')->all();
        $EE_Index = $respondent_answers->whereIn('QuestionId', $EE_index_questions)->avg('AnswerValue');
        $EE_Index = round(($EE_Index / $used_scale), 2) * 100;
        $eNPS_Question_id = PracticeQuestions::where('IsENPS', true)->first()->id;
        $eNPS = $respondent_answers->where('QuestionId', $eNPS_Question_id)->avg('AnswerValue');
        $eNPS = round(($eNPS / $used_scale), 2) * 100;
        $EE_Index_Engaged = 0; // it's from 75-100
        $EE_Index_Nuetral = 0; // from 55-75
        $EE_Index_Actively_Disengaged = 0; // from 0-55
        $eNPS_Promotors = 0; // it's from 75-100
        $eNPS_Passives = 0; // from 55-75
        $eNPS_Detractors = 0; // from 0-55
        Log::alert('respondent: '.count($respondent));
        foreach ($respondent as $respond_id) {
            $individual_eNPS = $respondent_answers->where('QuestionId', $eNPS_Question_id)->where('AnsweredBy', $respond_id)->avg('AnswerValue');
            $individual_eNPS = round(($individual_eNPS / $used_scale), 2) * 100;
            $individual_EE_Index = $respondent_answers->whereIn('QuestionId', $EE_index_questions)->where('AnsweredBy', $respond_id)->avg('AnswerValue');
            Log::alert(' EE_index_questions: ');
            Log::alert($EE_index_questions);
            $individual_EE_Index = round(($individual_EE_Index / $used_scale), 2) * 100;
            Log::alert('respond_id: '.$respond_id.' individual_EE_Index: '.$individual_EE_Index);
            if ($individual_eNPS >= 75) {
                $eNPS_Promotors++;
            } elseif ($individual_eNPS >= 55) {
                $eNPS_Passives++;
            } else {
                $eNPS_Detractors++;
            }
            if ($individual_EE_Index >= 75) {
                $EE_Index_Engaged++;
            } elseif ($individual_EE_Index >= 55) {
                $EE_Index_Nuetral++;
            } else {
                $EE_Index_Actively_Disengaged++;
            }
        }
        Log::alert('EE_Index_Engaged: '.$EE_Index_Engaged);
        Log::alert('EE_Index_Nuetral: '.$EE_Index_Nuetral);
        Log::alert('EE_Index_Actively_Disengaged: '.$EE_Index_Actively_Disengaged);
        $eNPS_Promotors = round(($eNPS_Promotors / count($respondent)), 2) * 100;
        $eNPS_Passives = round(($eNPS_Passives / count($respondent)), 2) * 100;
        $eNPS_Detractors = round(($eNPS_Detractors / count($respondent)), 2) * 100;
        $EE_Index_Engaged = round(($EE_Index_Engaged / count($respondent)), 2) * 100;
        $EE_Index_Nuetral = round(($EE_Index_Nuetral / count($respondent)), 2) * 100;
        $EE_Index_Actively_Disengaged = round(($EE_Index_Actively_Disengaged / count($respondent)), 2) * 100;
        // copy $overall_per_practice and sort the copy asc
        $overall_per_practice_sorted = $overall_per_practice;
        usort($overall_per_practice_sorted, function ($a, $b) {
            return $a['practice_perc'] <=> $b['practice_perc'];
        });
        //get first three lowest items
        $lowest_practices = array_slice($overall_per_practice_sorted, 0, 3);
        //get first three highest items
        $highest_practices = array_slice($overall_per_practice_sorted, -3, 3);
        //sorte highest_practices desc
        usort($highest_practices, function ($a, $b) {
            return $b['practice_perc'] <=> $a['practice_perc'];
        });
        $data = [
            'overall_per_fun' => $overall_per_fun,
            'driver_functions' => $driver_functions,
            'overall_per_practice' => $overall_per_practice,
            'result_per_sector' => $result_per_sector,
            'EE_Index' => $EE_Index,
            'eNPS' => $eNPS,
            'eNPS_Promotors' => $eNPS_Promotors,
            'eNPS_Passives' => $eNPS_Passives,
            'eNPS_Detractors' => $eNPS_Detractors,
            'EE_Index_Engaged' => $EE_Index_Engaged,
            'EE_Index_Nuetral' => $EE_Index_Nuetral,
            'EE_Index_Actively_Disengaged' => $EE_Index_Actively_Disengaged,
            'highest_practices' => $highest_practices,
            'lowest_practices' => $lowest_practices,
            'sectors' => $sectors,
            'survey_id' => $id,
            'not_home' => false,
            'isDep' => false,
            'type' => '1',
            'term'=> __('Organizational wide') ,
            'term1'=> __('Sectors') ,
            'term2'=> __('Sector') ,
            'id'=>$id
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
    public function SectorResult($id, $sector_id)
    {
        $term = '';
        $term1 = '';
        $term2 = '';
        $companies_id = Companies::where('sector_id', $sector_id)->pluck('id')->all();
        $departments_id = Departments::whereIn('company_id', $companies_id)->pluck('id')->all();
        $surveyEmails = Emails::where('SurveyId', $id)->whereIn('dep_id', $departments_id)->get();
        $respondent = $surveyEmails->pluck('id')->all();
        $client = Surveys::find($id)->clients;
        $sectors = $client->sectors;
        $companies = null;
        $result_per_sector = array();
        $fun_sector_result = array();
        $result_per_company = array();
        $overall_per_fun = array();
        $overall_per_practice = array();
        $used_scale = 5;
        $companies_list = [];
        $deps_list = [];
        $respondent_answers = SurveyAnswers::where('SurveyId', '=', $id)->whereIn('AnsweredBy', $respondent)->get();
        //substract 1 from respondent_answers->AnswerValue
        $respondent_answers->transform(function ($item, $key) {
            $item->AnswerValue = $item->AnswerValue - 1;
            return $item;
        });
        //get count of distinct AnsweredBy
        $count_respondent_answers = $respondent_answers->unique('AnsweredBy')->count();
        // if ($count_respondent_answers < count($respondent)) {
        //     $data = [
        //         'respondent' => count($respondent),
        //         'respondent_answers' => $count_respondent_answers,
        //     ];
        //     return view('SurveyAnswers.notComplet')->with($data);
        // }
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
                'total_answers' => 0,
            ];
            return view('SurveyAnswers.notComplet')->with($data);
        }
        $planID = Surveys::where('id', $id)->first()->PlanId;
        $functions = Functions::where('PlanId', $planID)->get();
        $driver_functions = $functions->where('IsDriver', true);
        // driver_function_Ids
        $driver_function_Ids = $driver_functions->pluck('id')->all();
        //foreach
        foreach ($driver_functions as $d_function) {
            $discription = "";
            if ($d_function->FunctionTitle == 'Head')
                $discription = __('Intellectual Stimulation');
            elseif ($d_function->FunctionTitle == 'Hand')
                $discription = __('Enablement');
            else
                $discription = __('Emotional Connection');
            //get function_practices IDs
            $function_practices_ids = FunctionPractice::where('FunctionId', $d_function->id)->pluck('id')->all();
            //get Practice questions
            $practices_questions = PracticeQuestions::whereIn('PracticeId', $function_practices_ids)->pluck('id')->all();
            //get client all average AnswerValue
            $client_all_avg = $respondent_answers->whereIn('QuestionId', $practices_questions)->avg('AnswerValue');
            $function_result = [
                'fun_title' => App()->getLocale() == 'en' ? $d_function->FunctionTitle : $d_function->FunctionTitleAr,
                'fun_des' => $discription,
                'fun_id' => $d_function->id,
                'fun_perc' => round(($client_all_avg / $used_scale), 2) * 100,
            ];
            array_push($overall_per_fun, $function_result);
            foreach ($function_practices_ids as $fp_id) {
                $practice = FunctionPractice::find($fp_id);
                $practice_questions = PracticeQuestions::where('PracticeId', $fp_id)->pluck('id')->all();
                $practice_avg = $respondent_answers->whereIn('QuestionId', $practice_questions)->avg('AnswerValue');
                $practice_result = [
                    'PracticeId' => $fp_id,
                    'FunctionId' => $d_function->id,
                    'PracticeTitle' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                    'practice_perc' => round(($practice_avg / $used_scale), 2) * 100,
                ];
                array_push($overall_per_practice, $practice_result);
            }
        }

        // foreach ($sectors as $sector) {

        $sector_emails = [];;
        $companies = $sectors->where('id', $sector_id)->first()->companies;
        // $companies_list = array_merge($companies_list, $companies->toArray());

        foreach ($companies as $company) {
            //get Departments for Each Company
            $deps_list = array_merge($deps_list, $company->departments->toArray());
            $departments = $company->departments->pluck('id')->all();
            //get all employees for each department
            $Emails = Emails::whereIn('dep_id', $departments)->pluck('id')->all();
            //push each id in $emails to Sector Emails
            // foreach ($Emails as $em) {
            //     array_push($sector_emails, $em);
            // }
            foreach ($driver_functions as $d_fun) {
                //get function_practices IDs
                $function_practices_ids = FunctionPractice::where('FunctionId', $d_fun->id)->pluck('id')->all();
                //get Practice questions
                $practices_questions = PracticeQuestions::whereIn('PracticeId', $function_practices_ids)->pluck('id')->all();
                $sector_avg = round($respondent_answers->whereIn('QuestionId', $practices_questions)->whereIn('AnsweredBy', $Emails)->avg('AnswerValue'), 2);
                //formate the $company_avg
                $sector_fun_result = [
                    //add functiontitle
                    'FunctionTitle' => App()->getLocale() == 'en' ? $d_fun->FunctionTitle : $d_fun->FunctionTitleAr,
                    'fun_id' => $d_fun->id,
                    'sect_perc' => round(($sector_avg / $used_scale), 2) * 100,
                ];
                array_push($fun_sector_result, $sector_fun_result);
            }
            $sector_result = [
                'sector_name' => App()->getLocale() == 'en' ? $company->company_name_en : $company->company_name_ar,
                'functions' => $fun_sector_result
            ];
            array_push($result_per_sector, $sector_result);
        }
        //get all employees answers for each department with format

        // }
        //get function_practices IDs
        $EE_index_Practices_id = FunctionPractice::where('FunctionId', $functions->where('IsDriver', false)->first()->id)->pluck('id')->all();
        //get Practice questions
        $EE_index_questions = PracticeQuestions::whereIn('PracticeId', $EE_index_Practices_id)->pluck('id')->all();
        $EE_Index = $respondent_answers->whereIn('QuestionId', $EE_index_questions)->avg('AnswerValue');
        $EE_Index = round(($EE_Index / $used_scale), 2) * 100;
        $eNPS_Question_id = PracticeQuestions::where('IsENPS', true)->first()->id;
        $eNPS = $respondent_answers->where('QuestionId', $eNPS_Question_id)->avg('AnswerValue');
        $eNPS = round(($eNPS / $used_scale), 2) * 100;
        $EE_Index_Engaged = 0; // it's from 75-100
        $EE_Index_Nuetral = 0; // from 55-75
        $EE_Index_Actively_Disengaged = 0; // from 0-55
        $eNPS_Promotors = 0; // it's from 75-100
        $eNPS_Passives = 0; // from 55-75
        $eNPS_Detractors = 0; // from 0-55
        foreach ($respondent as $respond_id) {
            $individual_eNPS = $respondent_answers->where('QuestionId', $eNPS_Question_id)->where('AnsweredBy', $respond_id)->avg('AnswerValue');
            $individual_eNPS = round(($individual_eNPS / $used_scale), 2) * 100;
            $individual_EE_Index = $respondent_answers->whereIn('QuestionId', $EE_index_questions)->where('AnsweredBy', $respond_id)->avg('AnswerValue');
            $individual_EE_Index = round(($individual_EE_Index / $used_scale), 2) * 100;
            if ($individual_eNPS >= 75) {
                $eNPS_Promotors++;
            } elseif ($individual_eNPS >= 55) {
                $eNPS_Passives++;
            } else {
                $eNPS_Detractors++;
            }
            if ($individual_EE_Index >= 75) {
                $EE_Index_Engaged++;
            } elseif ($individual_EE_Index >= 55) {
                $EE_Index_Nuetral++;
            } else {
                $EE_Index_Actively_Disengaged++;
            }
        }
        $eNPS_Promotors = round(($eNPS_Promotors / count($respondent)), 2) * 100;
        $eNPS_Passives = round(($eNPS_Passives / count($respondent)), 2) * 100;
        $eNPS_Detractors = round(($eNPS_Detractors / count($respondent)), 2) * 100;
        $EE_Index_Engaged = round(($EE_Index_Engaged / count($respondent)), 2) * 100;
        $EE_Index_Nuetral = round(($EE_Index_Nuetral / count($respondent)), 2) * 100;
        $EE_Index_Actively_Disengaged = round(($EE_Index_Actively_Disengaged / count($respondent)), 2) * 100;
        // copy $overall_per_practice and sort the copy asc
        $overall_per_practice_sorted = $overall_per_practice;
        usort($overall_per_practice_sorted, function ($a, $b) {
            return $a['practice_perc'] <=> $b['practice_perc'];
        });
        //get first three lowest items
        $lowest_practices = array_slice($overall_per_practice_sorted, 0, 3);
        //get first three highest items
        $highest_practices = array_slice($overall_per_practice_sorted, -3, 3);
        //sorte highest_practices desc
        usort($highest_practices, function ($a, $b) {
            return $b['practice_perc'] <=> $a['practice_perc'];
        });
        $data = [
            'overall_per_fun' => $overall_per_fun,
            'driver_functions' => $driver_functions,
            'overall_per_practice' => $overall_per_practice,
            'result_per_sector' => $result_per_sector,
            'EE_Index' => $EE_Index,
            'eNPS' => $eNPS,
            'eNPS_Promotors' => $eNPS_Promotors,
            'eNPS_Passives' => $eNPS_Passives,
            'eNPS_Detractors' => $eNPS_Detractors,
            'EE_Index_Engaged' => $EE_Index_Engaged,
            'EE_Index_Nuetral' => $EE_Index_Nuetral,
            'EE_Index_Actively_Disengaged' => $EE_Index_Actively_Disengaged,
            'highest_practices' => $highest_practices,
            'lowest_practices' => $lowest_practices,
            'sectors' => $sectors,
            'survey_id' => $id,
            'not_home' => true,
            'isDep' => false,
            'type' => '2',
           'term'=> __('Sector') ,
           'term1'=> __('Companies') ,
           'term2'=> __('Company') ,
           'id'=>$id
        ];
        return view('SurveyAnswers.result')->with($data);
    }
    public function CompanyResult($id, $company_id)
    {
        $term = '';
        $term1 = '';
        $term2 = '';
        $departments_id = Departments::where('company_id', $company_id)->pluck('id')->all();
        $surveyEmails = Emails::where('SurveyId', $id)->whereIn('dep_id', $departments_id)->get();
        $respondent = $surveyEmails->pluck('id')->all();
        $client = Surveys::find($id)->clients;
        $sectors = $client->sectors;
        $companies = null;
        $result_per_sector = array();
        $fun_sector_result = array();
        $result_per_company = array();
        $overall_per_fun = array();
        $overall_per_practice = array();
        $used_scale = 5;
        $companies_list = [];
        $deps_list = [];
        $respondent_answers = SurveyAnswers::where('SurveyId', '=', $id)->whereIn('AnsweredBy', $respondent)->get();
        //substract 1 from respondent_answers->AnswerValue
        $respondent_answers->transform(function ($item, $key) {
            $item->AnswerValue = $item->AnswerValue - 1;
            return $item;
        });
        //get count of distinct AnsweredBy
        $count_respondent_answers = $respondent_answers->unique('AnsweredBy')->count();
        // if ($count_respondent_answers < count($respondent)) {
        //     $data = [
        //         'respondent' => count($respondent),
        //         'respondent_answers' => $count_respondent_answers,
        //     ];
        //     return view('SurveyAnswers.notComplet')->with($data);
        // }
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
                'total_answers' => 0,
            ];
            return view('SurveyAnswers.notComplet')->with($data);
        }
        $planID = Surveys::where('id', $id)->first()->PlanId;
        $functions = Functions::where('PlanId', $planID)->get();
        $driver_functions = $functions->where('IsDriver', true);
        // driver_function_Ids
        $driver_function_Ids = $driver_functions->pluck('id')->all();
        //foreach
        foreach ($driver_functions as $d_function) {
            $discription = "";
            if ($d_function->FunctionTitle == 'Head')
                $discription = __('Intellectual Stimulation');
            elseif ($d_function->FunctionTitle == 'Hand')
                $discription = __('Enablement');
            else
                $discription = __('Emotional Connection');
            //get function_practices IDs
            $function_practices_ids = FunctionPractice::where('FunctionId', $d_function->id)->pluck('id')->all();
            //get Practice questions
            $practices_questions = PracticeQuestions::whereIn('PracticeId', $function_practices_ids)->pluck('id')->all();
            //get client all average AnswerValue
            $client_all_avg = $respondent_answers->whereIn('QuestionId', $practices_questions)->avg('AnswerValue');
            $function_result = [
                'fun_title' => App()->getLocale() == 'en' ? $d_function->FunctionTitle : $d_function->FunctionTitleAr,
                'fun_des' => $discription,
                'fun_id' => $d_function->id,
                'fun_perc' => round(($client_all_avg / $used_scale), 2) * 100,
            ];
            array_push($overall_per_fun, $function_result);
            foreach ($function_practices_ids as $fp_id) {
                $practice = FunctionPractice::find($fp_id);
                $practice_questions = PracticeQuestions::where('PracticeId', $fp_id)->pluck('id')->all();
                $practice_avg = $respondent_answers->whereIn('QuestionId', $practice_questions)->avg('AnswerValue');
                $practice_result = [
                    'PracticeId' => $fp_id,
                    'FunctionId' => $d_function->id,
                    'PracticeTitle' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                    'practice_perc' => round(($practice_avg / $used_scale), 2) * 100,
                ];
                array_push($overall_per_practice, $practice_result);
            }
        }

        // foreach ($sectors as $sector) {

        $sector_emails = [];;
        $departments = Departments::where('company_id', $company_id)->get();
        // $companies_list = array_merge($companies_list, $companies->toArray());

        foreach ($departments as $department) {
            $Emails = Emails::where('dep_id', $department->id)->pluck('id')->all();
            //push each id in $emails to Sector Emails
            // foreach ($Emails as $em) {
            //     array_push($sector_emails, $em);
            // }
            foreach ($driver_functions as $d_fun) {
                //get function_practices IDs
                $function_practices_ids = FunctionPractice::where('FunctionId', $d_fun->id)->pluck('id')->all();
                //get Practice questions
                $practices_questions = PracticeQuestions::whereIn('PracticeId', $function_practices_ids)->pluck('id')->all();
                $sector_avg = round($respondent_answers->whereIn('QuestionId', $practices_questions)->whereIn('AnsweredBy', $Emails)->avg('AnswerValue'), 2);
                //formate the $company_avg
                $sector_fun_result = [
                    //add functiontitle
                    'FunctionTitle' => App()->getLocale() == 'en' ? $d_fun->FunctionTitle : $d_fun->FunctionTitleAr,
                    'fun_id' => $d_fun->id,
                    'sect_perc' => round(($sector_avg / $used_scale), 2) * 100,
                ];
                array_push($fun_sector_result, $sector_fun_result);
            }
            $sector_result = [
                'sector_name' => App()->getLocale() == 'en' ? $department->dep_name_en : $department->dep_name_ar,
                'functions' => $fun_sector_result
            ];
            array_push($result_per_sector, $sector_result);
        }
        //get all employees answers for each department with format

        // }
        //get function_practices IDs
        $EE_index_Practices_id = FunctionPractice::where('FunctionId', $functions->where('IsDriver', false)->first()->id)->pluck('id')->all();
        //get Practice questions
        $EE_index_questions = PracticeQuestions::whereIn('PracticeId', $EE_index_Practices_id)->pluck('id')->all();
        $EE_Index = $respondent_answers->whereIn('QuestionId', $EE_index_questions)->avg('AnswerValue');
        $EE_Index = round(($EE_Index / $used_scale), 2) * 100;
        $eNPS_Question_id = PracticeQuestions::where('IsENPS', true)->first()->id;
        $eNPS = $respondent_answers->where('QuestionId', $eNPS_Question_id)->avg('AnswerValue');
        $eNPS = round(($eNPS / $used_scale), 2) * 100;
        $EE_Index_Engaged = 0; // it's from 75-100
        $EE_Index_Nuetral = 0; // from 55-75
        $EE_Index_Actively_Disengaged = 0; // from 0-55
        $eNPS_Promotors = 0; // it's from 75-100
        $eNPS_Passives = 0; // from 55-75
        $eNPS_Detractors = 0; // from 0-55
        foreach ($respondent as $respond_id) {
            $individual_eNPS = $respondent_answers->where('QuestionId', $eNPS_Question_id)->where('AnsweredBy', $respond_id)->avg('AnswerValue');
            $individual_eNPS = round(($individual_eNPS / $used_scale), 2) * 100;
            $individual_EE_Index = $respondent_answers->whereIn('QuestionId', $EE_index_questions)->where('AnsweredBy', $respond_id)->avg('AnswerValue');
            $individual_EE_Index = round(($individual_EE_Index / $used_scale), 2) * 100;
            if ($individual_eNPS >= 75) {
                $eNPS_Promotors++;
            } elseif ($individual_eNPS >= 55) {
                $eNPS_Passives++;
            } else {
                $eNPS_Detractors++;
            }
            if ($individual_EE_Index >= 75) {
                $EE_Index_Engaged++;
            } elseif ($individual_EE_Index >= 55) {
                $EE_Index_Nuetral++;
            } else {
                $EE_Index_Actively_Disengaged++;
            }
        }
        $eNPS_Promotors = round(($eNPS_Promotors / count($respondent)), 2) * 100;
        $eNPS_Passives = round(($eNPS_Passives / count($respondent)), 2) * 100;
        $eNPS_Detractors = round(($eNPS_Detractors / count($respondent)), 2) * 100;
        $EE_Index_Engaged = round(($EE_Index_Engaged / count($respondent)), 2) * 100;
        $EE_Index_Nuetral = round(($EE_Index_Nuetral / count($respondent)), 2) * 100;
        $EE_Index_Actively_Disengaged = round(($EE_Index_Actively_Disengaged / count($respondent)), 2) * 100;
        // copy $overall_per_practice and sort the copy asc
        $overall_per_practice_sorted = $overall_per_practice;
        usort($overall_per_practice_sorted, function ($a, $b) {
            return $a['practice_perc'] <=> $b['practice_perc'];
        });
        //get first three lowest items
        $lowest_practices = array_slice($overall_per_practice_sorted, 0, 3);
        //get first three highest items
        $highest_practices = array_slice($overall_per_practice_sorted, -3, 3);
        //sorte highest_practices desc
        usort($highest_practices, function ($a, $b) {
            return $b['practice_perc'] <=> $a['practice_perc'];
        });
        $data = [
            'overall_per_fun' => $overall_per_fun,
            'driver_functions' => $driver_functions,
            'overall_per_practice' => $overall_per_practice,
            'result_per_sector' => $result_per_sector,
            'EE_Index' => $EE_Index,
            'eNPS' => $eNPS,
            'eNPS_Promotors' => $eNPS_Promotors,
            'eNPS_Passives' => $eNPS_Passives,
            'eNPS_Detractors' => $eNPS_Detractors,
            'EE_Index_Engaged' => $EE_Index_Engaged,
            'EE_Index_Nuetral' => $EE_Index_Nuetral,
            'EE_Index_Actively_Disengaged' => $EE_Index_Actively_Disengaged,
            'highest_practices' => $highest_practices,
            'lowest_practices' => $lowest_practices,
            'sectors' => $sectors,
            'survey_id' => $id,
            'not_home' => true,
            'isDep' => false,
            'type' => '3',
            'term'=> __('Company') ,
            'term1'=> __('Departments') ,
            'term2'=> __('Department'),
            'id'=>$id
        ];
        return view('SurveyAnswers.result')->with($data);
    }

    public function DepartmentResult($id, $dep_id)
    {
        $term = '';
        $term1 = '';
        $term2 = '';
        $surveyEmails = Emails::where('SurveyId', $id)->where('dep_id', $dep_id)->get();
        $respondent = $surveyEmails->pluck('id')->all();
        $client = Surveys::find($id)->clients;
        $sectors = $client->sectors;
        $companies = null;
        $result_per_sector = array();
        $fun_sector_result = array();
        $result_per_company = array();
        $overall_per_fun = array();
        $overall_per_practice = array();
        $used_scale = 5;
        $companies_list = [];
        $deps_list = [];
        $respondent_answers = SurveyAnswers::where('SurveyId', '=', $id)->whereIn('AnsweredBy', $respondent)->get();
        //substract 1 from respondent_answers->AnswerValue
        $respondent_answers->transform(function ($item, $key) {
            $item->AnswerValue = $item->AnswerValue - 1;
            return $item;
        });
        //get count of distinct AnsweredBy
        $count_respondent_answers = $respondent_answers->unique('AnsweredBy')->count();
        // if ($count_respondent_answers < count($respondent)) {
        //     $data = [
        //         'respondent' => count($respondent),
        //         'respondent_answers' => $count_respondent_answers,
        //     ];
        //     return view('SurveyAnswers.notComplet')->with($data);
        // }
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
                'total_answers' => 0,
            ];
            return view('SurveyAnswers.notComplet')->with($data);
        }
        $planID = Surveys::where('id', $id)->first()->PlanId;
        $functions = Functions::where('PlanId', $planID)->get();
        $driver_functions = $functions->where('IsDriver', true);
        // driver_function_Ids
        $driver_function_Ids = $driver_functions->pluck('id')->all();
        //foreach
        foreach ($driver_functions as $d_function) {
            $discription = "";
            if ($d_function->FunctionTitle == 'Head')
                $discription = __('Intellectual Stimulation');
            elseif ($d_function->FunctionTitle == 'Hand')
                $discription = __('Enablement');
            else
                $discription = __('Emotional Connection');
            //get function_practices IDs
            $function_practices_ids = FunctionPractice::where('FunctionId', $d_function->id)->pluck('id')->all();
            //get Practice questions
            $practices_questions = PracticeQuestions::whereIn('PracticeId', $function_practices_ids)->pluck('id')->all();
            //get client all average AnswerValue
            $client_all_avg = $respondent_answers->whereIn('QuestionId', $practices_questions)->avg('AnswerValue');
            $function_result = [
                'fun_title' => App()->getLocale() == 'en' ? $d_function->FunctionTitle : $d_function->FunctionTitleAr,
                'fun_des' => $discription,
                'fun_id' => $d_function->id,
                'fun_perc' => round(($client_all_avg / $used_scale), 2) * 100,
            ];
            array_push($overall_per_fun, $function_result);
            foreach ($function_practices_ids as $fp_id) {
                $practice = FunctionPractice::find($fp_id);
                $practice_questions = PracticeQuestions::where('PracticeId', $fp_id)->pluck('id')->all();
                $practice_avg = $respondent_answers->whereIn('QuestionId', $practice_questions)->avg('AnswerValue');
                $practice_result = [
                    'PracticeId' => $fp_id,
                    'FunctionId' => $d_function->id,
                    'PracticeTitle' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                    'practice_perc' => round(($practice_avg / $used_scale), 2) * 100,
                ];
                array_push($overall_per_practice, $practice_result);
            }
        }

        // foreach ($sectors as $sector) {

        $sector_emails = [];;

        //get all employees answers for each department with format

        // }
        //get function_practices IDs
        $EE_index_Practices_id = FunctionPractice::where('FunctionId', $functions->where('IsDriver', false)->first()->id)->pluck('id')->all();
        //get Practice questions
        $EE_index_questions = PracticeQuestions::whereIn('PracticeId', $EE_index_Practices_id)->pluck('id')->all();
        $EE_Index = $respondent_answers->whereIn('QuestionId', $EE_index_questions)->avg('AnswerValue');
        $EE_Index = round(($EE_Index / $used_scale), 2) * 100;
        $eNPS_Question_id = PracticeQuestions::where('IsENPS', true)->first()->id;
        $eNPS = $respondent_answers->where('QuestionId', $eNPS_Question_id)->avg('AnswerValue');
        $eNPS = round(($eNPS / $used_scale), 2) * 100;
        $EE_Index_Engaged = 0; // it's from 75-100
        $EE_Index_Nuetral = 0; // from 55-75
        $EE_Index_Actively_Disengaged = 0; // from 0-55
        $eNPS_Promotors = 0; // it's from 75-100
        $eNPS_Passives = 0; // from 55-75
        $eNPS_Detractors = 0; // from 0-55
        foreach ($respondent as $respond_id) {
            $individual_eNPS = $respondent_answers->where('QuestionId', $eNPS_Question_id)->where('AnsweredBy', $respond_id)->avg('AnswerValue');
            $individual_eNPS = round(($individual_eNPS / $used_scale), 2) * 100;
            $individual_EE_Index = $respondent_answers->whereIn('QuestionId', $EE_index_questions)->where('AnsweredBy', $respond_id)->avg('AnswerValue');
            $individual_EE_Index = round(($individual_EE_Index / $used_scale), 2) * 100;
            if ($individual_eNPS >= 75) {
                $eNPS_Promotors++;
            } elseif ($individual_eNPS >= 55) {
                $eNPS_Passives++;
            } else {
                $eNPS_Detractors++;
            }
            if ($individual_EE_Index >= 75) {
                $EE_Index_Engaged++;
            } elseif ($individual_EE_Index >= 55) {
                $EE_Index_Nuetral++;
            } else {
                $EE_Index_Actively_Disengaged++;
            }
        }
        $eNPS_Promotors = round(($eNPS_Promotors / count($respondent)), 2) * 100;
        $eNPS_Passives = round(($eNPS_Passives / count($respondent)), 2) * 100;
        $eNPS_Detractors = round(($eNPS_Detractors / count($respondent)), 2) * 100;
        $EE_Index_Engaged = round(($EE_Index_Engaged / count($respondent)), 2) * 100;
        $EE_Index_Nuetral = round(($EE_Index_Nuetral / count($respondent)), 2) * 100;
        $EE_Index_Actively_Disengaged = round(($EE_Index_Actively_Disengaged / count($respondent)), 2) * 100;
        // copy $overall_per_practice and sort the copy asc
        $overall_per_practice_sorted = $overall_per_practice;
        usort($overall_per_practice_sorted, function ($a, $b) {
            return $a['practice_perc'] <=> $b['practice_perc'];
        });
        //get first three lowest items
        $lowest_practices = array_slice($overall_per_practice_sorted, 0, 3);
        //get first three highest items
        $highest_practices = array_slice($overall_per_practice_sorted, -3, 3);
        //sorte highest_practices desc
        usort($highest_practices, function ($a, $b) {
            return $b['practice_perc'] <=> $a['practice_perc'];
        });
        $data = [
            'overall_per_fun' => $overall_per_fun,
            'driver_functions' => $driver_functions,
            'overall_per_practice' => $overall_per_practice,
            'result_per_sector' => $result_per_sector,
            'EE_Index' => $EE_Index,
            'eNPS' => $eNPS,
            'eNPS_Promotors' => $eNPS_Promotors,
            'eNPS_Passives' => $eNPS_Passives,
            'eNPS_Detractors' => $eNPS_Detractors,
            'EE_Index_Engaged' => $EE_Index_Engaged,
            'EE_Index_Nuetral' => $EE_Index_Nuetral,
            'EE_Index_Actively_Disengaged' => $EE_Index_Actively_Disengaged,
            'highest_practices' => $highest_practices,
            'lowest_practices' => $lowest_practices,
            'sectors' => $sectors,
            'survey_id' => $id,
            'not_home' => true,
            'isDep' => true,
            'type' => '4',
            'term'=> __('Department') ,
            'term1'=> __('Departments') ,
            'term2'=> __('Department'),
            'id'=>$id
        ];
        return view('SurveyAnswers.result')->with($data);
    }
}
