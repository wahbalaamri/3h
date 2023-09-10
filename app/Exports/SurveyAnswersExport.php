<?php

namespace App\Exports;

use App\Models\PracticeQuestions;
use App\Models\SurveyAnswers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class SurveyAnswersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $id;
    private $ans;
    public function __construct($id)
    {
        $this->id = $id;
    }
    public function collection()
    {
        $exportData = [];
        $surveyAnswers = SurveyAnswers::select('SurveyId', 'QuestionId', 'AnswerValue',   'AnsweredBy')->where('SurveyId', $this->id)->get();
        $this->ans=$surveyAnswers;
        foreach ($surveyAnswers as $surveyAnswer) {
            $question=PracticeQuestions::find($surveyAnswer->QuestionId);
            $exportData[] = [
                'Survey Id' => $surveyAnswer->SurveyId,
                'Function ID' => $question->functionPractice->functions->id,
                'Function Title' => $question->functionPractice->functions->FunctionTitle,
                'Is Driver Function' => $question->functionPractice->functions->IsDriver,
                'Question Id' => $surveyAnswer->QuestionId,
                'Question Title' => $question->Question,
                'Question is eNPS' => $question->IsENPS,
                'Answer Value' => (($surveyAnswer->AnswerValue)-1)==0?'0':($surveyAnswer->AnswerValue)-1,
                'Answered By' => $surveyAnswer->AnsweredBy,
            ];
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
        return ['Survey Id', 'Function ID','Function Title','Is Driver Function', 'Question Id','Question Title','Question is eNPS', 'Answer Value',   'Answered By'];
    }
    public function registerEvents(): array
    {

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setCellValue('A'.(count($this->ans)+3), 'Average:');
                $event->sheet->setCellValue('B'.(count($this->ans)+3), 'Percentage:');
            }
        ];
    }
}
