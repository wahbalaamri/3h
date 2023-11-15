<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenEndedQuestions extends Model
{
    use HasFactory;
    protected $fillable = [
        "question",
        "question_ar",
        "question_in",
        "survey_id",
        "respondent",
        "status",
        "answer_type",
    ];
    //belongs to survey
    public function survey()
    {
        return $this->belongsTo(Surveys::class,'survey_id');
    }
}
