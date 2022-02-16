<?php


namespace App\Repositories;


use App\Models\Assignment;
use App\Models\User;
use App\Repositories\Interfaces\AssignmentQueries;
use App\Repositories\Interfaces\UsersQueries;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentUsersQueries implements UsersQueries
{
    public function getById(int $id)
    {
        // TODO: Implement getById() method.
    }

    public function getAll()
    {
        $result = User::select('id','full_name')
            ->get();

        return $result;
    }
}
