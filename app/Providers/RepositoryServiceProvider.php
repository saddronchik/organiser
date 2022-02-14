<?php

namespace App\Providers;

use App\Repositories\EloquentAssignmentsQueries;
use App\Repositories\Interfaces\AssignmentQueries;
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
