<?php

namespace App\Providers;

use App\Http\Controllers\ClientOrderController;
use App\Interface\CrudRepoInterface;
use App\Repository\ClientOrderRepo;
use Illuminate\Support\ServiceProvider;

class CrudRepoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(ClientOrderController::class)
            ->needs(CrudRepoInterface::class)
            ->give(function () {
                return new ClientOrderRepo();
            });

        // $this->app->bind(CrudRepoInterface::class, ClientOrderRepo::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
