<?php


namespace App\Http\Services\assignment;


use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\StoreUserRequest;
use App\Repositories\EloquentAssignmentsQueries;

class AssignmentService
{
    private $assignmentRepository;

    public function __construct(EloquentAssignmentsQueries $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
    }

    public function createByDepartment(StoreDepartmentRequest $request)
    {

    }

    public function createByAuthor(StoreUserRequest $request)
    {

    }

    public function markAsDone($id): void
    {
        $assignment = $this->getAssignment($id);
        $assignment->done();
    }

    public function markAsExpired($id): void
    {
        $assignment = $this->getAssignment($id);
        $assignment->expire();
    }

    public function remove($id): void
    {
        $assignment = $this->getAssignment($id);
        $assignment->delete();
    }

    private function getAssignment($id)
    {
        return $this->assignmentRepository->find($id);
    }
}
