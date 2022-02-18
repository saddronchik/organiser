<?php

namespace App\Exports;

use App\Repositories\Interfaces\AssignmentQueries;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssignmentExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    private $assignmentRepository;
    private $departmentId;

    public function __construct(AssignmentQueries $assignmentRepository, $departmentId)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->departmentId = $departmentId;
    }

    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $result = $this->assignmentRepository->getByDepartment($this->departmentId);
        return $result;
    }

    public function headings(): array
    {
        return [
            '№ п/п',
            'Номер документа',
            'Адресовано',
            'Регистрация',
            'Преамбула',
            'Текст резолюции',
            'Автор резолюции',
            'Адресовано',
            'Исполнитель',
            'Статус',
            'Срок исполнения',
            'Фактический срок исполнения'
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1    => ['font' => ['bold' => true], 'alignment' => ['horizontal' => true]]
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->document_number,
            $row->created_at,
            $row->preamble,
            $row->text,
            $row->author->full_name,
            $row->addressed->full_name,
            $row->executor->full_name,
            $row->department->title,
            $row->statuses->status,
            $row->deadline,
            $row->real_deadline
        ];
    }
}
