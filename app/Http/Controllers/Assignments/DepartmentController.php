<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Services\assignment\DepartmentService;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    private $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function store(StoreDepartmentRequest $request)
    {
        try {
            $this->departmentService->create($request['title']);
        } catch (\DomainException $exception) {
            return redirect()
                ->back()
                ->with('error', $exception->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Подразделение добавлено успешно.');
    }

    public function storeFromModal(string $title): ?Department
    {
        try {
            $department = $this->departmentService->create($title);
        } catch (\DomainException $exception) {
            return null;
        }

        return $department;
    }
}
