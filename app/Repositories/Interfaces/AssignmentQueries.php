<?php


namespace App\Repositories\Interfaces;


interface AssignmentQueries
{
    public function getByColumns(array $columns);
    public function getWithPaginate(int $perPage);
    public function getById(int $id);
    public function getByDocumentNumber(string $documentNumber);
    public function getByAuthor(string $username);
    public function getByAddressed(string $username);
    public function getByStatus(string $status);
    public function getByDepartmentWithPaginate(int $id);
    public function getByDepartment(int $id);
}
