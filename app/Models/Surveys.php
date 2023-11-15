<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surveys extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ClientId',
        'PlanId',
        'SurveyTitle',
        'SurveyDes',
        'SurveyStat',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'SurveyStat' => 'boolean',
    ];

    public function clients()
    {
        return $this->belongsTo(Clients::class, 'ClientId');
    }

    public function surveyAnswers()
    {
        return $this->hasMany(SurveyAnswers::class);
    }

    public function prioritiesAnswers()
    {
        return $this->hasMany(PrioritiesAnswers::class);
    }
    // belongsTo relationship with PartnerShipPlans
    public function plan()
    {
        return $this->belongsTo(PartnerShipPlans::class, 'PlanId');
    }
    //hasMany relationship with Emails
    public function emails()
    {
        return $this->hasMany(Emails::class);
    }
    //belongesto EmailContent
    public function emailContent()
    {
        return $this->belongsTo(EmailContent::class);
    }
    //hasmany open ended question
    public function OpenEndQ()
    {
        return $this->hasMany(OpenEndedQuestions::class,'survey_id');
    }
}
