<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\View\Composers\OrderComposer;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['orders.create', 'orders.edit'], OrderComposer::class);
    }
}
