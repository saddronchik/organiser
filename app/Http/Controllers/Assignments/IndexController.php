<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Status;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index()
    {
        return view('assignment.index');
    }
}
