<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\DailyVisitor;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Increment and share daily visitor count for the login view
        View::composer('auth.login', function ($view) {
            $today = Carbon::today()->toDateString();
            $visitor = DailyVisitor::firstOrCreate(['date' => $today], ['count' => 0]);
            $visitor->increment('count');
            $visitor->refresh();
            $view->with('dailyVisitorsCount', $visitor->count);
        });
    }
}
