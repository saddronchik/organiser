<?php


namespace App\Http\Services\assignment;


use App\Models\User;

class UserService
{
    public function create($fullName)
    {
        return User::new($fullName);
    }
}
