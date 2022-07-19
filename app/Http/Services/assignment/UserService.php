<?php


namespace App\Http\Services\assignment;

use App\Models\User;
use App\Repositories\EloquentUsersQueries;

class UserService
{
    private $userRepository;

    public function __construct(EloquentUsersQueries $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($fullName)
    {
        return User::new($fullName);
    }

    public function getOrCreate($fullName)
    {
        return User::firstOrCreate(['full_name' => $fullName]);
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

}
