<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());

        if ($user) {
            return redirect()
                ->back()
                ->with('success', 'Пользователь добавлен успешно.');
        }

        return redirect()
            ->back()
            ->with('error');
    }
}
