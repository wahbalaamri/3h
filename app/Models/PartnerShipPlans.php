<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerShipPlans extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'PlanTitle',
        'Objective',
        'Process',
        'Report',
        'DeliveryMode',
        'Limitations',
        'PlanTitleAr',
        'ObjectiveAr',
        'ProcessAr',
        'ReportAr',
        'DeliveryModeAr',
        'LimitationsAr',
        'Audience',
        'TamplatePath',
        'Price',
        'PaymentMethod',
        'Status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'Price' => 'double',
        'Status' => 'boolean',
    ];

    public function functions()
    {
        return $this->hasMany(Functions::class,'PlanId');
    }
    // hasMany relationship with Surveys
    public function surveys()
    {
        return $this->hasMany(Surveys::class);
    }
    public function requestServices()
    {
        return $this->hasMany(RequestService::class);
    }
}
