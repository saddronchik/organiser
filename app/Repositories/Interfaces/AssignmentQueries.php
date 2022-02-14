<?php


namespace App\Repositories\Interfaces;


interface AssignmentQueries
{
    public function getWithPaginate(int $perPage);
    public function getById(int $id);
}
