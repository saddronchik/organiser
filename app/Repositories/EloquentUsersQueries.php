<?php


namespace App\Repositories;


use App\Models\Assignment;
use App\Models\User;
use App\Repositories\Interfaces\AssignmentQueries;
use App\Repositories\Interfaces\UsersQueries;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentUsersQueries implements UsersQueries
{
    public function getById($id)
    {
        return User::find($id);
    }

    public function getAll()
    {
        $result = User::select('id','full_name')
            ->get();

        return $result;
    }

    public function getByName(string $name)
    {
        return User::where('full_name', $name)->first();
    }
}
