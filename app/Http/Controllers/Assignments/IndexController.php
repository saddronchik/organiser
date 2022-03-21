<?php

namespace App\Http\Controllers\Assignments;

use App\Exports\AssignmentExport;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreAssignmentRequest;
use App\Models\Assignment;
use App\Models\User;
use App\Repositories\Interfaces\AssignmentQueries;
use App\Repositories\Interfaces\DepartmentsQueries;
use App\Repositories\Interfaces\StatusesQueries;
use App\Repositories\Interfaces\UsersQueries;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class IndexController extends BaseController
{

    private $assignmentRepository;
    private $userRepository;
    private $statusesRepository;
    private $departmentRepository;

    private $department;

    public function __construct(AssignmentQueries $assignmentRepository,
                                UsersQueries $userRepository,
                                StatusesQueries $statusesRepository,
                                DepartmentsQueries $departmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->userRepository = $userRepository;
        $this->statusesRepository = $statusesRepository;
        $this->departmentRepository = $departmentRepository;
        $this->department = new DepartmentController();
    }

    public function index(int $perPage = 15)
    {
        $assignments = $this->assignmentRepository->getWithPaginate($perPage);
        $departments = $this->departmentRepository->getAll();
        $statuses = $this->statusesRepository->getAll();

        foreach ($assignments as $assignment) {
            if ($assignment->deadline < Carbon::now()->format('d.m.Y')) {
                $assignment->status_id = 2;
                $assignment->save();
            }
        }

        $assignments = $this->assignmentRepository->getWithPaginate($perPage);

        return view('assignment.index',
            compact('assignments', 'statuses','departments'));
    }

    public function create()
    {
        $statuses = $this->statusesRepository->getAll();
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
        $department_id = null;
        $new_author = null;
        $new_addressed = null;
        $new_executor = null;

        if ($request->new_department) {
            $department_id = $this->department->storeFromModal($request->new_department);
        }

        if ($request['new_author']) {
            $new_author = User::create([
                'full_name' => $request['new_author']
            ]);
        }

        if ($request['new_addressed']) {
            $existAddressed = User::where('full_name', [$request['new_addressed']])->first();

            if (!$existAddressed) {
                $new_addressed = User::create([
                    'full_name' => $request['new_addressed']
                ]);
            }
        }

        if ($request['new_executor']) {
            $existExecutor = User::where('full_name', [$request['new_executor']])->first();

            if (!$existExecutor) {
                $new_executor = User::create([
                    'full_name' => $request['new_executor']
                ]);
            }
        }

        $assignment = Assignment::create([
            'document_number' => $request->document_number,
            'preamble' => $request->preambule,
            'text' => $request->resolution,
            'author_id' => $request->author ?? $new_author->id,
            'addressed_id' => $request->addressed ?? $new_addressed->id,
            'executor_id' => $request->executor ?? $new_executor->id,
            'department_id' => $request->department ?? $department_id,
            'status_id' => $request->status,
            'deadline' => $request->deadline,
            'real_deadline' => $request->fact_deadline
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
            ->with('error');
    }

    public function edit(int $id)
    {
        $assignment = $this->assignmentRepository->getById($id);
        $statuses = $this->statusesRepository->getAll();
        $users = $this->userRepository->getAll();
        $departments = $this->departmentRepository->getAll();

        return response()->json([
            "status" => true,
            "assignment" => $assignment,
            "statuses" => $statuses,
            "subexecutors" => $assignment->users,
            "users" => $users,
            "departments" => $departments
        ])->setStatusCode(200);

    }

    public function update($id, Request $request): RedirectResponse
    {
        $assignment = Assignment::where('id', [$id])
            ->update([
                'document_number' => $request->document_number,
                'preamble' => $request->preambule,
                'text' => $request->resolution,
                'author_id' => $request->author,
                'addressed_id' => $request->addressed,
                'executor_id' => $request->executor,
                'department_id' => $request->department,
                'status_id' => $request->status,
                'deadline' => $request->deadline,
                'real_deadline' => $request->fact_deadline
            ]);

        if ($assignment) {
            return redirect()
                ->back()
                ->with('success', 'Запись обновленаю');
        }

        return redirect()
            ->back()
            ->with('error');
    }

    public function search(SearchRequest $request)
    {
        $search = $request->search;

        $assignments = is_numeric($search) ? $this->assignmentRepository->getByDocumentNumber($search)
            : $this->assignmentRepository->getByUsername($search);

        $statuses = $this->statusesRepository->getAll();
        $departments = $this->departmentRepository->getAll();

        return view('assignment.index',
            compact('assignments', 'statuses', 'departments'));
    }

    public function sortByStatus($id)
    {
        $assignments = $this->assignmentRepository->getByStatus($id);
        $statuses = $this->statusesRepository->getAll();
        $departments = $this->departmentRepository->getAll();

        return view('assignment.index',
            compact('assignments', 'statuses', 'departments'));
    }

    public function sortByDepartment($id)
    {
        $assignments = $this->assignmentRepository->getByDepartmentWithPaginate($id);
        $statuses = $this->statusesRepository->getAll();
        $departments = $this->departmentRepository->getAll();

        return view('assignment.index',
            compact('assignments', 'statuses', 'departments'));
    }

    public function export(Request $request): BinaryFileResponse
    {
        $departmentId = $request->input('department');
        return Excel::download(new AssignmentExport($this->assignmentRepository, $departmentId), 'assignments.xlsx');
    }


}
