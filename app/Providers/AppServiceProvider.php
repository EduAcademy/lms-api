<?php

namespace App\Providers;

use App\Contracts\GenericRepositoryInterface;
use App\Models\Student;
use App\Repositories\GenericRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the GenericRepositoryInterface to GenericRepository for the Student model
        $this->app->bind(GenericRepositoryInterface::class, function ($app) {
            return new GenericRepository(new Student());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
