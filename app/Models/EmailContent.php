<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailContent extends Model
{
    use HasFactory;
    //has many clients
    public function clients()
    {
        return $this->hasOne(Clients::class,'id','client_id');
    }
    //has many surveys
    public function surveys()
    {
        return $this->hasOne(Surveys::class,'id','survey_id');
    }
}
