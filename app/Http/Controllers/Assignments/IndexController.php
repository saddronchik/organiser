<?php

namespace App\Http\Controllers\Assignments;

use App\Exports\AssignmentExport;
use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Services\assignment\AssignmentService;
use App\Http\Services\assignment\DepartmentService;
use App\Models\Assignment;
use App\Models\User;
use App\Repositories\Interfaces\AssignmentQueries;
use App\Repositories\Interfaces\DepartmentsQueries;
use App\Repositories\Interfaces\UsersQueries;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class IndexController extends BaseController
{

    private $assignmentService;
    private $departmentService;
    private $assignmentRepository;
    private $userRepository;
    private $departmentRepository;

    private $department;

    public function __construct(AssignmentService $assignmentService,
                                DepartmentService $departmentService,
                                AssignmentQueries $assignmentRepository,
                                UsersQueries $userRepository,
                                DepartmentsQueries $departmentRepository)
    {
        $this->assignmentService = $assignmentService;
        $this->departmentService = $departmentService;
        $this->assignmentRepository = $assignmentRepository;
        $this->userRepository = $userRepository;
        $this->departmentRepository = $departmentRepository;
        $this->department = new DepartmentController(new DepartmentService());
    }

    public function index(Request $request, int $perPage = 15)
    {
        $departments = $this->departmentRepository->getAll();
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


        foreach ($assignments as $assignment) {
            if (!empty($assignment->deadline) && Carbon::parse($assignment->deadline)->lt(Carbon::now()) &&
                    !$assignment->isDone())
            {
                $assignment->status = Assignment::STATUS_EXPIRED;
                $assignment->save();
            }
        }

        return view('assignment.index',
            compact('assignments', 'departments', 'statuses'));
    }

    public function create()
    {
        $statuses = Assignment::getStatuses();
        $users = $this->userRepository->getAll();
        $departments = $this->departmentRepository->getAll();

        return response()->json([
            "status" => true,
            "statuses" => $statuses,
            "users" => $users,
            "departments" => $departments
        ])->setStatusCode(200);
    }

    public function store(StoreAssignmentRequest $request)
    {
        $department = null;
        $author = null;
        $addressed = null;
        $executor = null;
        $status = Assignment::STATUS_IN_PROGRESS;

        if ($request['new_department']) {
            $department = $this->department->storeFromModal($request->new_department);
            $department = $department->id;
        }

        if ($request['new_author']) {
            $author = User::where('full_name', [$request['new_author']])->first();;

            if (!$author) {
                $author = User::create([
                    'full_name' => $request['new_author']
                ])->id;
            } else {
                $author = $author->id;
            }
        }

        if ($request['new_addressed']) {
            $addressed = User::where('full_name', $request['new_addressed'])->first();

            if (!$addressed) {
                $addressed = User::create([
                    'full_name' => $request['new_addressed']
                ])->id;
            } else {
                $addressed = $addressed->id;
            }
        }

        if ($request['new_executor']) {
            $executor = User::where('full_name', $request['new_executor'])->first();

            if (!$executor) {
                $executor = User::create([
                    'full_name' => $request['new_executor']
                ])->id;
            } else {
                $executor = $executor->id;
            }
        }

        $assignment = Assignment::create([
            'document_number' => $request['document_number'],
            'preamble' => $request['preambule'],
            'text' => $request['resolution'],
            'author_id' => $author ?? $request['author'],
            'addressed_id' => $addressed ?? $request['addressed'],
            'executor_id' => $executor ?? $request['executor'],
            'department_id' => $department ?? $request['department'],
            'status' => $request['status'] ?? $status,
            'deadline' => $request['deadline'],
            'real_deadline' => $request['fact_deadline'],
            'register_date' => $request['register_date']
        ]);

        if ($assignment) {
            $users = User::find($request->subexecutors);
            $assignment->users()->attach($users);

            return redirect()
                ->back()
                ->with('success', 'Поручение успешно создано.');
        }

        return redirect()
            ->back()
            ->withInput($request->input())
            ->with('error');
    }

    public function edit(Assignment $assignment)
    {
        $statuses = Assignment::getStatuses();
        $users = $this->userRepository->getAll();
        $departments = $this->departmentRepository->getAll();

        return response()->json([
            "status" => true,
            "assignment" => $this->assignmentRepository->find($assignment->id),
            "statuses" => $statuses,
            "subexecutors" => $assignment->users,
            "users" => $users,
            "departments" => $departments
        ])->setStatusCode(200);

    }

    public function update($id, Request $request)
    {
        $department = null;
        $author = null;
        $addressed = null;
        $executor = null;
        $status = $request->input('status');

        if ($status == Assignment::STATUS_DONE) {
            $request['deadline'] = Carbon::now();
            $request['fact_deadline'] = Carbon::now();
        } elseif ($status == Assignment::STATUS_EXPIRED) {
            $request['fact_deadline'] = Carbon::now()->subDay();
        } elseif ($status == Assignment::STATUS_IN_PROGRESS
            && !Carbon::parse($request['deadline'])->gt(Carbon::now()->addDay()))
        {
            $request['deadline'] = Carbon::now()->addDay();
            $request['fact_deadline'] = Carbon::now()->addDay();
        }

        if ($request['new_department']) {
            $department = $this->department->storeFromModal($request->new_department);
            $department = $department->id;
        }

        if ($request['new_author']) {
            $author = User::where('full_name', [$request['new_author']])->first();;

            if (!$author) {
                $author = User::create([
                    'full_name' => $request['new_author']
                ])->id;
            } else {
                $author = $author->id;
            }
        }

        if ($request['new_addressed']) {
            $addressed = User::where('full_name', [$request['new_addressed']])->first();

            if (!$addressed) {
                $addressed = User::create([
                    'full_name' => $request['new_addressed']
                ])->id;
            } else {
                $addressed = $addressed->id;
            }
        }

        if ($request['new_executor']) {
            $executor = User::where('full_name', [$request['new_executor']])->first();

            if (!$executor) {
                $executor = User::create([
                    'full_name' => $request['new_executor']
                ])->id;
            } else {
                $executor = $executor->id;
            }
        }

        $assignment = Assignment::findOrFail($id);

        $updated = $assignment->update([
            'document_number' => $request['document_number'],
            'preamble' => $request['preambule'],
            'text' => $request['resolution'],
            'author_id' => $author ?? $request['author'],
            'addressed_id' => $addressed ?? $request['addressed'],
            'executor_id' => $executor ?? $request['executor'],
            'department_id' => $department ?? $request['department'],
            'status' => $status,
            'register_date' => $request['register_date'],
            'deadline' => $request['deadline'],
            'real_deadline' => $request['fact_deadline']
        ]);

        if ($updated) {
            $users = User::find($request->subexecutors);

            $assignment->users()->sync($users);

            return redirect()
                ->back()
                ->with('success', 'Запись обновлена!');
        }

        return redirect()
            ->back()
            ->withInput($request->input())
            ->with('error');
    }

    public function done(Assignment $assignment)
    {
        try {
            $this->assignmentService->markAsDone($assignment->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('assignments.index');
    }

    public function expired(Assignment $assignment)
    {
        try {
            $this->assignmentService->markAsExpired($assignment->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('assignments.index');
    }

    public function sortByStatus($id)
    {
        $assignments = $this->assignmentRepository->getByStatus($id);
        $statuses = Assignment::getStatuses();
        $departments = $this->departmentRepository->getAll();

        return view('assignment.index',
            compact('assignments', 'statuses', 'departments'));
    }

    public function sortByDepartment($id)
    {
        $assignments = $this->assignmentRepository->getByDepartmentWithPaginate($id);
        $statuses = Assignment::getStatuses();
        $departments = $this->departmentRepository->getAll();

        return view('assignment.index',
            compact('assignments', 'statuses', 'departments'));
    }

    public function export(Request $request): BinaryFileResponse
    {
        $departmentId = $request->input('department');
        return Excel::download(
            new AssignmentExport($this->assignmentRepository, $departmentId),
            'assignments.xlsx');
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


}
