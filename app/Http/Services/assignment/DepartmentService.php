<?php


namespace App\Http\Services\assignment;


use App\Models\Department;
use App\Repositories\Interfaces\DepartmentsQueries;

class DepartmentService
{
    private $departmentRepository;

    public function __construct(DepartmentsQueries $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function create($title)
    {
        return Department::new($title);
    }

    public function getAll()
    {
        return $this->departmentRepository->getAll();
    }
}
