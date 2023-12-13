<?php

namespace App\Exports;

use App\Models\Emails;
use App\Models\OpenEndedQuestions;
use App\Models\OpenEndedQuestionsAnswers;
use App\Models\PracticeQuestions;
use App\Models\SurveyAnswers;
use App\Models\Surveys;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class SurveyAnswersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $id;
    private $type;
    private $type_id;
    private $ans;
    public function __construct($id, $type, $type_id)
    {
        $this->id = $id;
        $this->type = $type;
        $this->type_id = $type_id;
    }
    public function collection()
    {
        $exportData = [];

        $surveyAnswers = null;
        $Emails = null;
        if ($this->type == 'all') {
            $Emails = Emails::where('SurveyId', $this->id)->pluck('id')->all();
            // $surveyAnswers = SurveyAnswers::select('SurveyId', 'QuestionId', 'AnswerValue',   'AnsweredBy')->where('SurveyId', $this->id)->get();
            // $this->ans = $surveyAnswers;
        } else if ($this->type == 'comp') {
            //get emails where $emails exist in SurveyAnswers
            $Emails = Emails::where('SurveyId', $this->id)->where('comp_id', $this->type_id)->pluck('id')->all();
        }
        //sector
        else if ($this->type == 'sector') {
            //get emails where $emails exist in SurveyAnswers
            $Emails = Emails::where('SurveyId', $this->id)->where('sector_id', $this->type_id)->pluck('id')->all();
        }
        $open_end_questions = OpenEndedQuestions::select(['id', 'question'])->where('survey_id', $this->id)->get();
        $count = 0;
        $index = 0;
        $temp_AnsweredBy = null;
        //foreach loop through Emails id
        //chunck $Emails

        foreach ($Emails as $email) {
            $count = 0;
            //get surveyanswers
            $surveyAnswers = SurveyAnswers::where('SurveyId', $this->id)->where('AnsweredBy', $email)->get();
            // Log::info($email);
            // Log::info($surveyAnswers);
            // Log::info($surveyAnswers->count());
            if ($surveyAnswers->count()>0) {
                $exportData[] = [
                    'Survey Id' => $this->id,
                    'Answered By' => $email,
                ];
                // foreach ($surveyAnswers as $surveyAnswer) {
                $count += 2;
                $indx = 2;
                $functions = Surveys::find($this->id)->plan->functions;

                foreach ($functions as $function) {

                    foreach ($function->functionPractices as $practce) {
                        if ($function->IsDriver)
                            $questionTitle = "Driver-Q";
                        else {
                            if ($practce->practiceQuestions->IsENPS)
                                $questionTitle = "outcome-eNPS-Q";
                            else
                                $questionTitle = "outcome-Q";
                        }
                        //get answervalue
                        $answerValue = SurveyAnswers::where('SurveyId', $this->id)->where('QuestionId', $practce->practiceQuestions->id)->where('AnsweredBy', $email)->first();
                        //push answerValue into exportData
                        if ($answerValue != null) {

                            //add this value to next column

                            $exportData[$index][$questionTitle . $indx++] = $answerValue->AnswerValue;
                            $count++;
                        }
                    }
                }
                // }
                $openEndedQuestionsAnswers = OpenEndedQuestionsAnswers::where('survey_id', $this->id)->where('respondent_id', $email)->get();
                foreach ($openEndedQuestionsAnswers as $openEndedQuestionsAnswer) {
                    $exportData[$index][$openEndedQuestionsAnswer->open_ended_question_id] = $openEndedQuestionsAnswer->answer;
                }
                $index++;
            }
        }

        return collect($exportData);
        // return SurveyAnswers::select('SurveyId', 'QuestionId', 'AnswerValue',   'AnsweredBy')->where('SurveyId',$this->id)->get();
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        // $heading = ['Survey Id', 'Function ID', 'Function Title', 'Is Driver Function', 'Question Id', 'Question Title', 'Question is eNPS', 'Answer Value',   'Answered By'];
        $heading = ['Survey Id', 'Answered By'];
        $functions = Surveys::find($this->id)->plan->functions;
        //get functions
        $index = 1;
        foreach ($functions as $function) {
            $questionTitle = "";
            foreach ($function->functionPractices as $practce) {
                if ($function->IsDriver)
                    $questionTitle = "Driver-Q";
                else {
                    if ($practce->practiceQuestions->IsENPS)
                        $questionTitle = "outcome-eNPS-Q";
                    else
                        $questionTitle = "outcome-Q";
                }
                //get loop iteration

                $heading[] = $questionTitle . $index;
                $index++;
            }
        }
        //add new Item to heading
        $open_end_questions = OpenEndedQuestions::select('question')->where('survey_id', $this->id)->get();
        foreach ($open_end_questions as $open_end_question) {
            $heading[] = $open_end_question->question;
        }
        return $heading;
    }
    public function registerEvents(): array
    {

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setCellValue('A' . (count($this->ans) + 3), 'Average:');
                $event->sheet->setCellValue('B' . (count($this->ans) + 3), 'Percentage:');
            }
        ];
    }
}
