<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    use Uuids;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'DepartmentId',
        'ClientId',
        'SurveyId',
        'Email',
        'EmployeeType',
        'AddedBy',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $keyType = 'int';

    public function clients()
    {
        return $this->belongsTo(Clients::class,"ClientId");
    }
    // belongsTo relationship with Surveys
    public function survey()
    {
        return $this->belongsTo(Surveys::class, 'SurveyId');
    }
    // belongsTo Departments
    public function department()
    {
        return $this->belongsTo(Departments::class, 'DepartmentId');
    }
    // belongsTo Sector
    public function sector()
    {
        return $this->belongsTo(Sectors::class, 'sector_id');
    }
    // belongsTo Companies
    public function company()
    {
        return $this->belongsTo(Companies::class, 'comp_id');
    }
}
