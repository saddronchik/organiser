<?php


namespace App\Repositories\Interfaces;


interface UsersQueries
{
    public function getAll();
    public function getById($id);
    public function getByName(string $name);
}
