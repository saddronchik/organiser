<?php


namespace App\Repositories;


use App\Models\Status;
use App\Repositories\Interfaces\StatusesQueries;

class EloquentStatusesQueries implements StatusesQueries
{

    public function getAll()
    {
        $result = Status::select('id','status','color')
            ->get();
        return $result;
    }

    public function getById(int $id)
    {
        // TODO: Implement getById() method.
    }
}
