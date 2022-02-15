<?php


namespace App\Repositories\Interfaces;


interface StatusesQueries
{
    public function getAll();
    public function getById(int $id);
}
