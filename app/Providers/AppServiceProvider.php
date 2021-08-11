<?php

namespace App\Providers;
use App\Models\Page;
use App\Models\Issue;
use View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        $allPages = Page::get();
        View::share ('allPages', $allPages);
        $archives = Issue::groupBy('year')->orderBy('year','ASC')->get(['year']);
        View::share ('archives', $archives);
        $latest = Issue::latest()->first();
        View::share ('latest', $latest);
    }
}
