<?php

namespace App\Exports;

use App\Models\SurveyAnswers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SurveyAnswersExport implements FromCollection,WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $id;
    public function __construct($id)
    {
        $this->id = $id;
    }
    public function collection()
    {

        return SurveyAnswers::select('SurveyId', 'QuestionId', 'AnswerValue',   'AnsweredBy')->where('SurveyId',$this->id)->get();
    }
     /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ['Survey Id', 'Question Id', 'Answer Value',   'Answered By'];
    }
}
