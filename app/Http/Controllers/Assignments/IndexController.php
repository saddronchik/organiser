<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Status;
use App\Repositories\Interfaces\AssignmentQueries;
use Illuminate\Http\Request;

class IndexController extends BaseController
{

    private $assignmentRepository;

    public function __construct(AssignmentQueries $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
    }

    public function index(int $perPage = 15)
    {
        $assignments = $this->assignmentRepository->getWithPaginate($perPage);

        return view('assignment.index',
            compact('assignments'));
    }
}
