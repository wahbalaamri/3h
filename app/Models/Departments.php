<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    use HasFactory;
    protected $fillable = [
        'dep_name',
        'parent_id',
    ];
    public function emails()
    {
        return $this->hasMany(Emails::class, 'DepartmentId');
    }
}
