<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestService extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'fp_name',
        'fp_email',
        'fp_phone',
        'remarks',
        'plan_id',

    ];
    public function plan()
    {
        return $this->belongsTo(PartnerShipPlans::class);
    }
}
