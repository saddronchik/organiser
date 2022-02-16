<?php


namespace App\Repositories;


use App\Models\Department;
use App\Repositories\Interfaces\DepartmentsQueries;
use Illuminate\Database\Eloquent\Collection;

class EloquentDepartmentsQueries implements DepartmentsQueries
{

    public function getAll(): Collection
    {
        $result = Department::select('id','title')
            ->get();

        return $result;
    }
}
