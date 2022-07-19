<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Assignment\EditRequest;
use App\Http\Requests\Assignment\StoreRequest;
use App\Http\Services\assignment\AssignmentService;
use App\Http\Services\assignment\DepartmentService;
use App\Http\Services\assignment\UserService;
use App\Models\Assignment;
use Carbon\Carbon;
use Illuminate\Http\Request;


class IndexController extends Controller
{
    private $assignmentService;
    private $departmentService;
    private $userService;

    public function __construct(AssignmentService $assignmentService, DepartmentService $departmentService,
                                UserService $userService)
    {
        $this->assignmentService = $assignmentService;
        $this->departmentService = $departmentService;
        $this->userService = $userService;
    }

    public function index(Request $request, int $perPage = 15)
    {
        $departments = $this->departmentService->getAll();
        $statuses = Assignment::getStatuses();

        $query = Assignment::with(['users'])->orderBy('id', 'desc');

        if (!empty($value = $request->get('document_number'))) {
            $query->where('document_number', 'LIKE', '%' . $value . '%');
        }

        if (!empty($value = $request->get('author'))) {
            $query->where('author_id', $value);
        }

        if (!empty($value = $request->get('addressed'))) {
            $query->where('addressed_id', $value);
        }

        if (!empty($value = $request->get('department'))) {
            $query->where('department_id', $value);
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }

        $assignments = $query->paginate($perPage);

        $this->setStatuses($assignments);

        return view('assignment.index',
            compact('assignments', 'departments', 'statuses'));
    }

    public function create()
    {
        $statuses = Assignment::getStatuses();
        $users = $this->userService->getAll();
        $departments = $this->departmentService->getAll();

        return response()->json([
            "status" => true,
            "statuses" => $statuses,
            "users" => $users,
            "departments" => $departments
        ])->setStatusCode(200);
    }

    public function store(StoreRequest $request)
    {
        $department = null;
        $author = null;
        $addressed = null;
        $executor = null;

        if (!empty($value = $request->get('new_department'))) {
            $department = $this->departmentService->create($value);
        }

        if (!empty($value = $request->get('new_author'))) {
            $author = $this->userService->getOrCreate($value);
        }

        if (!empty($value = $request->get('new_addressed'))) {
            $addressed = $this->userService->getOrCreate($value);
        }

        if (!empty($value = $request->get('new_executor'))) {
            $executor = $this->userService->getOrCreate($value);
        }

        try {
            $this->assignmentService->create($request, $author, $addressed, $executor, $department);
        } catch (\DomainException $exception) {
            return back()->withInput($request->input())->with('error', $exception->getMessage());
        }

        return redirect()->route('assignments.index')->with('success', 'Поручение успешно создано.');
    }


    public function edit(Assignment $assignment)
    {
        $statuses = Assignment::getStatuses();
        $users = $this->userService->getAll();
        $departments = $this->departmentService->getAll();
        $assignment = $this->assignmentService->find($assignment->id);

        return response()->json([
            "status" => true,
            "assignment" => $assignment,
            "statuses" => $statuses,
            "subexecutors" => $assignment->users,
            "users" => $users,
            "departments" => $departments
        ])->setStatusCode(200);

    }

    public function update($id, EditRequest $request)
    {
        $department = null;
        $author = null;
        $addressed = null;
        $executor = null;

        if (!empty($value = $request->get('new_department'))) {
            $department = $this->departmentService->create($value);
        }

        if (!empty($value = $request->get('new_author'))) {
            $author = $this->userService->getOrCreate($value);
        }

        if (!empty($value = $request->get('new_addressed'))) {
            $addressed = $this->userService->getOrCreate($value);
        }

        if (!empty($value = $request->get('new_executor'))) {
            $executor = $this->userService->getOrCreate($value);
        }

        try {
            $this->assignmentService->edit($id, $department, $author, $addressed, $executor, $request);
        } catch (\DomainException $exception) {
            return back()->withInput($request->input())->with('error', $exception->getMessage());
        }

        return redirect()->route('assignments.index')->with('success', 'Поручение успешно обновлено!');
    }

    public function done(Assignment $assignment): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->assignmentService->markAsDone($assignment->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('assignments.index');
    }

    public function expired(Assignment $assignment): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->assignmentService->markAsExpired($assignment->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('assignments.index');
    }

    public function extend($id, Request $request)
    {
        try {
            $this->assignmentService->extend($id, $request->get('date'));
        } catch (\DomainException $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }

        return response()->json([
            'status' => true
        ]);
    }

    public function destroy(Assignment $assignment)
    {
        try {
            $this->assignmentService->remove($assignment->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return response()->json([
            'status' => true
        ]);
    }

    private function setStatuses($assignments)
    {
        foreach ($assignments as $assignment) {
            if (!empty($assignment->deadline) && Carbon::parse($assignment->deadline)->lt(Carbon::now()) &&
                !$assignment->isDone()) {
                $assignment->status = Assignment::STATUS_EXPIRED;
                $assignment->save();
            }
        }
    }


}
