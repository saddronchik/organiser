<?php

namespace App\Http\Controllers\Assignments;

use App\Exports\AssignmentExport;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreAssignmentRequest;
use App\Models\Assignment;
use App\Models\User;
use App\Repositories\Interfaces\AssignmentQueries;
use App\Repositories\Interfaces\DepartmentsQueries;
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
    private $departmentRepository;

    private $department;

    public function __construct(AssignmentQueries $assignmentRepository,
                                UsersQueries $userRepository,
                                DepartmentsQueries $departmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->userRepository = $userRepository;
        $this->departmentRepository = $departmentRepository;
        $this->department = new DepartmentController();
    }

    public function index(int $perPage = 15)
    {
        $assignments = $this->assignmentRepository->getWithPaginate($perPage);
        $departments = $this->departmentRepository->getAll();
        $statuses = Assignment::getStatuses();

        foreach ($assignments as $assignment) {
            if ($assignment->deadline < Carbon::now()->format('d.m.Y')) {
                $assignment->status = Assignment::STATUS__EXPIRED;
                $assignment->save();
            }
        }

        $assignments = $this->assignmentRepository->getWithPaginate($perPage);

        return view('assignment.index',
            compact('assignments','departments','statuses'));
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


        if ($request->new_department) {
            $department = $this->department->storeFromModal($request->new_department);
            $department = $department->id;
        }

        if ($request['new_author']) {
            $author = User::create([
                'full_name' => $request['new_author']
            ]);

            $author = $author->id;
        }

        if ($request['new_addressed']) {
            $existAddressed = User::where('full_name', [$request['new_addressed']])->first();

            if (!$existAddressed) {
                $addressed = User::create([
                    'full_name' => $request['new_addressed']
                ]);

                $addressed = $addressed->id;
            }
        }

        if ($request['new_executor']) {
            $existExecutor = User::where('full_name', [$request['new_executor']])->first();

            if (!$existExecutor) {
                $executor = User::create([
                    'full_name' => $request['new_executor']
                ]);

                $executor = $executor->id;
            }
        }

        $assignment = Assignment::create([
            'document_number' => $request->document_number,
            'preamble' => $request->preambule,
            'text' => $request->resolution,
            'author_id' => $author,
            'addressed_id' => $addressed,
            'executor_id' => $executor,
            'department_id' => $department ?? $request->department,
            'status' => $request->status ?? $status,
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
            ->withInput($request->input())
            ->with('error');
    }

    public function edit(int $id)
    {
        $assignment = $this->assignmentRepository->getById($id);
        $statuses = Assignment::getStatuses();
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

    public function update($id, Request $request)
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
                'status' => $request->status,
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
            ->withInput($request->input())
            ->with('error');
    }

    public function search(SearchRequest $request)
    {
        $search = $request->search;

        $assignments = is_numeric($search) ? $this->assignmentRepository->getByDocumentNumber($search)
            : $this->assignmentRepository->getByUsername($search);

        $statuses = Assignment::getStatuses();
        $departments = $this->departmentRepository->getAll();

        return view('assignment.index',
            compact('assignments', 'statuses', 'departments'));
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
        return Excel::download(new AssignmentExport($this->assignmentRepository, $departmentId), 'assignments.xlsx');
    }


}
