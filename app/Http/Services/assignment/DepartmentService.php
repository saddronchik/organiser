<?php


namespace App\Http\Services\assignment;


use App\Models\Department;

class DepartmentService
{
    public function create($title)
    {
        return Department::new($title);
    }
}
