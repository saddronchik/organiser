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
       return $this->assignmentRepository->getByDepartment($this->departmentId);
    }

    public function headings(): array
    {
        return [
            '№ п/п',
            'Номер документа',
            'Регистрация',
            'Адресовано',
            'Преамбула',
            'Текст резолюции',
            'Автор резолюции',
            'Главный исполнитель',
            'Соисполнители',
            'Подразделение',
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
        $subexecutors = '';

        foreach ($row->users as $user) {
            $subexecutors .= $user->full_name .' ,';
        }

        return [
            $row->id,
            $row->document_number ?? '',
            $row->created_at,
            $row->addressed->full_name ?? '',
            $row->preamble ?? '',
            strip_tags($row->text) ?? '',
            $row->author->full_name ?? '',
            $row->executor->full_name ?? '',
            $subexecutors,
            $row->department->title,
            $row->status,
            $row->deadline ?? '',
            $row->real_deadline ?? ''
        ];
    }
}
