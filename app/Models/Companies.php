<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;
    protected $table = 'companies';
    //fillable
    protected $fillable = [
        'sector_id',
        'company_name_en',
        'company_name_ar',
    ];
    //belong to Sectors
    public function sectors()
    {
        return $this->belongsTo(Sectors::class,'sector_id');
    }
    // has many Departments
    public function departments()
    {
        return $this->hasMany(Departments::class,'company_id');
    }
    // has many Emails
    public function emails()
    {
        return $this->hasMany(Emails::class,'comp_id');
    }
}
