<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable = [
        'name',
        'description',
        'department_id',
        'default_salary',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function department()
    {
        return $this->belongsTo(Departments::class);
    }
}
