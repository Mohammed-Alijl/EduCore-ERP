<?php

namespace App\Models\HumanResources;

use App\Models\HumanResources\Designation;
use App\Models\Users\Employee;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function designations()
    {
        return $this->hasMany(Designation::class);
    }
}
