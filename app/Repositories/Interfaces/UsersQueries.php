<?php


namespace App\Repositories\Interfaces;


interface UsersQueries
{
    public function getAll();
    public function getById(int $id);
}
