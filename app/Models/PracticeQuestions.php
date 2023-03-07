<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticeQuestions extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Question',
        'QuestionAr',
        'PracticeId',
        'Respondent',
        'Status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'Status' => 'boolean',
    ];

    public function functionPractice()
    {
        return $this->belongsTo(FunctionPractice::class,'PracticeId');
    }
}
