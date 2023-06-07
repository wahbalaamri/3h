<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    use HasFactory;
    protected $fillable = [
        'dep_name_en',
        'dep_name_ar',
        'parent_id',
    ];
    //fillable

    public function emails()
    {
        return $this->hasMany(Emails::class, 'DepartmentId');
    }
    // belongs to Comapnies
    public function companies()
    {
        return $this->belongsTo(Companies::class,'company_id');
    }
}
