<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ClientName',
        'ClientEmail',
        'ClientPhone',
        'CilentFPName',
        'CilentFPEmil',
        'CilentFPPhone',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function surveys()
    {
        return $this->hasMany(Surveys::class,'ClientId');
    }

    public function emails()
    {
        return $this->hasMany(Emails::class);
    }
    //belongsTo relationship with EmailContent
    public function emailContent()
    {
        return $this->belongsTo(EmailContent::class);
    }
    //has many sectors
    public function sectors()
    {
        return $this->hasMany(Sectors::class,'client_id');
    }
}
