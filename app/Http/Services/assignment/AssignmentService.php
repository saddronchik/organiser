<?php


namespace App\Http\Services\assignment;


use App\Http\Requests\Assignment\EditRequest;
use App\Http\Requests\Assignment\StoreRequest;
use App\Models\Assignment;
use App\Models\Department;
use App\Models\User;
use App\Repositories\EloquentAssignmentsQueries;
use App\Repositories\Interfaces\UsersQueries;
use Carbon\Carbon;

class AssignmentService
{
    private $assignmentRepository;
    private $userRepository;

    public function __construct(EloquentAssignmentsQueries $assignmentRepository, UsersQueries $userRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->userRepository = $userRepository;
    }

    public function create(StoreRequest $request, ?User $author, ?User $addressed, ?User $executor, ?Department $department)
    {
        return \DB::transaction(function () use ($request, $author, $addressed, $executor, $department) {

            /** @var Assignment $assignment $assignment */
            $assignment = Assignment::make([
                'document_number' => $request['document_number'],
                'preamble' => $request['preambule'],
                'text' => $request['resolution'],
                'author_id' => $author->id ?? $request['author'],
                'addressed_id' => $addressed->id ?? $request['addressed'],
                'executor_id' => $executor->id ?? $request['executor'],
                'department_id' => $department->id ?? $request['department'],
                'status' => $request['status'] ?? Assignment::STATUS_IN_PROGRESS,
                'deadline' => $request['deadline'],
                'real_deadline' => $request['fact_deadline'],
                'register_date' => $request['register_date']
            ]);

            $assignment->saveOrFail();
            $users = $this->userRepository->getById($request->get('subexecutors'));
            $assignment->users()->attach($users);
        });
    }

    public function edit($id, ?Department $department, ?User $author, ?User $addressed, ?User $executor, EditRequest $request)
    {
        return \DB::transaction(function () use ($id, $department, $author, $addressed, $executor, $request) {
            /** @var Assignment $assignment */
            $assignment = $this->getAssignment($id);
            $status = $request->get('status');

            $assignment->update([
                'document_number' => $request['document_number'],
                'preamble' => $request['preambule'],
                'text' => $request['resolution'],
                'author_id' => $author->id ?? $request['author'],
                'addressed_id' => $addressed->id ?? $request['addressed'],
                'executor_id' => $executor->id ?? $request['executor'],
                'department_id' => $department->id ?? $request['department'],
                'register_date' => $request['register_date'],
                'deadline' => $request['deadline'],
                'real_deadline' => $request['fact_deadline']
            ]);

            if ($status === Assignment::STATUS_DONE) {
                $assignment->done();
            } elseif ($status === Assignment::STATUS_EXPIRED) {
                $assignment->expire();
            } elseif ($status === Assignment::STATUS_IN_PROGRESS) {
                $assignment->extend();
            }

            $users = $this->userRepository->getById($request->get('subexecutors'));
            $assignment->users()->sync($users);
        });
    }

    public function markAsDone($id): void
    {
        /** @var Assignment $assignment $assignment */
        $assignment = $this->getAssignment($id);
        $assignment->done();
    }

    public function markAsExpired($id): void
    {
        /** @var Assignment $assignment $assignment */
        $assignment = $this->getAssignment($id);
        $assignment->expire();
    }

    public function extend($id, $date)
    {
        /** @var Assignment $assignment $assignment */
        $assignment = $this->getAssignment($id);
        $assignment->extend($date);
    }

    public function remove($id): void
    {
        /** @var Assignment $assignment $assignment */
        $assignment = $this->getAssignment($id);
        $assignment->delete();
    }

    private function getAssignment($id)
    {
        return $this->assignmentRepository->find($id);
    }

    public function find(int $id)
    {
        return $this->getAssignment($id);
    }

    private function gtTomorrow($date): bool
    {
        return !Carbon::parse($date)->gt(Carbon::now()->addDay());
    }
}
