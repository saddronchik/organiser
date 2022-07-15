<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Services\assignment\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $this->userService->create($request['full_name']);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('assignments.index');
    }
}
