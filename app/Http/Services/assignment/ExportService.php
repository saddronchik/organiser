<?php


namespace App\Http\Services\assignment;

use App\Exports\AssignmentExport;
use App\Repositories\Interfaces\AssignmentQueries;
use Maatwebsite\Excel\Facades\Excel;

class ExportService
{
    private $assignmentRepository;
    public $filename;

    public function __construct(AssignmentQueries $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->filename = 'export_' . date('d:m:Y') . '.xlsx';
    }

    public function export($departmentId)
    {
        // TODO не работает экспорт
        return Excel::download(
            new AssignmentExport($this->assignmentRepository, $departmentId),
            $this->filename);
    }
}
