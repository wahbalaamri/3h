<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sectors extends Model
{
    use HasFactory;
    protected $table = 'sectors';
    //fillable
    protected $fillable = [
        'client_id',
        'sector_name_en',
        'sector_name_ar',
    ];
    //belong to Clients
    public function clients()
    {
        return $this->belongsTo(Clients::class,'client_id');
    }
    //has many Companies
    public function companies()
    {
        return $this->hasMany(Companies::class,'sector_id');
    }
    //has many Emails
    public function emails()
    {
        return $this->hasMany(Emails::class,'sector_id');
    }
}
