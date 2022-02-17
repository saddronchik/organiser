<?php


namespace App\Repositories;


use App\Models\Assignment;
use App\Models\User;
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
        $result = Assignment::with(['users', 'statuses'])
                ->where('assignments.id',[$id])
            ->first();

        return $result;
    }


    public function getByDocumentNumber(int $documentNumber): LengthAwarePaginator
    {
        $result = Assignment::with(['users', 'statuses'])
            ->where('document_number',[$documentNumber])
            ->orderBy('id', 'desc')
            ->paginate(15);

        return $result;
    }

    public function getByUsername(string $username): LengthAwarePaginator
    {
        $userId = User::select('id')
            ->where('full_name', 'LIKE', "%{$username}%")
            ->value('id');

        $result = Assignment::with(['users', 'statuses'])
            ->where('author_id',[$userId])
            ->orWhere('addressed_id', [$userId])
            ->orderBy('id', 'desc')
            ->paginate(15);

        return $result;
    }

    public function getByStatus(int $id): LengthAwarePaginator
    {
        $result = Assignment::with(['users', 'statuses'])
            ->where('status_id',[$id])
            ->paginate(15);

        return $result;
    }

    public function getByDepartment(int $id): LengthAwarePaginator
    {
        $result = Assignment::with(['users', 'statuses'])
            ->where('department_id',[$id])
            ->paginate(15);

        return $result;
    }
}
