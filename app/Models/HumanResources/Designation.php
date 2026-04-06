<?php

namespace App\Models\HumanResources;

use App\Models\HumanResources\Department;
use App\Models\Users\Employee;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable = [
        'name',
        'description',
        'department_id',
        'default_salary',
        'can_teach',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
