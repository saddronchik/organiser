<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreAssignmentRequest;
use App\Models\Assignment;
use App\Models\Status;
use App\Models\User;
use App\Repositories\Interfaces\AssignmentQueries;
use App\Repositories\Interfaces\DepartmentsQueries;
use App\Repositories\Interfaces\StatusesQueries;
use App\Repositories\Interfaces\UsersQueries;
use Illuminate\Http\Request;

class IndexController extends BaseController
{

    private $assignmentRepository;
    private $userRepository;
    private $statusesRepository;
    private $departmentRepository;

    public function __construct(AssignmentQueries $assignmentRepository,
                                UsersQueries $userRepository,
                                StatusesQueries $statusesRepository,
                                DepartmentsQueries $departmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->userRepository = $userRepository;
        $this->statusesRepository = $statusesRepository;
        $this->departmentRepository = $departmentRepository;
    }

    public function index(Request $request, int $perPage = 15)
    {
        $assignments = $this->assignmentRepository->getWithPaginate($perPage);

        return view('assignment.index',
            compact('assignments'));
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
        $assignment = Assignment::create([
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
            $users = User::find($request->subexecutors);
            $assignment->users()->attach($users);
            return redirect()->back();
        }

        return redirect()
            ->back();
    }

    public function search(SearchRequest $request)
    {
        // TODO search by params
    }
}
