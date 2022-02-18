<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreAssignmentRequest;
use App\Models\Assignment;
use App\Models\User;
use App\Repositories\Interfaces\AssignmentQueries;
use App\Repositories\Interfaces\DepartmentsQueries;
use App\Repositories\Interfaces\StatusesQueries;
use App\Repositories\Interfaces\UsersQueries;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        if($request->new_department) {
            $department_id = $this->department->storeFromModal($request->new_department);
        }


        $assignment = Assignment::create([
            'document_number' => $request->document_number,
            'preamble' => $request->preambule,
            'text' => $request->resolution,
            'author_id' => $request->author,
            'addressed_id' => $request->addressed,
            'executor_id' => $request->executor,
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
                ->with('success','Поручение успешно создано.');
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
        $assignment = Assignment::where('id',[$id])
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
            compact('assignments','statuses','departments'));
    }

    public function sortByStatus($id)
    {
        $assignments = $this->assignmentRepository->getByStatus($id);
        $statuses = $this->statusesRepository->getAll();
        $departments = $this->departmentRepository->getAll();

        return view('assignment.index',
            compact('assignments','statuses','departments'));
    }

    public function sortByDepartment($id)
    {
        $assignments = $this->assignmentRepository->getByDepartment($id);
        $statuses = $this->statusesRepository->getAll();
        $departments = $this->departmentRepository->getAll();

        return view('assignment.index',
            compact('assignments', 'statuses','departments'));
    }


}
