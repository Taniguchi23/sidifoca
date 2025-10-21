<?php

namespace App\Providers;

use App\Repositories\AulaVirtual\Contracts\CourseRepositoryInterface;
use App\Repositories\AulaVirtual\Database\DbCourseRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CourseRepositoryInterface::class, DbCourseRepository::class);
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
