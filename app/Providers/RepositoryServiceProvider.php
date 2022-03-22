<?php

namespace App\Providers;

use App\Repositories\EloquentAssignmentsQueries;
use App\Repositories\EloquentDepartmentsQueries;
use App\Repositories\EloquentUsersQueries;
use App\Repositories\Interfaces\AssignmentQueries;
use App\Repositories\Interfaces\DepartmentsQueries;
use App\Repositories\Interfaces\UsersQueries;
use Illuminate\Support\ServiceProvider;
use function Psy\bin;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AssignmentQueries::class,
            EloquentAssignmentsQueries::class
        );

        $this->app->bind(
            UsersQueries::class,
            EloquentUsersQueries::class
        );

        $this->app->bind(
            DepartmentsQueries::class,
            EloquentDepartmentsQueries::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
