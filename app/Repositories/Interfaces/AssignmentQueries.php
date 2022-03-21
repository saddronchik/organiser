<?php


namespace App\Repositories\Interfaces;


interface AssignmentQueries
{
    public function getByColumns(array $columns);
    public function getWithPaginate(int $perPage);
    public function getById(int $id);
    public function getByDocumentNumber(int $documentNumber);
    public function getByUsername(string $username);
    public function getByStatus(int $id);
    public function getByDepartmentWithPaginate(int $id);
    public function getByDepartment(int $id);
}
