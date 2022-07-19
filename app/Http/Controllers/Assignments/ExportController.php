<?php

namespace App\Http\Controllers\Assignments;

use App\Exports\AssignmentExport;
use App\Http\Controllers\Controller;
use App\Http\Services\assignment\ExportService;
use App\Repositories\Interfaces\AssignmentQueries;
use App\Repositories\Interfaces\UsersQueries;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    private $assignmentRepository;
    public $filename;

    public function __construct(AssignmentQueries $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->filename = 'export_' . date('d:m:Y') . '.xlsx';
    }

    public function exportToXls(Request $request)
    {
        $departmentId = $request->get('department');

        return Excel::download(
            new AssignmentExport($this->assignmentRepository, $departmentId),
            $this->filename);
    }
}
