<?php


namespace App\Repositories;


use App\Models\Assignment;
use App\Repositories\Interfaces\AssignmentQueries;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentAssignmentsQueries implements AssignmentQueries
{

    public function getWithPaginate(int $perPage): LengthAwarePaginator
    {
        $result = Assignment::with(['users', 'statuses'])
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return $result;
    }

    public function getById(int $id)
    {
        $result = Assignment::find($id)
            ->with(['users', 'statuses'])
            ->get();

        return $result;
    }
}
