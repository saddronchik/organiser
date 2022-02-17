<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function store(StoreDepartmentRequest $request)
    {
        $department = Department::create($request->all());

        if ($department) {
            return redirect()
                ->back()
                ->with('success', 'Подразделение добавлено успешно.');
        }

        return redirect()
            ->back()
            ->with('error');
    }

    public function storeFromModal(string $title): int
    {
        $department = Department::create([
            'title' => $title
        ]);

        return $department->id;
    }
}
