<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunctionPractice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'PracticeTitle',
        'PracticeTitleAr',
        'FunctionId',
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

    public function functions()
    {
        return $this->belongsTo(Functions::class,'FunctionId');
    }

    public function practiceQuestions()
    {
        return $this->hasOne(PracticeQuestions::class,'PracticeId');
    }
}
