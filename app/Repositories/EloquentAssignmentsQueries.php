<?php


namespace App\Repositories;


use App\Models\Assignment;
use App\Models\User;
use App\Repositories\Interfaces\AssignmentQueries;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentAssignmentsQueries implements AssignmentQueries
{

    public function getByColumns(array $columns): Collection
    {
        $result = Assignment::with(['users'])
            ->select($columns)
            ->orderBy('id', 'desc')
            ->get();

        return $result;
    }

    public function getWithPaginate(int $perPage): LengthAwarePaginator
    {
        $result = Assignment::with(['users'])
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return $result;
    }

    public function find($id)
    {
        $result = Assignment::with([
            'users',
            'department',
            'author',
            'addressed',
            'executor'])
                ->where('assignments.id',[$id])
            ->first();

        return $result;
    }


    public function getByDocumentNumber(string $documentNumber): LengthAwarePaginator
    {
        $result = Assignment::with(['users'])
            ->where('document_number','LIKE', "%$documentNumber%")
            ->orderBy('id', 'desc')
            ->paginate(15);

        return $result;
    }

    public function getByAuthor(string $username)
    {
        $user = User::where('full_name', 'LIKE', "%{$username}%")->first();

        $result = Assignment::with(['users'])
            ->where('author_id',[$user->id])
            ->orderBy('id', 'desc')
            ->paginate(15);

        return $result;
    }

    public function getByAddressed(string $username)
    {
        $user = User::where('full_name', 'LIKE', "%{$username}%")->first();

        $result = Assignment::with(['users'])
            ->where('addressed_id',[$user->id])
            ->orderBy('id', 'desc')
            ->paginate(15);

        return $result;
    }

    public function getByStatus(string $status): LengthAwarePaginator
    {
        $result = Assignment::with(['users'])
            ->where('status',[$status])
            ->paginate(15);

        return $result;
    }

    public function getByDepartmentWithPaginate(int $id): LengthAwarePaginator
    {
        $result = Assignment::with(['users'])
            ->where('department_id',[$id])
            ->paginate(15);

        return $result;
    }

    public function getByDepartment(int $id)
    {
        $result = Assignment::with(['users'])
            ->where('department_id',[$id])
            ->get();

        return $result;
    }
}
