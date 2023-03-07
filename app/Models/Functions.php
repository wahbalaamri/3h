<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Functions extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FunctionTitle',
        'FunctionTitleAr',
        'PlanId',
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

    public function partnerShipPlans()
    {
        return $this->belongsTo(PartnerShipPlans::class,'PlanId');
    }

    public function functionPractices()
    {
        return $this->hasMany(FunctionPractice::class,'FunctionId');
    }
}
