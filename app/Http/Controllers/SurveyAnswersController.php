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
use App\Models\Sectors;
use App\Models\Clients;
use App\Models\SurveyAnswers;
use App\Models\Surveys;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Termwind\Components\Dd;

class SurveyAnswersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    private $respondent_answers;
    private $number_emails;
    private $number_response;
    private $obj_sector_emails;
    private $id;
    private $clientID;
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'ShowFreeResult']);
        $this->respondent_answers = collect(new SurveyAnswers);
        $this->number_emails = 0;
        $this->number_response = 0;
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
        $this->id = $id;
        //chunck survey answers
        $respondent_answersx = SurveyAnswers::chunk(1000, function ($respondent_answers) {
            foreach ($respondent_answers->where('SurveyId', '=', $this->id) as $res) {
                $this->respondent_answers->push($res);
            }
            // Log::info("test me: 2");
            //return $respondent_answers->where('SurveyId', '=', 20);
        }, $column = 'id');
        //get count of distinct AnsweredBy
        $respondent_answers = collect(new SurveyAnswers);
        // $respondent_answers = SurveyAnswers::where('SurveyId', '=', $id)->/* whereIn('AnsweredBy', $respondent)-> */lazyById(1000, $column = 'id');
        Log::alert("count: " . count(collect($respondent_answers)));
        Log::alert("count01: " . count(collect($this->respondent_answers)));
        //substract 1 from respondent_answers->AnswerValue
        // $respondent_answers->transform(function ($item, $key) {
        //     $item->AnswerValue = $item->AnswerValue - 1;
        //     return $item;
        // });
        //get count of distinct AnsweredBy
        // $count_respondent_answers = $respondent_answers->unique('AnsweredBy')->count();
        // chunck
        $count_respondent_answers = 0;
        $count_respondent_answers = count(collect($this->respondent_answers)->unique('AnsweredBy'));
        Log::alert("count_respondent_answers: " . $count_respondent_answers);
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
        // $SurveyResult = SurveyAnswers::where('SurveyId', '=', $id)->get();
        if ($count_respondent_answers == 0 && $surveyEmails->count() == 0) {
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
            $respondent_answers = collect($respondent_answers);
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
                $Emails = Emails::where('comp_id', $company->id)->pluck('id')->all();
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
                // Log::info('145457454574');
                // Log::info(($practices_questions));
                $sector_avg = round($respondent_answers->whereIn('QuestionId', $practices_questions)->whereIn('AnsweredBy', $sector_emails)->avg('AnswerValue'), 2);
                // Log::info('======');
                // Log::info($sector_avg);
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
            // Log::info("dddd");
            // Log::info($sector_result);
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
        Log::alert('respondent: ' . count($respondent));
        foreach ($respondent as $respond_id) {
            $individual_eNPS = $respondent_answers->where('QuestionId', $eNPS_Question_id)->where('AnsweredBy', $respond_id)->avg('AnswerValue');
            $individual_eNPS = round(($individual_eNPS / $used_scale), 2) * 100;
            $individual_EE_Index = $respondent_answers->whereIn('QuestionId', $EE_index_questions)->where('AnsweredBy', $respond_id)->avg('AnswerValue');
            Log::alert(' EE_index_questions: ');
            Log::alert($EE_index_questions);
            $individual_EE_Index = round(($individual_EE_Index / $used_scale), 2) * 100;
            Log::alert('respond_id: ' . $respond_id . ' individual_EE_Index: ' . $individual_EE_Index);
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
        Log::alert('EE_Index_Engaged: ' . $EE_Index_Engaged);
        Log::alert('EE_Index_Nuetral: ' . $EE_Index_Nuetral);
        Log::alert('EE_Index_Actively_Disengaged: ' . $EE_Index_Actively_Disengaged);
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
            'term' => __('Organizational wide'),
            'term1' => __('Sectors'),
            'term2' => __('Sector'),
            'id' => $id
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
            'term' => __('Sector'),
            'term1' => __('Companies'),
            'term2' => __('Company'),
            'id' => $id
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
            'term' => __('Company'),
            'term1' => __('Departments'),
            'term2' => __('Department'),
            'id' => $id
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
            'term' => __('Department'),
            'term1' => __('Departments'),
            'term2' => __('Department'),
            'id' => $id
        ];
        return view('SurveyAnswers.result')->with($data);
    }
    public function resultPDF($id, $type, $type_id = null)
    {
        ini_set('max_execution_time', 1800);
        $data = $this->get_result($id, $type, $type_id);
        // return view('SurveyAnswers.resultpdf')->with($data);
        $pdf = PDF::loadView('SurveyAnswers.resultpdf', $data);
        return $pdf->download('result.pdf');
        // return view('SurveyAnswers.resultpdf')->with($data);
    }
    public function alzubair_result($id, $type, $type_id = null)
    {
        $data = $this->get_result($id, $type, $type_id);
        return view('SurveyAnswers.new-results')->with($data);
        // $overall_per_fun = array();
        // $driver_functions_practice = array();
        // $practice_results = [];
        // $ENPS_data_array = [];
        // $outcome_functions_practice = array();
        // $Outcome_practice_results = [];
        // $function_results = [];
        // $outcome_function_results = [];
        // $outcome_function_results_1 = array();
        // $entity = "";
        // $this->id = $id;
        // if ($type == "comp") { //find the company name
        //     $entity = Companies::find($type_id)->company_name_en;
        // }
        // //sector
        // elseif ($type == "sec") {
        //     $entity = Sectors::find($type_id)->sector_name_en;
        // }
        // //client
        // else {
        //     $entity = Surveys::find($id)->clients->ClientName;
        // }
        // foreach (Surveys::find($id)->plan->functions->where('IsDriver', true) as $function) {
        //     $function_Nuetral_sum = 0;
        //     $function_Favorable_sum = 0;
        //     $function_UnFavorable_sum = 0;
        //     $function_Nuetral_count = 0;
        //     $function_Favorable_count = 0;
        //     $function_UnFavorable_count = 0;
        //     foreach ($function->functionPractices as $practice) {
        //         //get sum of answer value from survey answers
        //         if ($type == 'all')
        //             $Favorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue','>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->first();
        //         elseif ($type == 'comp') {
        //             //get Emails id for a company
        //             $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
        //             $Favorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue','>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
        //         }
        //         //sector
        //         elseif ($type == 'sec') {
        //             //get Emails id for a company
        //             $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
        //             $Favorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue','>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
        //         }

        //         if ($Favorable_result) {
        //             $sum_answer_value_Favorable = $Favorable_result->sum;
        //             $Favorable_count = $Favorable_result->count;
        //         } else {
        //             $sum_answer_value_Favorable = 0;
        //             $Favorable_count = 0;
        //         }
        //         if ($type == 'all')
        //             $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue','<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->first();
        //         elseif ($type == 'comp') {
        //             //get Emails id for a company
        //             $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
        //             $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue','<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
        //         }
        //         //sector
        //         elseif ($type == 'sec') {
        //             //get Emails id for a company
        //             $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
        //             $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue','<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
        //         }

        //         if ($UnFavorable_result) {
        //             $sum_answer_value_UnFavorable = $UnFavorable_result->sum;
        //             $UnFavorable_count = $UnFavorable_result->count;
        //         } else {
        //             $sum_answer_value_UnFavorable = 0;
        //             $UnFavorable_count = 0;
        //         }
        //         if ($type == 'all')
        //             $Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->first();
        //         elseif ($type == 'comp') {
        //             $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
        //             $Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
        //         }
        //         //sector
        //         elseif ($type == 'sec') {
        //             $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
        //             $Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
        //         }
        //         if ($Nuetral_result) {
        //             $sum_answer_value_Nuetral = $Nuetral_result->sum;
        //             $Nuetral_count = $Nuetral_result->count;
        //         } else {
        //             $sum_answer_value_Nuetral = 0;
        //             $Nuetral_count = 0;
        //         }
        //         $practice_results = [
        //             'function' => $function->id,
        //             'practice_id' => $practice->id,
        //             'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
        //             'Nuetral_score' => $sum_answer_value_Nuetral == 0 ? 0 : number_format(($sum_answer_value_Nuetral / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2),
        //             'Favorable_score' => $sum_answer_value_Favorable == 0 ? 0 : number_format(($sum_answer_value_Favorable / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2),
        //             'UnFavorable_score' => $sum_answer_value_UnFavorable == 0 ? 0 : number_format(($sum_answer_value_UnFavorable / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2),
        //             //get count of Favorable answers
        //             'Favorable_count' => $Favorable_count,
        //             //get count of UnFavorable answers
        //             'UnFavorable_count' => $UnFavorable_count,
        //             //get count of Nuetral answers
        //             'Nuetral_count' => $Nuetral_count,
        //         ];
        //         $function_Nuetral_sum += $sum_answer_value_Nuetral;
        //         $function_Favorable_sum += $sum_answer_value_Favorable;
        //         $function_UnFavorable_sum += $sum_answer_value_UnFavorable;
        //         $function_Nuetral_count += $Nuetral_count;
        //         $function_Favorable_count += $Favorable_count;
        //         $function_UnFavorable_count += $UnFavorable_count;
        //         array_push($driver_functions_practice, $practice_results);
        //     }
        //     //setup function_results
        //     $function_results = [
        //         'function' => $function->id,
        //         'function_title' => App()->getLocale() == 'en' ? $function->FunctionTitle : $function->FunctionTitleAr,
        //         'Nuetral_score' => $function_Nuetral_sum == 0 ? 0 : number_format(($function_Nuetral_sum / ($function_Favorable_sum + $function_Nuetral_sum + $function_UnFavorable_sum)) * 100, 2),
        //         'Favorable_score' => $function_Favorable_sum == 0 ? 0 : number_format(($function_Favorable_sum / ($function_Favorable_sum + $function_Nuetral_sum + $function_UnFavorable_sum)) * 100, 2),
        //         'UnFavorable_score' => $function_UnFavorable_sum == 0 ? 0 : number_format(($function_UnFavorable_sum / ($function_Favorable_sum + $function_Nuetral_sum + $function_UnFavorable_sum)) * 100, 2),
        //         //get count of Favorable answers
        //         'Favorable_count' => $function_Favorable_count,
        //         //get count of UnFavorable answers
        //         'UnFavorable_count' => $function_UnFavorable_count,
        //         //get count of Nuetral answers
        //         'Nuetral_count' => $function_Nuetral_count,
        //     ];
        //     array_push($overall_per_fun, $function_results);
        // }
        // // dd($overall_per_fun);
        // foreach (Surveys::find($id)->plan->functions->where('IsDriver', false) as $function) {
        //     $function_Nuetral_sum = 0;
        //     $function_Favorable_sum = 0;
        //     $function_UnFavorable_sum = 0;
        //     $function_Nuetral_count = 0;
        //     $function_Favorable_count = 0;
        //     $function_UnFavorable_count = 0;
        //     foreach ($function->functionPractices as $practice) {
        //         //get sum of answer value from survey answers
        //         if ($type == 'all')
        //             $Favorable_reslut = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 5], ['QuestionId', $practice->practiceQuestions->id]])->whereOr([['SurveyId', $this->id], ['AnswerValue', 4], ['QuestionId', $practice->practiceQuestions->id]])->first();
        //         elseif ($type == 'comp') {
        //             //get Emails id for a company
        //             $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
        //             $Favorable_reslut = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue','>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
        //         }
        //         //sector
        //         elseif ($type == 'sec') {
        //             //get Emails id for a company
        //             $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
        //             $Favorable_reslut = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue','>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
        //         }
        //         if ($Favorable_reslut) {
        //             $sum_answer_value_Favorable = $Favorable_reslut->sum;
        //             $Favorable_count = $Favorable_reslut->count;
        //         } else {
        //             $sum_answer_value_Favorable = 0;
        //             $Favorable_count = 0;
        //         }
        //         if ($type == 'all')
        //             $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereOr([['SurveyId', $this->id], ['AnswerValue', 1], ['QuestionId', $practice->practiceQuestions->id]])->first();
        //         elseif ($type == 'comp') {
        //             //get Emails id for a company
        //             $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
        //             $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue','<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
        //         }
        //         //sector
        //         elseif ($type == 'sec') {
        //             //get Emails id for a company
        //             $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
        //             $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue','<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
        //         }
        //         if ($UnFavorable_result) {
        //             $sum_answer_value_UnFavorable = $UnFavorable_result->sum;
        //             $UnFavorable_count = $UnFavorable_result->count;
        //         } else {
        //             $sum_answer_value_UnFavorable = 0;
        //             $UnFavorable_count = 0;
        //         }
        //         if ($type == 'all')
        //             $sum_answer_value_Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->first();
        //         elseif ($type == 'comp') {
        //             $sum_answer_value_Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
        //         }
        //         //sector
        //         elseif ($type == 'sec') {
        //             $sum_answer_value_Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
        //         }

        //         if ($sum_answer_value_Nuetral_result) {
        //             $sum_answer_value_Nuetral = $sum_answer_value_Nuetral_result->sum;
        //             $Nuetral_count = $sum_answer_value_Nuetral_result->count;
        //         } else {
        //             $sum_answer_value_Nuetral = 0;
        //             $Nuetral_count = 0;
        //         }
        //         $Outcome_practice_results = [
        //             'function' => $function->id,
        //             'practice_id' => $practice->id,
        //             'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
        //             'Nuetral_score' => number_format(($sum_answer_value_Nuetral / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2),
        //             'Favorable_score' => number_format(($sum_answer_value_Favorable / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2),
        //             'UnFavorable_score' => number_format(($sum_answer_value_UnFavorable / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2),
        //             //get count of Favorable answers
        //             'Favorable_count' => $Favorable_count,
        //             //get count of UnFavorable answers
        //             'UnFavorable_count' => $UnFavorable_count,
        //             //get count of Nuetral answers
        //             'Nuetral_count' => $Nuetral_count,
        //         ];
        //         if ($practice->practiceQuestions->IsENPS) {
        //             $Favorable = number_format(($sum_answer_value_Favorable / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2);
        //             $UnFavorable = number_format(($sum_answer_value_UnFavorable / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2);
        //             $ENPS_data_array = [
        //                 'function' => $function->id,
        //                 'practice_id' => $practice->id,
        //                 'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
        //                 'Nuetral_score' => number_format(($sum_answer_value_Nuetral / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2),
        //                 //get count of Favorable answers
        //                 'Favorable_count' => $Favorable_count,
        //                 //get count of UnFavorable answers
        //                 'UnFavorable_count' => $UnFavorable_count,
        //                 //get count of Nuetral answers
        //                 'Nuetral_count' => $Nuetral_count,
        //                 'Favorable_score' => $Favorable,
        //                 'UnFavorable_score' => $UnFavorable,
        //                 'ENPS_index' => ($Favorable - $UnFavorable),
        //             ];
        //         }
        //         $function_Nuetral_sum += $sum_answer_value_Nuetral;
        //         $function_Favorable_sum += $sum_answer_value_Favorable;
        //         $function_UnFavorable_sum += $sum_answer_value_UnFavorable;
        //         $function_Nuetral_count += $Nuetral_count;
        //         $function_Favorable_count += $Favorable_count;
        //         $function_UnFavorable_count += $UnFavorable_count;
        //         array_push($outcome_functions_practice, $Outcome_practice_results);
        //     }
        //     $out_come_favorable = number_format(($function_Favorable_sum / ($function_Favorable_sum + $function_Nuetral_sum + $function_UnFavorable_sum)) * 100, 2);
        //     $out_come_unfavorable = number_format(($function_UnFavorable_sum / ($function_Favorable_sum + $function_Nuetral_sum + $function_UnFavorable_sum)) * 100, 2);
        //     //setup function_results
        //     $outcome_function_results = [
        //         'function' => $function->id,
        //         'function_title' => App()->getLocale() == 'en' ? $function->FunctionTitle : $function->FunctionTitleAr,
        //         'Nuetral_score' => number_format(($function_Nuetral_sum / ($function_Favorable_sum + $function_Nuetral_sum + $function_UnFavorable_sum)) * 100, 2),
        //         'Favorable_score' => $out_come_favorable,
        //         'UnFavorable_score' => $out_come_unfavorable,
        //         //get count of Favorable answers
        //         'Favorable_count' => $function_Favorable_count,
        //         //get count of UnFavorable answers
        //         'UnFavorable_count' => $function_UnFavorable_count,
        //         //get count of Nuetral answers
        //         'Nuetral_count' => $function_Nuetral_count,
        //         'outcome_index' => $out_come_favorable - $out_come_unfavorable
        //     ];
        //     array_push($outcome_function_results_1, $outcome_function_results);
        // }
        // // $ENPS_data_array = collect($ENPS_data_array)->sortBy('ENPS_index')->reverse()->toArray();
        // // $ENPS_data_array = array_slice($ENPS_data_array, 0, 3);
        // // $ENPS_data_array = collect($ENPS_data_array)->sortBy('ENPS_index')->toArray();
        // $data = [
        //     'drivers' => $driver_functions_practice,
        //     'drivers_functions' => $overall_per_fun,
        //     'outcomes' => $outcome_function_results_1,
        //     'ENPS_data_array' => $ENPS_data_array,
        //     'entity' => $entity,
        //     'type' => $type,
        //     'type_id' => $type_id,
        //     'id' => $id
        // ];

    }
    public function alzubair_resultC($id, $type, $type_id = null)
    {
        $data = $this->get_resultc($id, $type, $type_id);
        return view('SurveyAnswers.new-results')->with($data);
    }
    public function alzubair_resultD($id, $type, $type_id = null)
    {
        if ($type == "comp") {
            $data = $this->get_resultd($id, $type, $type_id);
        } elseif ($type == "sec") {
            $data = $this->get_SectorResult($id, $type, $type_id);
        } else {
            $data = $this->get_GroupResult($id, $type, $type_id);
        }
        // Log::info($data);
        // $test = collect($data);
        // return $data;
        return view('SurveyAnswers.new-results')->with($data);
    }
    function statistics($id, $clientID)
    {
        //get all emails where survey id =$id
        $number_all_respondent = 0;
        $minutes = 5;
        $this->id = $id;
        $this->clientID = $clientID;
        // $number_all_respondent =  Cache::remember('number_all_respondent', $minutes, function () {
        //     return Emails::where('SurveyId', $this->id)->count();
        // });
        $number_all_respondent = 5551;
        $number_all_respondent_answers = Cache::remember('number_all_respondent_answers', $minutes, function () {
            return SurveyAnswers::where('SurveyId', $this->id)->distinct('AnsweredBy')->count();
        });
        //get all sectors where client id =clientID
        $sectors = Cache::remember('sectors', $minutes, function () {
            return Sectors::where('client_id', $this->clientID)->get();
        });
        //pluck sector IDs to an array
        $sectors_ids = $sectors->pluck('id')->all();
        //get all companies for each sector
        $companies_list = collect([]);
        //get all departments
        $dep_list = collect([]);
        foreach ($sectors as $sector) {
            $companies = $sector->companies;
            //push companies to  companies_list object
            $companies_list = $companies_list->merge($companies);
            foreach ($companies as $company) {
                $dep_list = $dep_list->merge($company->departments);
            }
        }
        //pluck companies IDs to an array
        $companies_ids = $companies_list->pluck('id')->all();
        //pluck departments IDs to an array
        $dep_ids = $dep_list->pluck('id')->all();
        // Log::info($dep_ids);
        //get all emails where survey id =$id and foreach sectors
        $sector_emails = [];

        $companies_emails = [];
        $sectors_details = [];
        $companies_details = [];
        //sector-wise statistics
        foreach ($sectors as $sector) {
            $sector_emails = [];
            $number_of_emails = 0;
            switch ($sector->sector_name_en) {
                case 'THE ZUBAIR CORPORATION':
                    $number_of_emails = 84;
                    break;
                case 'Zubair Investments':
                    $number_of_emails = 125;
                    break;
                case 'Digitizationan & Information Technology':
                    $number_of_emails = 93;
                    break;
                case 'Education':
                    $number_of_emails = 377;
                    break;
                case 'Energy & Natural Resources':
                    $number_of_emails = 220;
                    break;
                case 'Fast Moving Consumer Good':
                    $number_of_emails = 2451;
                    break;
                case 'Industrial & Chemical':
                    $number_of_emails = 574;
                    break;
                case 'Mobility & Equipment':
                    $number_of_emails = 686;
                    break;
                case 'Real Estate':
                    $number_of_emails = 80;
                    break;
                case 'Smart Electrification & Automation':
                    $number_of_emails = 867;
                    break;
                case 'Other':
                    $number_of_emails = 21;
                    break;
                default:
                    $number_of_emails = 1;
                    break;
            }
            $this->number_emails += Emails::where([['SurveyId', $id], ['sector_id', $sector->id]])->count();
            foreach (Emails::where([['SurveyId', $id], ['sector_id', $sector->id]])->get() as $em) {
                array_push($sector_emails, $em->id);
            }
            $number_of_emails > 0 ?
                $this->number_response = SurveyAnswers::where('SurveyId', $id)->whereIn('AnsweredBy', $sector_emails)->distinct('AnsweredBy')->count('AnsweredBy') : 0;
            // chunck survey answers to get count

            $sector_details = [
                'sector_name' => App()->getLocale() == 'en' ? $sector->sector_name_en : $sector->sector_name_ar,
                'sector_id' => $sector->id,
                'sector_emails' => $number_of_emails,
                'sector_answers' => $this->number_response,
            ];
            array_push($sectors_details, $sector_details);
            foreach ($sector->companies as $company) {
                //pluck of id
                $number_of_emails_comp = 0;
                $emails_comp = Emails::where([['SurveyId', $id], ['sector_id', $sector->id], ['comp_id', $company->id]])->pluck('id')->all();
                $this->number_response = SurveyAnswers::where('SurveyId', $id)->whereIn('AnsweredBy', $emails_comp)->distinct('AnsweredBy')->count('AnsweredBy');

                switch ($company->company_name_en) {
                    case 'The Zubair Corporation':
                        $number_of_emails_comp = 76;
                        break;
                    case 'BAZF':
                        $number_of_emails_comp = 34;
                        break;
                    case 'JO':
                        $number_of_emails_comp = 15;
                        break;
                    case 'PC-Imaging':
                        $number_of_emails_comp = 9;
                        break;
                    case 'PHOTOCENTRE':
                        $number_of_emails_comp = 12;
                        break;
                    case 'SPARK':
                        $number_of_emails_comp = 11;
                        break;
                    case 'OMAN COMPUTER SERVICES LLC':
                        $number_of_emails_comp = 93;
                        break;
                    case 'Azzan Bin Qais International School':
                        $number_of_emails_comp = 130;
                        break;
                    case 'As Seeb International School':
                        $number_of_emails_comp = 124;
                        break;
                    case 'Sohar International School':
                        $number_of_emails_comp = 116;
                        break;
                    case 'ARA PETROLEUM OMAN B44 LIMITED':
                        $number_of_emails_comp = 63;
                        break;
                    case 'ARA Petroleum E&P LLC':
                        $number_of_emails_comp = 154;
                        break;
                    case 'AL MUZN':
                        $number_of_emails_comp = 59;
                        break;
                    case 'OLC':
                        $number_of_emails_comp = 51;
                        break;
                    case 'OWC':
                        $number_of_emails_comp = 1076;
                        break;
                    case 'Mobility & Equipment':
                        $number_of_emails_comp = 686;
                        break;
                    case 'Romana Water':
                        $number_of_emails_comp = 716;
                        break;
                    case 'Al Arabiya Mineral Water and Packaging Factory':
                        $number_of_emails_comp = 549;
                        break;
                    case 'ELCO':
                        $number_of_emails_comp = 289;
                        break;
                    case 'Jaidah Energy LLC':
                        $number_of_emails_comp = 84;
                        break;
                    case 'Oman Oil Industry Supplies & Services Company LLC':
                        $number_of_emails_comp = 148;
                        break;
                    case 'Solentis':
                        $number_of_emails_comp = 25;
                        break;
                    case 'GAC':
                        $number_of_emails_comp = 475;
                        break;
                    case 'IHE':
                        $number_of_emails_comp = 139;
                        break;
                    case 'SRT':
                        $number_of_emails_comp = 33;
                        break;
                    case 'ZAG':
                        $number_of_emails_comp = 44;
                        break;
                    case 'Barr Al Jissah':
                        $number_of_emails_comp = 21;
                        break;
                    case 'HEMZ UAE':
                        $number_of_emails_comp = 5;
                        break;
                    case 'INMA PROPERTY DEVELOPMENT LLC':
                        $number_of_emails_comp = 47;
                        break;
                    case 'ZUBAIR ELECTRIC':
                        $number_of_emails_comp = 53;
                        break;
                    case 'Federal Transformers & Switchgears LLC':
                        $number_of_emails_comp = 67;
                        break;
                    case 'Business International Group LLC':
                        $number_of_emails_comp = 86;
                        break;
                    case 'AL ZUBAIR GENERAL TRADING LLC':
                        $number_of_emails_comp = 134;
                        break;
                    case 'ZAKHER ELECTRIC WARE EST':
                        $number_of_emails_comp = 16;
                        break;
                    case 'AL ZUBAIR ELECTRICAL APPLIANCES':
                        $number_of_emails_comp = 12;
                        break;
                    case 'SPECTRA INTERNATIONAL':
                        $number_of_emails_comp = 42;
                        break;
                    case 'ZEEMAN SERVICES & SOLUTIONS WLL':
                        $number_of_emails_comp = 14;
                        break;
                    case '4000-Federal Transformers Company LLC':
                        $number_of_emails_comp = 388;
                        break;
                    case 'Zakher Education Development Company':
                        $number_of_emails_comp = 7;
                        break;
                    case 'WILMAR INTERNATIONAL LLC':
                        $number_of_emails_comp = 4;
                        break;
                    case 'AL ZUBAIR TRADING ESTABLISHMENT':
                        $number_of_emails_comp = 6;
                        break;
                    case 'ARA Petroleum LLC':
                        $number_of_emails_comp = 3;
                        break;
                    case '4010-Federal Power Transformers LLC':
                        $number_of_emails_comp = 83;
                        break;
                    default:
                        $number_of_emails_comp = count($emails_comp);;
                        break;
                }
                $company_details = [
                    'company_name' => App()->getLocale() == 'en' ? $company->company_name_en : $company->company_name_ar,
                    'company_id' => $company->id,
                    //get all emails with comp_id = $company->id
                    'company_emails' => $number_of_emails_comp,
                    'company_answers' => $this->number_response,
                    //sector name
                    'sector_name' => App()->getLocale() == 'en' ? $company->sectors->sector_name_en : $company->sectors->sector_name_ar,
                    //response rate
                    'response_rate' => round(($this->number_response / $number_of_emails_comp), 2) * 100,

                ];
                array_push($companies_details, $company_details);
            }
        }
        //company-wise statistics

        $data = [
            'number_all_respondent' => $number_all_respondent,
            'number_all_respondent_answers' => $number_all_respondent_answers,
            'sectors' => $sectors->count(),
            'companies' => count($companies_list),
            'departments' => count($dep_list),
            'id' => $id,
            'sectors_details' => $sectors_details,
            'company_details' => $companies_details,
        ];
        return view('SurveyAnswers.statistics')->with($data);
    }
    public function get_result($id, $type, $type_id = null)
    {
        $overall_per_fun = array();
        $driver_functions_practice = array();
        $heat_map = array();

        $practice_results = [];
        $ENPS_data_array = [];
        $outcome_functions_practice = array();
        $Outcome_practice_results = [];
        $function_results = [];
        $outcome_function_results = [];
        $outcome_function_results_1 = array();
        $entity = "";
        $this->id = $id;
        if ($type == "comp") { //find the company name
            $entity = Companies::find($type_id)->company_name_en;
        }
        //sector
        elseif ($type == "sec") {
            $entity = Sectors::find($type_id)->sector_name_en;
        }
        //client
        else {
            $entity = Surveys::find($id)->clients->ClientName;
        }
        foreach (Surveys::find($id)->plan->functions->where('IsDriver', true) as $function) {
            $function_Nuetral_sum = 0;
            $function_Favorable_sum = 0;
            $function_UnFavorable_sum = 0;
            $function_Nuetral_count = 0;
            $function_Favorable_count = 0;
            $function_UnFavorable_count = 0;
            foreach ($function->functionPractices as $practice) {
                $Favorable_result = [];
                $UnFavorable_result = [];
                $Nuetral_result = [];
                //get sum of answer value from survey answers
                if ($type == 'all') {
                    $Favorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->first();
                } elseif ($type == 'comp') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $Favorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $Favorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }

                if ($Favorable_result) {
                    $sum_answer_value_Favorable = $Favorable_result->sum;
                    $Favorable_count = $Favorable_result->count;
                } else {
                    $sum_answer_value_Favorable = 0;
                    $Favorable_count = 0;
                }
                if ($type == 'all')
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->first();
                elseif ($type == 'comp') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }

                if ($UnFavorable_result) {
                    $sum_answer_value_UnFavorable = $UnFavorable_result->sum;
                    $UnFavorable_count = $UnFavorable_result->count;
                } else {
                    $sum_answer_value_UnFavorable = 0;
                    $UnFavorable_count = 0;
                }
                if ($type == 'all')
                    $Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->first();
                elseif ($type == 'comp') {
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                if ($Nuetral_result) {
                    $sum_answer_value_Nuetral = $Nuetral_result->sum;
                    $Nuetral_count = $Nuetral_result->count;
                } else {
                    $sum_answer_value_Nuetral = 0;
                    $Nuetral_count = 0;
                }
                $practice_results = [
                    'function' => $function->id,
                    'practice_id' => $practice->id,
                    'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                    'Nuetral_score' => $sum_answer_value_Nuetral == 0 ? 0 : number_format(($sum_answer_value_Nuetral / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2),
                    'Favorable_score' => $sum_answer_value_Favorable == 0 ? 0 : number_format(($sum_answer_value_Favorable / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2),
                    'UnFavorable_score' => $sum_answer_value_UnFavorable == 0 ? 0 : number_format(($sum_answer_value_UnFavorable / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2),
                    //get count of Favorable answers
                    'Favorable_count' => $Favorable_count,
                    //get count of UnFavorable answers
                    'UnFavorable_count' => $UnFavorable_count,
                    //get count of Nuetral answers
                    'Nuetral_count' => $Nuetral_count,
                ];
                $function_Nuetral_sum += $sum_answer_value_Nuetral;
                $function_Favorable_sum += $sum_answer_value_Favorable;
                $function_UnFavorable_sum += $sum_answer_value_UnFavorable;
                $function_Nuetral_count += $Nuetral_count;
                $function_Favorable_count += $Favorable_count;
                $function_UnFavorable_count += $UnFavorable_count;
                array_push($driver_functions_practice, $practice_results);
            }
            //setup function_results
            $function_results = [
                'function' => $function->id,
                'function_title' => App()->getLocale() == 'en' ? $function->FunctionTitle : $function->FunctionTitleAr,
                'Nuetral_score' => $function_Nuetral_sum == 0 ? 0 : number_format(($function_Nuetral_sum / ($function_Favorable_sum + $function_Nuetral_sum + $function_UnFavorable_sum)) * 100, 2),
                'Favorable_score' => $function_Favorable_sum == 0 ? 0 : number_format(($function_Favorable_sum / ($function_Favorable_sum + $function_Nuetral_sum + $function_UnFavorable_sum)) * 100, 2),
                'UnFavorable_score' => $function_UnFavorable_sum == 0 ? 0 : number_format(($function_UnFavorable_sum / ($function_Favorable_sum + $function_Nuetral_sum + $function_UnFavorable_sum)) * 100, 2),
                //get count of Favorable answers
                'Favorable_count' => $function_Favorable_count,
                //get count of UnFavorable answers
                'UnFavorable_count' => $function_UnFavorable_count,
                //get count of Nuetral answers
                'Nuetral_count' => $function_Nuetral_count,
            ];
            array_push($overall_per_fun, $function_results);
        }
        // dd($overall_per_fun);
        foreach (Surveys::find($id)->plan->functions->where('IsDriver', false) as $function) {
            $function_Nuetral_sum = 0;
            $function_Favorable_sum = 0;
            $function_UnFavorable_sum = 0;
            $function_Nuetral_count = 0;
            $function_Favorable_count = 0;
            $function_UnFavorable_count = 0;
            foreach ($function->functionPractices as $practice) {
                //get sum of answer value from survey answers
                if ($type == 'all')
                    $Favorable_reslut = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 5], ['QuestionId', $practice->practiceQuestions->id]])->whereOr([['SurveyId', $this->id], ['AnswerValue', 4], ['QuestionId', $practice->practiceQuestions->id]])->first();
                elseif ($type == 'comp') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $Favorable_reslut = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $Favorable_reslut = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                if ($Favorable_reslut) {
                    $sum_answer_value_Favorable = $Favorable_reslut->sum;
                    $Favorable_count = $Favorable_reslut->count;
                } else {
                    $sum_answer_value_Favorable = 0;
                    $Favorable_count = 0;
                }
                if ($type == 'all')
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereOr([['SurveyId', $this->id], ['AnswerValue', 1], ['QuestionId', $practice->practiceQuestions->id]])->first();
                elseif ($type == 'comp') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                if ($UnFavorable_result) {
                    $sum_answer_value_UnFavorable = $UnFavorable_result->sum;
                    $UnFavorable_count = $UnFavorable_result->count;
                } else {
                    $sum_answer_value_UnFavorable = 0;
                    $UnFavorable_count = 0;
                }
                if ($type == 'all')
                    $sum_answer_value_Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->first();
                elseif ($type == 'comp') {
                    $sum_answer_value_Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    $sum_answer_value_Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }

                if ($sum_answer_value_Nuetral_result) {
                    $sum_answer_value_Nuetral = $sum_answer_value_Nuetral_result->sum;
                    $Nuetral_count = $sum_answer_value_Nuetral_result->count;
                } else {
                    $sum_answer_value_Nuetral = 0;
                    $Nuetral_count = 0;
                }
                $Outcome_practice_results = [
                    'function' => $function->id,
                    'practice_id' => $practice->id,
                    'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                    'Nuetral_score' => number_format(($sum_answer_value_Nuetral / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2),
                    'Favorable_score' => number_format(($sum_answer_value_Favorable / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2),
                    'UnFavorable_score' => number_format(($sum_answer_value_UnFavorable / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2),
                    //get count of Favorable answers
                    'Favorable_count' => $Favorable_count,
                    //get count of UnFavorable answers
                    'UnFavorable_count' => $UnFavorable_count,
                    //get count of Nuetral answers
                    'Nuetral_count' => $Nuetral_count,
                ];
                if ($practice->practiceQuestions->IsENPS) {
                    $Favorable = number_format(($sum_answer_value_Favorable / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2);
                    $UnFavorable = number_format(($sum_answer_value_UnFavorable / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2);
                    $ENPS_data_array = [
                        'function' => $function->id,
                        'practice_id' => $practice->id,
                        'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                        'Nuetral_score' => number_format(($sum_answer_value_Nuetral / ($sum_answer_value_Favorable + $sum_answer_value_Nuetral + $sum_answer_value_UnFavorable)) * 100, 2),
                        //get count of Favorable answers
                        'Favorable_count' => $Favorable_count,
                        //get count of UnFavorable answers
                        'UnFavorable_count' => $UnFavorable_count,
                        //get count of Nuetral answers
                        'Nuetral_count' => $Nuetral_count,
                        'Favorable_score' => $Favorable,
                        'UnFavorable_score' => $UnFavorable,
                        'ENPS_index' => ($Favorable - $UnFavorable),
                    ];
                }
                $function_Nuetral_sum += $sum_answer_value_Nuetral;
                $function_Favorable_sum += $sum_answer_value_Favorable;
                $function_UnFavorable_sum += $sum_answer_value_UnFavorable;
                $function_Nuetral_count += $Nuetral_count;
                $function_Favorable_count += $Favorable_count;
                $function_UnFavorable_count += $UnFavorable_count;
                array_push($outcome_functions_practice, $Outcome_practice_results);
            }
            $out_come_favorable = number_format(($function_Favorable_sum / ($function_Favorable_sum + $function_Nuetral_sum + $function_UnFavorable_sum)) * 100, 2);
            $out_come_unfavorable = number_format(($function_UnFavorable_sum / ($function_Favorable_sum + $function_Nuetral_sum + $function_UnFavorable_sum)) * 100, 2);
            //setup function_results
            $outcome_function_results = [
                'function' => $function->id,
                'function_title' => App()->getLocale() == 'en' ? $function->FunctionTitle : $function->FunctionTitleAr,
                'Nuetral_score' => number_format(($function_Nuetral_sum / ($function_Favorable_sum + $function_Nuetral_sum + $function_UnFavorable_sum)) * 100, 2),
                'Favorable_score' => $out_come_favorable,
                'UnFavorable_score' => $out_come_unfavorable,
                //get count of Favorable answers
                'Favorable_count' => $function_Favorable_count,
                //get count of UnFavorable answers
                'UnFavorable_count' => $function_UnFavorable_count,
                //get count of Nuetral answers
                'Nuetral_count' => $function_Nuetral_count,
                'outcome_index' => $out_come_favorable
            ];
            array_push($outcome_function_results_1, $outcome_function_results);
        }
        // $ENPS_data_array = collect($ENPS_data_array)->sortBy('ENPS_index')->reverse()->toArray();
        // $ENPS_data_array = array_slice($ENPS_data_array, 0, 3);
        // $ENPS_data_array = collect($ENPS_data_array)->sortBy('ENPS_index')->toArray();
        //get first three highest items
        //sort $driver_functions_practice asc
        $driver_functions_practice_asc = array_slice(collect($driver_functions_practice)->sortBy('Favorable_score')->toArray(), 0, 3);
        //sort $driver_functions_practice desc
        $driver_functions_practice_desc = array_slice(collect($driver_functions_practice)->sortByDesc('Favorable_score')->toArray(), 0, 3);

        if ($type == 'all') {
            //get all sectors of current client
            $sectors = Sectors::where('client_id', Surveys::find($id)->ClientId)->get();
            foreach ($sectors as $sector) {
                $heat_map_indecators = array();
                $ENPS_Favorable = null;
                $ENPS_Pushed = false;
                foreach (Surveys::find($id)->plan->functions/* ->where('IsDriver', false) */ as $function) {
                    //$sum_function_answer_value_Favorable_HM
                    $function_Favorable_sum_HM = 0;
                    $function_UnFavorable_sum_HM = 0;
                    $function_Nuetral_sum_HM = 0;
                    foreach ($function->functionPractices as $practice) {
                        $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $sector->id)->pluck('id')->all();
                        $Favorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        $UnFavorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        $Nuetral_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        if ($Favorable_result_HM) {
                            $sum_answer_value_Favorable_HM = $Favorable_result_HM->sum;
                            $Favorable_count_HM = $Favorable_result_HM->count;
                        } else {
                            $sum_answer_value_Favorable_HM = 0;
                            $Favorable_count_HM = 0;
                        }
                        if ($UnFavorable_result_HM) {
                            $sum_answer_value_UnFavorable_HM = $UnFavorable_result_HM->sum;
                            $UnFavorable_count_HM = $UnFavorable_result_HM->count;
                        } else {
                            $sum_answer_value_UnFavorable_HM = 0;
                            $UnFavorable_count_HM = 0;
                        }
                        if ($Nuetral_result_HM) {
                            $sum_answer_value_Nuetral_HM = $Nuetral_result_HM->sum;
                            $Nuetral_count_HM = $Nuetral_result_HM->count;
                        } else {
                            $sum_answer_value_Nuetral_HM = 0;
                            $Nuetral_count_HM = 0;
                        }
                        if ($practice->practiceQuestions->IsENPS && $ENPS_Favorable == null) {
                            $ENPS_Favorable = number_format(($sum_answer_value_Favorable_HM / ($sum_answer_value_Favorable_HM + $sum_answer_value_Nuetral_HM + $sum_answer_value_UnFavorable_HM)) * 100, 2);
                        }
                        $function_Favorable_sum_HM += $sum_answer_value_Favorable_HM;
                        $function_UnFavorable_sum_HM += $sum_answer_value_UnFavorable_HM;
                        $function_Nuetral_sum_HM += $sum_answer_value_Nuetral_HM;
                    }
                    $out_come_favorable_HM = number_format(($function_Favorable_sum_HM / ($function_Favorable_sum_HM + $function_Nuetral_sum_HM + $function_UnFavorable_sum_HM)) * 100, 2);
                    if ($function->IsDriver) {
                        $title = explode(" ", $function->FunctionTitle);
                        $title = $title[0];
                    } else
                        $title = 'Engagement';
                    $outcome_function_results_HM = [
                        'function_title' => $title,
                        'score' => $out_come_favorable_HM,
                    ];
                    array_push($heat_map_indecators, $outcome_function_results_HM);
                    if ($ENPS_Favorable && !$ENPS_Pushed) {
                        $ENPS_Pushed = true;
                        $outcome_function_results_HM = [
                            'function_title' => $title,
                            'score' => $ENPS_Favorable,
                        ];
                        array_push($heat_map_indecators, $outcome_function_results_HM);
                    }
                }
                $heat_map_item = [
                    'entity_name' => App()->getLocale() == 'en' ? $sector->sector_name_en : $sector->sector_name_ar,
                    'entity_id' => $sector->id,
                    'indecators' => $heat_map_indecators,
                ];
                array_push($heat_map, $heat_map_item);
            }
        }
        //if type =sec
        elseif ($type == 'sec') {
            //get all companies of current sector
            $companies = Companies::where('sector_id', $type_id)->get();
            foreach ($companies as $company) {
                $heat_map_indecators = array();
                $ENPS_Favorable = null;
                $ENPS_Pushed = false;
                foreach (Surveys::find($id)->plan->functions/* ->where('IsDriver', false) */ as $function) {
                    //$sum_function_answer_value_Favorable_HM
                    $function_Favorable_sum_HM = 0;
                    $function_UnFavorable_sum_HM = 0;
                    $function_Nuetral_sum_HM = 0;
                    foreach ($function->functionPractices as $practice) {
                        $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $company->id)->pluck('id')->all();
                        $Favorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        $UnFavorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        $Nuetral_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        if ($Favorable_result_HM) {
                            $sum_answer_value_Favorable_HM = $Favorable_result_HM->sum;
                            $Favorable_count_HM = $Favorable_result_HM->count;
                        } else {
                            $sum_answer_value_Favorable_HM = 0;
                            $Favorable_count = 0;
                        }
                        if ($UnFavorable_result_HM) {
                            $sum_answer_value_UnFavorable_HM = $UnFavorable_result_HM->sum;
                            $UnFavorable_count_HM = $UnFavorable_result_HM->count;
                        } else {
                            $sum_answer_value_UnFavorable_HM = 0;
                            $UnFavorable_count_HM = 0;
                        }
                        if ($Nuetral_result_HM) {
                            $sum_answer_value_Nuetral_HM = $Nuetral_result_HM->sum;
                            $Nuetral_count_HM = $Nuetral_result_HM->count;
                        } else {
                            $sum_answer_value_Nuetral_HM = 0;
                            $Nuetral_count_HM = 0;
                        }
                        if ($practice->practiceQuestions->IsENPS && $ENPS_Favorable == null) {
                            $ENPS_Favorable = number_format(($sum_answer_value_Favorable_HM / ($sum_answer_value_Favorable_HM + $sum_answer_value_Nuetral_HM + $sum_answer_value_UnFavorable_HM)) * 100, 2);
                        }
                        $function_Favorable_sum_HM += $sum_answer_value_Favorable_HM;
                        $function_UnFavorable_sum_HM += $sum_answer_value_UnFavorable_HM;
                        $function_Nuetral_sum_HM += $sum_answer_value_Nuetral_HM;
                    }
                    $out_come_favorable_HM = number_format(($function_Favorable_sum_HM / ($function_Favorable_sum_HM + $function_Nuetral_sum_HM + $function_UnFavorable_sum_HM)) * 100, 2);
                    if ($function->IsDriver) {
                        $title = explode(" ", $function->FunctionTitle);
                        $title = $title[0];
                    } else
                        $title = 'Engagement';
                    $outcome_function_results_HM = [
                        'function_title' => $title,
                        'score' => $out_come_favorable_HM,
                    ];
                    array_push($heat_map_indecators, $outcome_function_results_HM);
                    if ($ENPS_Favorable && !$ENPS_Pushed) {
                        $ENPS_Pushed = true;
                        $outcome_function_results_HM = [
                            'function_title' => $title,
                            'score' => $ENPS_Favorable,
                        ];
                        array_push($heat_map_indecators, $outcome_function_results_HM);
                    }
                }
                $heat_map_item = [
                    'entity_name' => App()->getLocale() == 'en' ? $company->company_name_en : $company->company_name_ar,
                    'entity_id' => $company->id,
                    'indecators' => $heat_map_indecators,
                ];
                array_push($heat_map, $heat_map_item);
            }
        }
        //if type =comp
        elseif ($type == 'comp') {
            $heat_map = [];
        }

        $data = [
            'drivers' => $driver_functions_practice,
            'drivers_functions' => $overall_per_fun,
            'outcomes' => $outcome_function_results_1,
            'ENPS_data_array' => $ENPS_data_array,
            'entity' => $entity,
            'type' => $type,
            'type_id' => $type_id,
            'id' => $id,
            'driver_practice_asc' => $driver_functions_practice_asc,
            'driver_practice_desc' => $driver_functions_practice_desc,
            'heat_map' => $heat_map,
            'cal_type' => 'sum'
        ];
        return $data;
    }
    public function get_resultc($id, $type, $type_id = null)
    {
        $overall_per_fun = array();
        $driver_functions_practice = array();
        $heat_map = array();

        $practice_results = [];
        $ENPS_data_array = [];
        $outcome_functions_practice = array();
        $Outcome_practice_results = [];
        $function_results = [];
        $outcome_function_results = [];
        $outcome_function_results_1 = array();
        $entity = "";
        $this->id = $id;
        if ($type == "comp") { //find the company name
            $entity = Companies::find($type_id)->company_name_en;
        }
        //sector
        elseif ($type == "sec") {
            $entity = Sectors::find($type_id)->sector_name_en;
        }
        //client
        else {
            $entity = "AL-Zubair Group";
        }
        foreach (Surveys::find($id)->plan->functions->where('IsDriver', true) as $function) {
            $function_Nuetral_sum = 0;
            $function_Favorable_sum = 0;
            $function_UnFavorable_sum = 0;
            $function_Nuetral_count = 0;
            $function_Favorable_count = 0;
            $function_UnFavorable_count = 0;
            foreach ($function->functionPractices as $practice) {
                $Favorable_result = [];
                $UnFavorable_result = [];
                $Nuetral_result = [];
                //get sum of answer value from survey answers
                if ($type == 'all') {
                    $Favorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->first();
                } elseif ($type == 'comp') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $Favorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $Favorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }

                if ($Favorable_result) {
                    $sum_answer_value_Favorable = $Favorable_result->sum;
                    $Favorable_count = $Favorable_result->count;
                } else {
                    $sum_answer_value_Favorable = 0;
                    $Favorable_count = 0;
                }
                if ($type == 'all')
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->first();
                elseif ($type == 'comp') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }

                if ($UnFavorable_result) {
                    $sum_answer_value_UnFavorable = $UnFavorable_result->sum;
                    $UnFavorable_count = $UnFavorable_result->count;
                } else {
                    $sum_answer_value_UnFavorable = 0;
                    $UnFavorable_count = 0;
                }
                if ($type == 'all')
                    $Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->first();
                elseif ($type == 'comp') {
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                if ($Nuetral_result) {
                    $sum_answer_value_Nuetral = $Nuetral_result->sum;
                    $Nuetral_count = $Nuetral_result->count;
                } else {
                    $sum_answer_value_Nuetral = 0;
                    $Nuetral_count = 0;
                }
                $practice_results = [
                    'function' => $function->id,
                    'practice_id' => $practice->id,
                    'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                    'Nuetral_score' => $Nuetral_count == 0 ? 0 : number_format(($Nuetral_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    'Favorable_score' => $Favorable_count == 0 ? 0 : number_format(($Favorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    'UnFavorable_score' => $UnFavorable_count == 0 ? 0 : number_format(($UnFavorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    //get count of Favorable answers
                    'Favorable_count' => $Favorable_count,
                    //get count of UnFavorable answers
                    'UnFavorable_count' => $UnFavorable_count,
                    //get count of Nuetral answers
                    'Nuetral_count' => $Nuetral_count,
                ];
                $function_Nuetral_sum += $sum_answer_value_Nuetral;
                $function_Favorable_sum += $sum_answer_value_Favorable;
                $function_UnFavorable_sum += $sum_answer_value_UnFavorable;
                $function_Nuetral_count += $Nuetral_count;
                $function_Favorable_count += $Favorable_count;
                $function_UnFavorable_count += $UnFavorable_count;
                array_push($driver_functions_practice, $practice_results);
            }
            //setup function_results
            $function_results = [
                'function' => $function->id,
                'function_title' => App()->getLocale() == 'en' ? $function->FunctionTitle : $function->FunctionTitleAr,
                'Nuetral_score' => $function_Nuetral_count == 0 ? 0 : number_format(($function_Nuetral_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2),
                'Favorable_score' => $function_Favorable_count == 0 ? 0 : number_format(($function_Favorable_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2),
                'UnFavorable_score' => $function_UnFavorable_count == 0 ? 0 : number_format(($function_UnFavorable_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2),
                //get count of Favorable answers
                'Favorable_count' => $function_Favorable_count,
                //get count of UnFavorable answers
                'UnFavorable_count' => $function_UnFavorable_count,
                //get count of Nuetral answers
                'Nuetral_count' => $function_Nuetral_count,
            ];
            array_push($overall_per_fun, $function_results);
        }
        // dd($overall_per_fun);
        foreach (Surveys::find($id)->plan->functions->where('IsDriver', false) as $function) {
            $function_Nuetral_sum = 0;
            $function_Favorable_sum = 0;
            $function_UnFavorable_sum = 0;
            $function_Nuetral_count = 0;
            $function_Favorable_count = 0;
            $function_UnFavorable_count = 0;
            foreach ($function->functionPractices as $practice) {
                //get sum of answer value from survey answers
                if ($type == 'all')
                    $Favorable_reslut = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->first();
                elseif ($type == 'comp') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $Favorable_reslut = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $Favorable_reslut = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                if ($Favorable_reslut) {
                    $sum_answer_value_Favorable = $Favorable_reslut->sum;
                    $Favorable_count = $Favorable_reslut->count;
                } else {
                    $sum_answer_value_Favorable = 0;
                    $Favorable_count = 0;
                }
                if ($type == 'all')
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->first();
                elseif ($type == 'comp') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                if ($UnFavorable_result) {
                    $sum_answer_value_UnFavorable = $UnFavorable_result->sum;
                    $UnFavorable_count = $UnFavorable_result->count;
                } else {
                    $sum_answer_value_UnFavorable = 0;
                    $UnFavorable_count = 0;
                }
                if ($type == 'all')
                    $sum_answer_value_Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->first();
                elseif ($type == 'comp') {
                    $sum_answer_value_Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    $sum_answer_value_Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }

                if ($sum_answer_value_Nuetral_result) {
                    $sum_answer_value_Nuetral = $sum_answer_value_Nuetral_result->sum;
                    $Nuetral_count = $sum_answer_value_Nuetral_result->count;
                } else {
                    $sum_answer_value_Nuetral = 0;
                    $Nuetral_count = 0;
                }
                $Outcome_practice_results = [
                    'function' => $function->id,
                    'practice_id' => $practice->id,
                    'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                    'Nuetral_score' => number_format(($Nuetral_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    'Favorable_score' => number_format(($Favorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    'UnFavorable_score' => number_format(($UnFavorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    //get count of Favorable answers
                    'Favorable_count' => $Favorable_count,
                    //get count of UnFavorable answers
                    'UnFavorable_count' => $UnFavorable_count,
                    //get count of Nuetral nswers
                    'Nuetral_count' => $Nuetral_count,
                ];
                if ($practice->practiceQuestions->IsENPS) {
                    $Favorable = number_format(($Favorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2);
                    $UnFavorable = number_format(($UnFavorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2);
                    $ENPS_data_array = [
                        'function' => $function->id,
                        'practice_id' => $practice->id,
                        'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                        'Nuetral_score' => number_format(($Nuetral_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                        //get count of Favorable answers
                        'Favorable_count' => $Favorable_count,
                        //get count of UnFavorable answers
                        'UnFavorable_count' => $UnFavorable_count,
                        //get count of Nuetral answers
                        'Nuetral_count' => $Nuetral_count,
                        'Favorable_score' => $Favorable,
                        'UnFavorable_score' => $UnFavorable,
                        'ENPS_index' => ($Favorable - $UnFavorable),
                    ];
                }
                $function_Nuetral_sum += $sum_answer_value_Nuetral;
                $function_Favorable_sum += $sum_answer_value_Favorable;
                $function_UnFavorable_sum += $sum_answer_value_UnFavorable;
                $function_Nuetral_count += $Nuetral_count;
                $function_Favorable_count += $Favorable_count;
                $function_UnFavorable_count += $UnFavorable_count;
                array_push($outcome_functions_practice, $Outcome_practice_results);
            }
            $out_come_favorable = number_format(($function_Favorable_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2);
            $out_come_unfavorable = number_format(($function_UnFavorable_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2);
            //setup function_results
            $outcome_function_results = [
                'function' => $function->id,
                'function_title' => App()->getLocale() == 'en' ? $function->FunctionTitle : $function->FunctionTitleAr,
                'Nuetral_score' => number_format(($function_Nuetral_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2),
                'Favorable_score' => $out_come_favorable,
                'UnFavorable_score' => $out_come_unfavorable,
                //get count of Favorable answers
                'Favorable_count' => $function_Favorable_count,
                //get count of UnFavorable answers
                'UnFavorable_count' => $function_UnFavorable_count,
                //get count of Nuetral answers
                'Nuetral_count' => $function_Nuetral_count,
                'outcome_index' => $out_come_favorable
            ];
            array_push($outcome_function_results_1, $outcome_function_results);
        }
        // $ENPS_data_array = collect($ENPS_data_array)->sortBy('ENPS_index')->reverse()->toArray();
        // $ENPS_data_array = array_slice($ENPS_data_array, 0, 3);
        // $ENPS_data_array = collect($ENPS_data_array)->sortBy('ENPS_index')->toArray();
        //get first three highest items
        //sort $driver_functions_practice asc
        $driver_functions_practice_asc = array_slice(collect($driver_functions_practice)->sortBy('Favorable_score')->toArray(), 0, 3);
        //sort $driver_functions_practice desc
        $driver_functions_practice_desc = array_slice(collect($driver_functions_practice)->sortByDesc('Favorable_score')->toArray(), 0, 3);

        if ($type == 'all') {
            //get all sectors of current client
            $sectors = Sectors::where('client_id', Surveys::find($id)->ClientId)->get();
            foreach ($sectors as $sector) {
                $heat_map_indecators = array();
                $ENPS_Favorable = null;
                $ENPS_Pushed = false;
                foreach (Surveys::find($id)->plan->functions/* ->where('IsDriver', false) */ as $function) {
                    //$sum_function_answer_value_Favorable_HM
                    $function_Favorable_sum_HM = 0;
                    $function_UnFavorable_sum_HM = 0;
                    $function_Nuetral_sum_HM = 0;
                    foreach ($function->functionPractices as $practice) {
                        $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $sector->id)->pluck('id')->all();
                        $Favorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        $UnFavorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        $Nuetral_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        if ($Favorable_result_HM) {
                            $sum_answer_value_Favorable_HM = $Favorable_result_HM->sum;
                            $Favorable_count_HM = $Favorable_result_HM->count;
                        } else {
                            $sum_answer_value_Favorable_HM = 0;
                            $Favorable_count_HM = 0;
                        }
                        if ($UnFavorable_result_HM) {
                            $sum_answer_value_UnFavorable_HM = $UnFavorable_result_HM->sum;
                            $UnFavorable_count_HM = $UnFavorable_result_HM->count;
                        } else {
                            $sum_answer_value_UnFavorable_HM = 0;
                            $UnFavorable_count_HM = 0;
                        }
                        if ($Nuetral_result_HM) {
                            $sum_answer_value_Nuetral_HM = $Nuetral_result_HM->sum;
                            $Nuetral_count_HM = $Nuetral_result_HM->count;
                        } else {
                            $sum_answer_value_Nuetral_HM = 0;
                            $Nuetral_count_HM = 0;
                        }
                        if ($practice->practiceQuestions->IsENPS && $ENPS_Favorable == null) {
                            $ENPS_Favorable = number_format(($Favorable_count_HM / ($Favorable_count_HM + $Nuetral_count_HM + $UnFavorable_count_HM)) * 100, 2);
                        }
                        $function_Favorable_sum_HM += $Favorable_count_HM;
                        $function_UnFavorable_sum_HM += $UnFavorable_count_HM;
                        $function_Nuetral_sum_HM += $Nuetral_count_HM;
                    }
                    $out_come_favorable_HM = number_format(($function_Favorable_sum_HM / ($function_Favorable_sum_HM + $function_Nuetral_sum_HM + $function_UnFavorable_sum_HM)) * 100, 2);
                    if ($function->IsDriver) {
                        $title = explode(" ", $function->FunctionTitle);
                        $title = $title[0];
                    } else
                        $title = 'Engagement';
                    $outcome_function_results_HM = [
                        'function_title' => $title,
                        'score' => $out_come_favorable_HM,
                    ];
                    array_push($heat_map_indecators, $outcome_function_results_HM);
                    if ($ENPS_Favorable && !$ENPS_Pushed) {
                        $ENPS_Pushed = true;
                        $outcome_function_results_HM = [
                            'function_title' => $title,
                            'score' => $ENPS_Favorable,
                        ];
                        array_push($heat_map_indecators, $outcome_function_results_HM);
                    }
                }
                $heat_map_item = [
                    'entity_name' => App()->getLocale() == 'en' ? $sector->sector_name_en : $sector->sector_name_ar,
                    'entity_id' => $sector->id,
                    'indecators' => $heat_map_indecators,
                ];
                array_push($heat_map, $heat_map_item);
            }
        }
        //if type =sec
        elseif ($type == 'sec') {
            //get all companies of current sector
            $companies = Companies::where('sector_id', $type_id)->get();
            foreach ($companies as $company) {
                $heat_map_indecators = array();
                $ENPS_Favorable = null;
                $ENPS_Pushed = false;
                foreach (Surveys::find($id)->plan->functions/* ->where('IsDriver', false) */ as $function) {
                    //$sum_function_answer_value_Favorable_HM
                    $function_Favorable_sum_HM = 0;
                    $function_UnFavorable_sum_HM = 0;
                    $function_Nuetral_sum_HM = 0;
                    foreach ($function->functionPractices as $practice) {
                        $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $company->id)->pluck('id')->all();
                        $Favorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        $UnFavorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        $Nuetral_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        if ($Favorable_result_HM) {
                            $sum_answer_value_Favorable_HM = $Favorable_result_HM->sum;
                            $Favorable_count_HM = $Favorable_result_HM->count;
                        } else {
                            $sum_answer_value_Favorable_HM = 0;
                            $Favorable_count = 0;
                        }
                        if ($UnFavorable_result_HM) {
                            $sum_answer_value_UnFavorable_HM = $UnFavorable_result_HM->sum;
                            $UnFavorable_count_HM = $UnFavorable_result_HM->count;
                        } else {
                            $sum_answer_value_UnFavorable_HM = 0;
                            $UnFavorable_count_HM = 0;
                        }
                        if ($Nuetral_result_HM) {
                            $sum_answer_value_Nuetral_HM = $Nuetral_result_HM->sum;
                            $Nuetral_count_HM = $Nuetral_result_HM->count;
                        } else {
                            $sum_answer_value_Nuetral_HM = 0;
                            $Nuetral_count_HM = 0;
                        }
                        if ($practice->practiceQuestions->IsENPS && $ENPS_Favorable == null) {
                            $ENPS_Favorable = number_format(($Favorable_count_HM / ($Favorable_count_HM + $Nuetral_count_HM + $UnFavorable_count_HM)) * 100, 2);
                        }
                        $function_Favorable_sum_HM += $Favorable_count_HM;
                        $function_UnFavorable_sum_HM += $UnFavorable_count_HM;
                        $function_Nuetral_sum_HM += $Nuetral_count_HM;
                    }
                    $out_come_favorable_HM = number_format(($function_Favorable_sum_HM / ($function_Favorable_sum_HM + $function_Nuetral_sum_HM + $function_UnFavorable_sum_HM)) * 100, 2);
                    if ($function->IsDriver) {
                        $title = explode(" ", $function->FunctionTitle);
                        $title = $title[0];
                    } else
                        $title = 'Engagement';
                    $outcome_function_results_HM = [
                        'function_title' => $title,
                        'score' => $out_come_favorable_HM,
                    ];
                    array_push($heat_map_indecators, $outcome_function_results_HM);
                    if ($ENPS_Favorable && !$ENPS_Pushed) {
                        $ENPS_Pushed = true;
                        $outcome_function_results_HM = [
                            'function_title' => $title,
                            'score' => $ENPS_Favorable,
                        ];
                        array_push($heat_map_indecators, $outcome_function_results_HM);
                    }
                }
                $heat_map_item = [
                    'entity_name' => App()->getLocale() == 'en' ? $company->company_name_en : $company->company_name_ar,
                    'entity_id' => $company->id,
                    'indecators' => $heat_map_indecators,
                ];
                array_push($heat_map, $heat_map_item);
            }
        }
        //if type =comp
        elseif ($type == 'comp') {
            $heat_map = [];
        }

        $data = [
            'drivers' => $driver_functions_practice,
            'drivers_functions' => $overall_per_fun,
            'outcomes' => $outcome_function_results_1,
            'ENPS_data_array' => $ENPS_data_array,
            'entity' => $entity,
            'type' => $type,
            'type_id' => $type_id,
            'id' => $id,
            'driver_practice_asc' => $driver_functions_practice_asc,
            'driver_practice_desc' => $driver_functions_practice_desc,
            'heat_map' => $heat_map,
            'cal_type' => 'count'
        ];
        return $data;
    }
    public function get_resultd($id, $type, $type_id = null)
    {
        $overall_per_fun = array();
        $driver_functions_practice = array();
        $heat_map = array();

        $practice_results = [];
        $ENPS_data_array = [];
        $outcome_functions_practice = array();
        $Outcome_practice_results = [];
        $function_results = [];
        $outcome_function_results = [];
        $outcome_function_results_1 = array();
        $entity = "";
        $this->id = $id;
        if ($type == "comp") { //find the company name
            $entity = Companies::find($type_id)->company_name_en;
        }
        //sector
        elseif ($type == "sec") {
            $entity = Sectors::find($type_id)->sector_name_en;
        }
        //client
        else {
            $entity = "AL-Zubair Group";
        }
        foreach (Surveys::find($id)->plan->functions->where('IsDriver', true) as $function) {
            $function_Nuetral_sum = 0;
            $function_Favorable_sum = 0;
            $function_UnFavorable_sum = 0;
            $function_Nuetral_count = 0;
            $function_Favorable_count = 0;
            $function_UnFavorable_count = 0;
            foreach ($function->functionPractices as $practice) {
                //get sum of answer value from survey answers
              if ($type == 'comp') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $Favorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $Favorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }

                if ($Favorable_result) {
                    $sum_answer_value_Favorable = $Favorable_result->sum;
                    $Favorable_count = $Favorable_result->count;
                } else {
                    $sum_answer_value_Favorable = 0;
                    $Favorable_count = 0;
                }
                if ($type == 'comp') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }

                if ($UnFavorable_result) {
                    $sum_answer_value_UnFavorable = $UnFavorable_result->sum;
                    $UnFavorable_count = $UnFavorable_result->count;
                } else {
                    $sum_answer_value_UnFavorable = 0;
                    $UnFavorable_count = 0;
                }
            if ($type == 'comp') {
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                if ($Nuetral_result) {
                    $sum_answer_value_Nuetral = $Nuetral_result->sum;
                    $Nuetral_count = $Nuetral_result->count;
                } else {
                    $sum_answer_value_Nuetral = 0;
                    $Nuetral_count = 0;
                }
                $practice_results = [
                    'function' => $function->id,
                    'practice_id' => $practice->id,
                    'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                    'Nuetral_score' => $Nuetral_count == 0 ? 0 : number_format(($Nuetral_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    'Favorable_score' => $Favorable_count == 0 ? 0 : number_format(($Favorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    'UnFavorable_score' => $UnFavorable_count == 0 ? 0 : number_format(($UnFavorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    //get count of Favorable answers
                    'Favorable_count' => $Favorable_count,
                    //get count of UnFavorable answers
                    'UnFavorable_count' => $UnFavorable_count,
                    //get count of Nuetral answers
                    'Nuetral_count' => $Nuetral_count,
                ];
                $function_Nuetral_sum += $sum_answer_value_Nuetral;
                $function_Favorable_sum += $sum_answer_value_Favorable;
                $function_UnFavorable_sum += $sum_answer_value_UnFavorable;
                $function_Nuetral_count += $Nuetral_count;
                $function_Favorable_count += $Favorable_count;
                $function_UnFavorable_count += $UnFavorable_count;
                array_push($driver_functions_practice, $practice_results);
            }
            //setup function_results
            $function_results = [
                'function' => $function->id,
                'function_title' => App()->getLocale() == 'en' ? $function->FunctionTitle : $function->FunctionTitleAr,
                'Nuetral_score' => $function_Nuetral_count == 0 ? 0 : number_format(($function_Nuetral_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2),
                'Favorable_score' => $function_Favorable_count == 0 ? 0 : number_format(($function_Favorable_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2),
                'UnFavorable_score' => $function_UnFavorable_count == 0 ? 0 : number_format(($function_UnFavorable_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2),
                //get count of Favorable answers
                'Favorable_count' => $function_Favorable_count,
                //get count of UnFavorable answers
                'UnFavorable_count' => $function_UnFavorable_count,
                //get count of Nuetral answers
                'Nuetral_count' => $function_Nuetral_count,
            ];
            array_push($overall_per_fun, $function_results);
        }
        // dd($overall_per_fun);
        foreach (Surveys::find($id)->plan->functions->where('IsDriver', false) as $function) {
            $function_Nuetral_sum = 0;
            $function_Favorable_sum = 0;
            $function_UnFavorable_sum = 0;
            $function_Nuetral_count = 0;
            $function_Favorable_count = 0;
            $function_UnFavorable_count = 0;
            foreach ($function->functionPractices as $practice) {
                //get sum of answer value from survey answers
                if ($type == 'all')
                    $Favorable_reslut = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->first();
                elseif ($type == 'comp') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $Favorable_reslut = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $Favorable_reslut = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                if ($Favorable_reslut) {
                    $sum_answer_value_Favorable = $Favorable_reslut->sum;
                    $Favorable_count = $Favorable_reslut->count;
                } else {
                    $sum_answer_value_Favorable = 0;
                    $Favorable_count = 0;
                }
                if ($type == 'all')
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->first();
                elseif ($type == 'comp') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $type_id)->pluck('id')->all();
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    //get Emails id for a company
                    $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $type_id)->pluck('id')->all();
                    $UnFavorable_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                if ($UnFavorable_result) {
                    $sum_answer_value_UnFavorable = $UnFavorable_result->sum;
                    $UnFavorable_count = $UnFavorable_result->count;
                } else {
                    $sum_answer_value_UnFavorable = 0;
                    $UnFavorable_count = 0;
                }
                if ($type == 'all')
                    $sum_answer_value_Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->first();
                elseif ($type == 'comp') {
                    $sum_answer_value_Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }
                //sector
                elseif ($type == 'sec') {
                    $sum_answer_value_Nuetral_result = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                }

                if ($sum_answer_value_Nuetral_result) {
                    $sum_answer_value_Nuetral = $sum_answer_value_Nuetral_result->sum;
                    $Nuetral_count = $sum_answer_value_Nuetral_result->count;
                } else {
                    $sum_answer_value_Nuetral = 0;
                    $Nuetral_count = 0;
                }
                $Outcome_practice_results = [
                    'function' => $function->id,
                    'practice_id' => $practice->id,
                    'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                    'Nuetral_score' => number_format(($Nuetral_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    'Favorable_score' => number_format(($Favorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    'UnFavorable_score' => number_format(($UnFavorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    //get count of Favorable answers
                    'Favorable_count' => $Favorable_count,
                    //get count of UnFavorable answers
                    'UnFavorable_count' => $UnFavorable_count,
                    //get count of Nuetral nswers
                    'Nuetral_count' => $Nuetral_count,
                ];
                if ($practice->practiceQuestions->IsENPS) {
                    $Favorable = number_format(($Favorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2);
                    $UnFavorable = number_format(($UnFavorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2);
                    $ENPS_data_array = [
                        'function' => $function->id,
                        'practice_id' => $practice->id,
                        'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                        'Nuetral_score' => number_format(($Nuetral_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                        //get count of Favorable answers
                        'Favorable_count' => $Favorable_count,
                        //get count of UnFavorable answers
                        'UnFavorable_count' => $UnFavorable_count,
                        //get count of Nuetral answers
                        'Nuetral_count' => $Nuetral_count,
                        'Favorable_score' => $Favorable,
                        'UnFavorable_score' => $UnFavorable,
                        'ENPS_index' => ($Favorable - $UnFavorable),
                    ];
                }
                $function_Nuetral_sum += $sum_answer_value_Nuetral;
                $function_Favorable_sum += $sum_answer_value_Favorable;
                $function_UnFavorable_sum += $sum_answer_value_UnFavorable;
                $function_Nuetral_count += $Nuetral_count;
                $function_Favorable_count += $Favorable_count;
                $function_UnFavorable_count += $UnFavorable_count;
                array_push($outcome_functions_practice, $Outcome_practice_results);
            }
            $out_come_favorable = number_format(($function_Favorable_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2);
            $out_come_unfavorable = number_format(($function_UnFavorable_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2);
            //setup function_results
            $outcome_function_results = [
                'function' => $function->id,
                'function_title' => App()->getLocale() == 'en' ? $function->FunctionTitle : $function->FunctionTitleAr,
                'Nuetral_score' => number_format(($function_Nuetral_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2),
                'Favorable_score' => $out_come_favorable,
                'UnFavorable_score' => $out_come_unfavorable,
                //get count of Favorable answers
                'Favorable_count' => $function_Favorable_count,
                //get count of UnFavorable answers
                'UnFavorable_count' => $function_UnFavorable_count,
                //get count of Nuetral answers
                'Nuetral_count' => $function_Nuetral_count,
                'outcome_index' => $out_come_favorable
            ];
            array_push($outcome_function_results_1, $outcome_function_results);
        }
        // $ENPS_data_array = collect($ENPS_data_array)->sortBy('ENPS_index')->reverse()->toArray();
        // $ENPS_data_array = array_slice($ENPS_data_array, 0, 3);
        // $ENPS_data_array = collect($ENPS_data_array)->sortBy('ENPS_index')->toArray();
        //get first three highest items
        //sort $driver_functions_practice asc
        $driver_functions_practice_asc = array_slice(collect($driver_functions_practice)->sortBy('Favorable_score')->toArray(), 0, 3);
        //sort $driver_functions_practice desc
        $driver_functions_practice_desc = array_slice(collect($driver_functions_practice)->sortByDesc('Favorable_score')->toArray(), 0, 3);

        if ($type == 'all') {
            //get all sectors of current client
            $sectors = Sectors::where('client_id', Surveys::find($id)->ClientId)->get();
            foreach ($sectors as $sector) {
                $heat_map_indecators = array();
                $ENPS_Favorable = null;
                $ENPS_Pushed = false;
                foreach (Surveys::find($id)->plan->functions/* ->where('IsDriver', false) */ as $function) {
                    //$sum_function_answer_value_Favorable_HM
                    $function_Favorable_sum_HM = 0;
                    $function_UnFavorable_sum_HM = 0;
                    $function_Nuetral_sum_HM = 0;
                    foreach ($function->functionPractices as $practice) {
                        $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $sector->id)->pluck('id')->all();
                        $Favorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        $UnFavorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        $Nuetral_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        if ($Favorable_result_HM) {
                            $sum_answer_value_Favorable_HM = $Favorable_result_HM->sum;
                            $Favorable_count_HM = $Favorable_result_HM->count;
                        } else {
                            $sum_answer_value_Favorable_HM = 0;
                            $Favorable_count_HM = 0;
                        }
                        if ($UnFavorable_result_HM) {
                            $sum_answer_value_UnFavorable_HM = $UnFavorable_result_HM->sum;
                            $UnFavorable_count_HM = $UnFavorable_result_HM->count;
                        } else {
                            $sum_answer_value_UnFavorable_HM = 0;
                            $UnFavorable_count_HM = 0;
                        }
                        if ($Nuetral_result_HM) {
                            $sum_answer_value_Nuetral_HM = $Nuetral_result_HM->sum;
                            $Nuetral_count_HM = $Nuetral_result_HM->count;
                        } else {
                            $sum_answer_value_Nuetral_HM = 0;
                            $Nuetral_count_HM = 0;
                        }
                        if ($practice->practiceQuestions->IsENPS && $ENPS_Favorable == null) {
                            $ENPS_Favorable = number_format(($Favorable_count_HM / ($Favorable_count_HM + $Nuetral_count_HM + $UnFavorable_count_HM)) * 100, 2);
                        }
                        $function_Favorable_sum_HM += $Favorable_count_HM;
                        $function_UnFavorable_sum_HM += $UnFavorable_count_HM;
                        $function_Nuetral_sum_HM += $Nuetral_count_HM;
                    }
                    $out_come_favorable_HM = number_format(($function_Favorable_sum_HM / ($function_Favorable_sum_HM + $function_Nuetral_sum_HM + $function_UnFavorable_sum_HM)) * 100, 2);
                    if ($function->IsDriver) {
                        $title = explode(" ", $function->FunctionTitle);
                        $title = $title[0];
                    } else
                        $title = 'Engagement';
                    $outcome_function_results_HM = [
                        'function_title' => $title,
                        'score' => $out_come_favorable_HM,
                    ];
                    array_push($heat_map_indecators, $outcome_function_results_HM);
                    if ($ENPS_Favorable && !$ENPS_Pushed) {
                        $ENPS_Pushed = true;
                        $outcome_function_results_HM = [
                            'function_title' => $title,
                            'score' => $ENPS_Favorable,
                        ];
                        array_push($heat_map_indecators, $outcome_function_results_HM);
                    }
                }
                $heat_map_item = [
                    'entity_name' => App()->getLocale() == 'en' ? $sector->sector_name_en : $sector->sector_name_ar,
                    'entity_id' => $sector->id,
                    'indecators' => $heat_map_indecators,
                ];
                array_push($heat_map, $heat_map_item);
            }
        }
        //if type =sec
        elseif ($type == 'sec') {
            //get all companies of current sector
            $companies = Companies::where('sector_id', $type_id)->get();
            foreach ($companies as $company) {
                $heat_map_indecators = array();
                $ENPS_Favorable = null;
                $ENPS_Pushed = false;
                foreach (Surveys::find($id)->plan->functions/* ->where('IsDriver', false) */ as $function) {
                    //$sum_function_answer_value_Favorable_HM
                    $function_Favorable_sum_HM = 0;
                    $function_UnFavorable_sum_HM = 0;
                    $function_Nuetral_sum_HM = 0;
                    foreach ($function->functionPractices as $practice) {
                        $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $company->id)->pluck('id')->all();
                        $Favorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        $UnFavorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        $Nuetral_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                        if ($Favorable_result_HM) {
                            $sum_answer_value_Favorable_HM = $Favorable_result_HM->sum;
                            $Favorable_count_HM = $Favorable_result_HM->count;
                        } else {
                            $sum_answer_value_Favorable_HM = 0;
                            $Favorable_count = 0;
                        }
                        if ($UnFavorable_result_HM) {
                            $sum_answer_value_UnFavorable_HM = $UnFavorable_result_HM->sum;
                            $UnFavorable_count_HM = $UnFavorable_result_HM->count;
                        } else {
                            $sum_answer_value_UnFavorable_HM = 0;
                            $UnFavorable_count_HM = 0;
                        }
                        if ($Nuetral_result_HM) {
                            $sum_answer_value_Nuetral_HM = $Nuetral_result_HM->sum;
                            $Nuetral_count_HM = $Nuetral_result_HM->count;
                        } else {
                            $sum_answer_value_Nuetral_HM = 0;
                            $Nuetral_count_HM = 0;
                        }
                        if ($practice->practiceQuestions->IsENPS && $ENPS_Favorable == null) {
                            $ENPS_Favorable = number_format(($Favorable_count_HM / ($Favorable_count_HM + $Nuetral_count_HM + $UnFavorable_count_HM)) * 100, 2);
                        }
                        $function_Favorable_sum_HM += $Favorable_count_HM;
                        $function_UnFavorable_sum_HM += $UnFavorable_count_HM;
                        $function_Nuetral_sum_HM += $Nuetral_count_HM;
                    }
                    $out_come_favorable_HM = number_format(($function_Favorable_sum_HM / ($function_Favorable_sum_HM + $function_Nuetral_sum_HM + $function_UnFavorable_sum_HM)) * 100, 2);
                    if ($function->IsDriver) {
                        $title = explode(" ", $function->FunctionTitle);
                        $title = $title[0];
                    } else
                        $title = 'Engagement';
                    $outcome_function_results_HM = [
                        'function_title' => $title,
                        'score' => $out_come_favorable_HM,
                    ];
                    array_push($heat_map_indecators, $outcome_function_results_HM);
                    if ($ENPS_Favorable && !$ENPS_Pushed) {
                        $ENPS_Pushed = true;
                        $outcome_function_results_HM = [
                            'function_title' => $title,
                            'score' => $ENPS_Favorable,
                        ];
                        array_push($heat_map_indecators, $outcome_function_results_HM);
                    }
                }
                $heat_map_item = [
                    'entity_name' => App()->getLocale() == 'en' ? $company->company_name_en : $company->company_name_ar,
                    'entity_id' => $company->id,
                    'indecators' => $heat_map_indecators,
                ];
                array_push($heat_map, $heat_map_item);
            }
        }
        //if type =comp
        elseif ($type == 'comp') {
            $heat_map = [];
        }

        $data = [
            'drivers' => $driver_functions_practice,
            'drivers_functions' => $overall_per_fun,
            'outcomes' => $outcome_function_results_1,
            'ENPS_data_array' => $ENPS_data_array,
            'entity' => $entity,
            'type' => $type,
            'type_id' => $type_id,
            'id' => $id,
            'driver_practice_asc' => $driver_functions_practice_asc,
            'driver_practice_desc' => $driver_functions_practice_desc,
            'heat_map' => $heat_map,
            'cal_type' => 'countD'
        ];
        return $data;
    }
    public function get_SectorResult($id, $type, $type_id)
    {
        $data = [];
        $functions = Surveys::find($id)->plan->functions;
        $sector = Sectors::find($type_id);
        foreach ($sector->companies as $company) {
            //append data from get_resultd to data array
            // $data = $data + $this->get_resultd($id, 'comp', $company->id);
            array_push($data, $this->get_resultd($id, 'comp', $company->id));
        }
        $driver_functions = [];
        $outcome_functions = [];
        $ENPS_data_array1 = [];
        $ENPS_data_array = [];
        $practices = [];
        $overall_per_fun = [];
        $driver_functions_practice = [];
        $outcome_function_results_1 = [];
        $data_size = count($data);
        foreach ($data as $singlData) {
            foreach ($singlData['drivers_functions'] as $driver) {
                array_push($driver_functions, $driver);
            }
            foreach ($singlData['outcomes'] as $outcome) {
                array_push($outcome_functions, $outcome);
            }
            // foreach ($singlData['ENPS_data_array'] as $ENPS) {
            array_push($ENPS_data_array, $singlData['ENPS_data_array']);
            // }
            foreach ($singlData['drivers'] as $practice) {
                array_push($practices, $practice);
            }
        }
        // Log::info($driver_functions);
        foreach ($functions as $function) {
            if ($function->IsDriver) {
                $function_results = [
                    'function' => $function->id,
                    'function_title' => App()->getLocale() == 'en' ? $function->FunctionTitle : $function->FunctionTitleAr,
                    'Nuetral_score' => floatval(number_format(collect($driver_functions)->where('function', $function->id)->sum('Nuetral_score') / $data_size, 2)),
                    'Favorable_score' => floatval(number_format(collect($driver_functions)->where('function', $function->id)->sum('Favorable_score') / $data_size, 2)),
                    'UnFavorable_score' => floatval(number_format(collect($driver_functions)->where('function', $function->id)->sum('UnFavorable_score') / $data_size, 2)),
                    //get count of Favorable answers
                    'Favorable_count' => floatval(number_format(collect($driver_functions)->where('function', $function->id)->sum('Favorable_count') / $data_size, 2)),
                    //get count of UnFavorable answers
                    'UnFavorable_count' => floatval(number_format(collect($driver_functions)->where('function', $function->id)->sum('UnFavorable_count') / $data_size, 2)),
                    //get count of Nuetral answers
                    'Nuetral_count' => floatval(number_format(collect($driver_functions)->where('function', $function->id)->sum('Nuetral_count') / $data_size, 2)),
                ];
                array_push($overall_per_fun, $function_results);
                foreach ($function->functionPractices as $practice) {
                    $practice_results = [
                        'function' => $function->id,
                        'practice_id' => $practice->id,
                        'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                        'Nuetral_score' => floatval(number_format(collect($practices)->where('practice_id', $practice->id)->sum('Nuetral_score') / $data_size)),
                        'Favorable_score' => floatval(number_format(collect($practices)->where('practice_id', $practice->id)->sum('Favorable_score') / $data_size)),
                        'UnFavorable_score' => floatval(number_format(collect($practices)->where('practice_id', $practice->id)->sum('UnFavorable_score') / $data_size)),
                        //get count of Favorable answers
                        'Favorable_count' => floatval(number_format(collect($practices)->where('practice_id', $practice->id)->sum('Favorable_count') / $data_size)),
                        //get count of UnFavorable answers
                        'UnFavorable_count' => floatval(number_format(collect($practices)->where('practice_id', $practice->id)->sum('UnFavorable_count') / $data_size)),
                        //get count of Nuetral answers
                        'Nuetral_count' => floatval(number_format(collect($practices)->where('practice_id', $practice->id)->sum('Nuetral_count') / $data_size)),
                    ];
                    array_push($driver_functions_practice, $practice_results);
                }
            } else {
                foreach ($function->functionPractices as $practice) {

                    if ($practice->practiceQuestions->IsENPS) {
                        $Favorable = floatval(number_format(collect($ENPS_data_array)->where('practice_id', $practice->id)->sum('Favorable_score') / $data_size, 2));
                        $UnFavorable = floatval(number_format(collect($ENPS_data_array)->where('practice_id', $practice->id)->sum('UnFavorable_score') / $data_size, 2));
                        $ENPS_data_array1 = [
                            'function' => $function->id,
                            'practice_id' => $practice->id,
                            'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                            'Nuetral_score' => floatval(number_format(collect($ENPS_data_array)->where('practice_id', $practice->id)->sum('Nuetral_score') / $data_size, 2)),
                            //get count of Favorable answers
                            'Favorable_count' => floatval(number_format(collect($ENPS_data_array)->where('practice_id', $practice->id)->sum('Favorable_count') / $data_size, 2)),
                            //get count of UnFavorable answers
                            'UnFavorable_count' => floatval(number_format(collect($ENPS_data_array)->where('practice_id', $practice->id)->sum('UnFavorable_count') / $data_size, 2)),
                            //get count of Nuetral answers
                            'Nuetral_count' => floatval(number_format(collect($ENPS_data_array)->where('practice_id', $practice->id)->sum('Nuetral_count') / $data_size, 2)),
                            'Favorable_score' => $Favorable,
                            'UnFavorable_score' => $UnFavorable,
                            'ENPS_index' => ($Favorable - $UnFavorable),
                        ];
                    }
                }
                $out_come_favorable = floatval(number_format(collect($outcome_functions)->where('function', $function->id)->sum('Favorable_score') / $data_size, 2));
                $out_come_unfavorable = floatval(number_format(collect($outcome_functions)->where('function', $function->id)->sum('UnFavorable_score') / $data_size, 2));
                //setup function_results
                $outcome_function_results = [
                    'function' => $function->id,
                    'function_title' => App()->getLocale() == 'en' ? $function->FunctionTitle : $function->FunctionTitleAr,
                    'Nuetral_score' => floatval(number_format(collect($outcome_functions)->where('function', $function->id)->sum('Nuetral_score') / $data_size, 2)),
                    'Favorable_score' => $out_come_favorable,
                    'UnFavorable_score' => $out_come_unfavorable,
                    //get count of Favorable answers
                    'Favorable_count' => floatval(number_format(collect($outcome_functions)->where('function', $function->id)->sum('Favorable_count') / $data_size, 2)),
                    //get count of UnFavorable answers
                    'UnFavorable_count' => floatval(number_format(collect($outcome_functions)->where('function', $function->id)->sum('UnFavorable_count') / $data_size, 2)),
                    //get count of Nuetral answers
                    'Nuetral_count' => floatval(number_format(collect($outcome_functions)->where('function', $function->id)->sum('Nuetral_count') / $data_size, 2)),
                    'outcome_index' => $out_come_favorable
                ];
                array_push($outcome_function_results_1, $outcome_function_results);
            }
        }
        $heat_map = [];
        $companies = Companies::where('sector_id', $type_id)->get();
        foreach ($companies as $company) {
            $heat_map_indecators = array();
            $ENPS_Favorable = null;
            $ENPS_Pushed = false;
            foreach (Surveys::find($id)->plan->functions/* ->where('IsDriver', false) */ as $function) {
                //$sum_function_answer_value_Favorable_HM
                $function_Favorable_sum_HM = 0;
                $function_UnFavorable_sum_HM = 0;
                $function_Nuetral_sum_HM = 0;
                foreach ($function->functionPractices as $practice) {
                    $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $company->id)->pluck('id')->all();
                    $Favorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                    $UnFavorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                    $Nuetral_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
                    if ($Favorable_result_HM) {
                        $sum_answer_value_Favorable_HM = $Favorable_result_HM->sum;
                        $Favorable_count_HM = $Favorable_result_HM->count;
                    } else {
                        $sum_answer_value_Favorable_HM = 0;
                        $Favorable_count = 0;
                    }
                    if ($UnFavorable_result_HM) {
                        $sum_answer_value_UnFavorable_HM = $UnFavorable_result_HM->sum;
                        $UnFavorable_count_HM = $UnFavorable_result_HM->count;
                    } else {
                        $sum_answer_value_UnFavorable_HM = 0;
                        $UnFavorable_count_HM = 0;
                    }
                    if ($Nuetral_result_HM) {
                        $sum_answer_value_Nuetral_HM = $Nuetral_result_HM->sum;
                        $Nuetral_count_HM = $Nuetral_result_HM->count;
                    } else {
                        $sum_answer_value_Nuetral_HM = 0;
                        $Nuetral_count_HM = 0;
                    }
                    if ($practice->practiceQuestions->IsENPS && $ENPS_Favorable == null) {
                        $ENPS_Favorable = number_format(($Favorable_count_HM / ($Favorable_count_HM + $Nuetral_count_HM + $UnFavorable_count_HM)) * 100, 2);
                        $ENPS_UnFavorable = number_format(($UnFavorable_count_HM / ($Favorable_count_HM + $Nuetral_count_HM + $UnFavorable_count_HM)) * 100, 2);
                    }
                    $function_Favorable_sum_HM += $Favorable_count_HM;
                    $function_UnFavorable_sum_HM += $UnFavorable_count_HM;
                    $function_Nuetral_sum_HM += $Nuetral_count_HM;
                }
                $out_come_favorable_HM = number_format(($function_Favorable_sum_HM / ($function_Favorable_sum_HM + $function_Nuetral_sum_HM + $function_UnFavorable_sum_HM)) * 100, 2);
                if ($function->IsDriver) {
                    $title = explode(" ", $function->FunctionTitle);
                    $title = $title[0];
                } else
                    $title = 'Engagement';
                $outcome_function_results_HM = [
                    'function_title' => $title,
                    'score' => $out_come_favorable_HM,
                ];
                array_push($heat_map_indecators, $outcome_function_results_HM);
                if ($ENPS_Favorable && !$ENPS_Pushed) {
                    $ENPS_Pushed = true;
                    $outcome_function_results_HM = [
                        'function_title' => $title,
                        'score' => $ENPS_Favorable-$ENPS_UnFavorable,
                    ];
                    array_push($heat_map_indecators, $outcome_function_results_HM);
                }
            }
            $heat_map_item = [
                'entity_name' => App()->getLocale() == 'en' ? $company->company_name_en : $company->company_name_ar,
                'entity_id' => $company->id,
                'indecators' => $heat_map_indecators,
            ];
            array_push($heat_map, $heat_map_item);
        }
        $driver_functions_practice_asc = array_slice(collect($driver_functions_practice)->sortBy('Favorable_score')->toArray(), 0, 3);
        //sort $driver_functions_practice desc
        $driver_functions_practice_desc = array_slice(collect($driver_functions_practice)->sortByDesc('Favorable_score')->toArray(), 0, 3);

        $data = [
            'drivers' => $driver_functions_practice,
            'drivers_functions' => $overall_per_fun,
            'outcomes' => $outcome_function_results_1,
            'ENPS_data_array' => $ENPS_data_array1,
            'entity' => Sectors::find($type_id)->sector_name_en,
            'type' => $type,
            'type_id' => $type_id,
            'id' => $id,
            'driver_practice_asc' => $driver_functions_practice_asc,
            'driver_practice_desc' => $driver_functions_practice_desc,
            'heat_map' => $heat_map,
            'cal_type' => 'countD'
        ];
        return $data;
    }
    public function get_GroupResult($id, $type, $type_id)
    {
        $data = [];
        $client = Surveys::find($id)->clients;
        $functions = Surveys::find($id)->plan->functions;
        foreach ($client->sectors as $sector) {
            array_push($data, $this->get_SectorResult($id, 'sec', $sector->id));
        }
        $driver_functions = [];
        $outcome_functions = [];
        $ENPS_data_array1 = [];
        $ENPS_data_array = [];
        $practices = [];
        $overall_per_fun = [];
        $driver_functions_practice = [];
        $outcome_function_results_1 = [];
        $data_size = count($data);
        foreach ($data as $singlData) {
            foreach ($singlData['drivers_functions'] as $driver) {
                array_push($driver_functions, $driver);
            }
            foreach ($singlData['outcomes'] as $outcome) {
                array_push($outcome_functions, $outcome);
            }
            // foreach ($singlData['ENPS_data_array'] as $ENPS) {
            array_push($ENPS_data_array, $singlData['ENPS_data_array']);
            // }
            foreach ($singlData['drivers'] as $practice) {
                array_push($practices, $practice);
            }
        }
        foreach ($functions as $function) {
            if ($function->IsDriver) {
                $function_results = [
                    'function' => $function->id,
                    'function_title' => App()->getLocale() == 'en' ? $function->FunctionTitle : $function->FunctionTitleAr,
                    'Nuetral_score' => floatval(number_format(collect($driver_functions)->where('function', $function->id)->sum('Nuetral_score') / $data_size, 2)),
                    'Favorable_score' => floatval(number_format(collect($driver_functions)->where('function', $function->id)->sum('Favorable_score') / $data_size, 2)),
                    'UnFavorable_score' => floatval(number_format(collect($driver_functions)->where('function', $function->id)->sum('UnFavorable_score') / $data_size, 2)),
                    //get count of Favorable answers
                    'Favorable_count' => floatval(number_format(collect($driver_functions)->where('function', $function->id)->sum('Favorable_count') / $data_size, 2)),
                    //get count of UnFavorable answers
                    'UnFavorable_count' => floatval(number_format(collect($driver_functions)->where('function', $function->id)->sum('UnFavorable_count') / $data_size, 2)),
                    //get count of Nuetral answers
                    'Nuetral_count' => floatval(number_format(collect($driver_functions)->where('function', $function->id)->sum('Nuetral_count') / $data_size, 2)),
                ];
                array_push($overall_per_fun, $function_results);
                foreach ($function->functionPractices as $practice) {
                    $practice_results = [
                        'function' => $function->id,
                        'practice_id' => $practice->id,
                        'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                        'Nuetral_score' => floatval(number_format(collect($practices)->where('practice_id', $practice->id)->sum('Nuetral_score') / $data_size, 2)),
                        'Favorable_score' => floatval(number_format(collect($practices)->where('practice_id', $practice->id)->sum('Favorable_score') / $data_size, 2)),
                        'UnFavorable_score' => floatval(number_format(collect($practices)->where('practice_id', $practice->id)->sum('UnFavorable_score') / $data_size, 2)),
                        //get count of Favorable answers
                        'Favorable_count' => floatval(number_format(collect($practices)->where('practice_id', $practice->id)->sum('Favorable_count') / $data_size, 2)),
                        //get count of UnFavorable answers
                        'UnFavorable_count' => floatval(number_format(collect($practices)->where('practice_id', $practice->id)->sum('UnFavorable_count') / $data_size, 2)),
                        //get count of Nuetral answers
                        'Nuetral_count' => floatval(number_format(collect($practices)->where('practice_id', $practice->id)->sum('Nuetral_count') / $data_size, 2)),
                    ];
                    array_push($driver_functions_practice, $practice_results);
                }
            } else {
                foreach ($function->functionPractices as $practice) {

                    if ($practice->practiceQuestions->IsENPS) {
                        $Favorable = floatval(number_format(collect($ENPS_data_array)->where('practice_id', $practice->id)->sum('Favorable_score') / $data_size, 2));
                        $UnFavorable = floatval(number_format(collect($ENPS_data_array)->where('practice_id', $practice->id)->sum('UnFavorable_score') / $data_size, 2));
                        $ENPS_data_array1 = [
                            'function' => $function->id,
                            'practice_id' => $practice->id,
                            'practice_title' => App()->getLocale() == 'en' ? $practice->PracticeTitle : $practice->PracticeTitleAr,
                            'Nuetral_score' => floatval(number_format(collect($ENPS_data_array)->where('practice_id', $practice->id)->sum('Nuetral_score') / $data_size, 2)),
                            //get count of Favorable answers
                            'Favorable_count' => floatval(number_format(collect($ENPS_data_array)->where('practice_id', $practice->id)->sum('Favorable_count') / $data_size, 2)),
                            //get count of UnFavorable answers
                            'UnFavorable_count' => floatval(number_format(collect($ENPS_data_array)->where('practice_id', $practice->id)->sum('UnFavorable_count') / $data_size, 2)),
                            //get count of Nuetral answers
                            'Nuetral_count' => floatval(number_format(collect($ENPS_data_array)->where('practice_id', $practice->id)->sum('Nuetral_count') / $data_size, 2)),
                            'Favorable_score' => $Favorable,
                            'UnFavorable_score' => $UnFavorable,
                            'ENPS_index' => ($Favorable - $UnFavorable),
                        ];
                    }
                }
                $out_come_favorable = floatval(number_format(collect($outcome_functions)->where('function', $function->id)->sum('Favorable_score') / $data_size, 2));
                $out_come_unfavorable = floatval(number_format(collect($outcome_functions)->where('function', $function->id)->sum('UnFavorable_score') / $data_size, 2));
                //setup function_results
                $outcome_function_results = [
                    'function' => $function->id,
                    'function_title' => App()->getLocale() == 'en' ? $function->FunctionTitle : $function->FunctionTitleAr,
                    'Nuetral_score' => floatval(number_format(collect($outcome_functions)->where('function', $function->id)->sum('Nuetral_score') / $data_size, 2)),
                    'Favorable_score' => $out_come_favorable,
                    'UnFavorable_score' => $out_come_unfavorable,
                    //get count of Favorable answers
                    'Favorable_count' => floatval(number_format(collect($outcome_functions)->where('function', $function->id)->sum('Favorable_count') / $data_size, 2)),
                    //get count of UnFavorable answers
                    'UnFavorable_count' => floatval(number_format(collect($outcome_functions)->where('function', $function->id)->sum('UnFavorable_count') / $data_size, 2)),
                    //get count of Nuetral answers
                    'Nuetral_count' => floatval(number_format(collect($outcome_functions)->where('function', $function->id)->sum('Nuetral_count') / $data_size, 2)),
                    'outcome_index' => $out_come_favorable
                ];
                array_push($outcome_function_results_1, $outcome_function_results);
            }
        }
        $heat_map = [];

        $sectors = Sectors::where('client_id', Surveys::find($id)->ClientId)->get();
        foreach ($sectors as $sector) {
            $heat_map_indecators1=[];
            $sector_heatMap = collect($data)->where('type_id', $sector->id)->first();
            $headAv=0;
            $handAv=0;
            $heartAv=0;
            $outcomeAv=0;
            $ENPSAv=0;
            $headTitle='';
            $handTitle='';
            $heartTitle='';
            $outcomeTitle='';
            $ENPSTitle='';
            foreach($sector_heatMap['heat_map'] as $comp)
            {
                $headAv += $comp['indecators'][0]['score'];
                $handAv += $comp['indecators'][1]['score'];
                $heartAv += $comp['indecators'][2]['score'];
                $outcomeAv += $comp['indecators'][3]['score'];
                $ENPSAv += $comp['indecators'][4]['score'];
                $headTitle = $comp['indecators'][0]['function_title'];
                $handTitle = $comp['indecators'][1]['function_title'];
                $heartTitle = $comp['indecators'][2]['function_title'];
                $outcomeTitle = $comp['indecators'][3]['function_title'];
                $ENPSTitle = $comp['indecators'][4]['function_title'];

            }
            $outcome_function_results_HM1 = [
                'function_title' => $headTitle,
                'score' => floatval(number_format($headAv/count($sector_heatMap['heat_map']),2)),
            ];
            array_push($heat_map_indecators1, $outcome_function_results_HM1);
            $outcome_function_results_HM1 = [
                'function_title' => $handTitle,
                'score' => floatval(number_format($handAv/count($sector_heatMap['heat_map']),2)),
            ];
            array_push($heat_map_indecators1, $outcome_function_results_HM1);
            $outcome_function_results_HM1 = [
                'function_title' => $heartTitle,
                'score' => floatval(number_format($heartAv/count($sector_heatMap['heat_map']),2)),
            ];
            array_push($heat_map_indecators1, $outcome_function_results_HM1);
            $outcome_function_results_HM1 = [
                'function_title' => $outcomeTitle,
                'score' => floatval(number_format($outcomeAv/count($sector_heatMap['heat_map']),2)),
            ];
            array_push($heat_map_indecators1, $outcome_function_results_HM1);
            $outcome_function_results_HM1 = [
                'function_title' => $ENPSTitle,
                'score' => floatval(number_format($ENPSAv/count($sector_heatMap['heat_map']),2)),
            ];
            array_push($heat_map_indecators1, $outcome_function_results_HM1);
            $heat_map_item1 = [
                'entity_name' => App()->getLocale() == 'en' ? $sector->sector_name_en : $sector->sector_name_ar,
                'entity_id' => $sector->id,
                'indecators' => $heat_map_indecators1,
            ];
            array_push($heat_map, $heat_map_item1);
            // $heat_map_indecators = array();
            // $ENPS_Favorable = null;
            // $ENPS_Pushed = false;
            // foreach (Surveys::find($id)->plan->functions/* ->where('IsDriver', false) */ as $function) {
            //     //$sum_function_answer_value_Favorable_HM
            //     $function_Favorable_sum_HM = 0;
            //     $function_UnFavorable_sum_HM = 0;
            //     $function_Nuetral_sum_HM = 0;
            //     foreach ($function->functionPractices as $practice) {
            //         $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $sector->id)->pluck('id')->all();
            //         $Favorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '>=', 4], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
            //         $UnFavorable_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', '<=', 2], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
            //         $Nuetral_result_HM = SurveyAnswers::selectRaw('COUNT(AnswerValue) as count, SUM(AnswerValue) as sum')->where([['SurveyId', $this->id], ['AnswerValue', 3], ['QuestionId', $practice->practiceQuestions->id]])->whereIn('AnsweredBy', $Emails)->first();
            //         if ($Favorable_result_HM) {
            //             $sum_answer_value_Favorable_HM = $Favorable_result_HM->sum;
            //             $Favorable_count_HM = $Favorable_result_HM->count;
            //         } else {
            //             $sum_answer_value_Favorable_HM = 0;
            //             $Favorable_count_HM = 0;
            //         }
            //         if ($UnFavorable_result_HM) {
            //             $sum_answer_value_UnFavorable_HM = $UnFavorable_result_HM->sum;
            //             $UnFavorable_count_HM = $UnFavorable_result_HM->count;
            //         } else {
            //             $sum_answer_value_UnFavorable_HM = 0;
            //             $UnFavorable_count_HM = 0;
            //         }
            //         if ($Nuetral_result_HM) {
            //             $sum_answer_value_Nuetral_HM = $Nuetral_result_HM->sum;
            //             $Nuetral_count_HM = $Nuetral_result_HM->count;
            //         } else {
            //             $sum_answer_value_Nuetral_HM = 0;
            //             $Nuetral_count_HM = 0;
            //         }
            //         if ($practice->practiceQuestions->IsENPS && $ENPS_Favorable == null) {
            //             $ENPS_Favorable = number_format(($Favorable_count_HM / ($Favorable_count_HM + $Nuetral_count_HM + $UnFavorable_count_HM)) * 100, 2);
            //         }
            //         $function_Favorable_sum_HM += $Favorable_count_HM;
            //         $function_UnFavorable_sum_HM += $UnFavorable_count_HM;
            //         $function_Nuetral_sum_HM += $Nuetral_count_HM;
            //     }
            //     $out_come_favorable_HM = number_format(($function_Favorable_sum_HM / ($function_Favorable_sum_HM + $function_Nuetral_sum_HM + $function_UnFavorable_sum_HM)) * 100, 2);
            //     if ($function->IsDriver) {
            //         $title = explode(" ", $function->FunctionTitle);
            //         $title = $title[0];
            //     } else
            //         $title = 'Engagement';
            //     $outcome_function_results_HM = [
            //         'function_title' => $title,
            //         'score' => $out_come_favorable_HM,
            //     ];
            //     array_push($heat_map_indecators, $outcome_function_results_HM);
            //     if ($ENPS_Favorable && !$ENPS_Pushed) {
            //         $ENPS_Pushed = true;
            //         $outcome_function_results_HM = [
            //             'function_title' => $title,
            //             'score' => $ENPS_Favorable,
            //         ];
            //         array_push($heat_map_indecators, $outcome_function_results_HM);
            //     }
            // }
            // $heat_map_item = [
            //     'entity_name' => App()->getLocale() == 'en' ? $sector->sector_name_en : $sector->sector_name_ar,
            //     'entity_id' => $sector->id,
            //     'indecators' => $heat_map_indecators,
            // ];
            // array_push($heat_map, $heat_map_item);
        }
        $driver_functions_practice_asc = array_slice(collect($driver_functions_practice)->sortBy('Favorable_score')->toArray(), 0, 3);
        //sort $driver_functions_practice desc
        $driver_functions_practice_desc = array_slice(collect($driver_functions_practice)->sortByDesc('Favorable_score')->toArray(), 0, 3);
        $data = [
            'drivers' => $driver_functions_practice,
            'drivers_functions' => $overall_per_fun,
            'outcomes' => $outcome_function_results_1,
            'ENPS_data_array' => $ENPS_data_array1,
            'entity' => "AL-Zubair Group",
            'type' => $type,
            'type_id' => $type_id,
            'id' => $id,
            'driver_practice_asc' => $driver_functions_practice_asc,
            'driver_practice_desc' => $driver_functions_practice_desc,
            'heat_map' => $heat_map,
            'cal_type' => 'countD'
        ];
        return $data;
    }
}
