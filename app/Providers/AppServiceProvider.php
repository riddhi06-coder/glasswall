<?php

namespace App\Providers;

use App\Observers\AuditObserver;
use App\Support\ActivityLogger;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** Every model whose activity should be recorded in the audit trail. */
    private array $auditedModels = [
        \App\Models\HomeAbout::class,
        \App\Models\HomeBanner::class,
        \App\Models\HomeBlog::class,
        \App\Models\HomeClientele::class,
        \App\Models\Permission::class,
        \App\Models\ProjectCategory::class,
        \App\Models\ProjectDetail::class,
        \App\Models\ProjectListing::class,
        \App\Models\Role::class,
        \App\Models\User::class,
    ];

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
        Paginator::useBootstrapFive();

        // Attach the audit observer to every tracked model.
        foreach ($this->auditedModels as $model) {
            $model::observe(AuditObserver::class);
        }

        // Authentication activity.
        Event::listen(Login::class, function (Login $event) {
            ActivityLogger::log('login', null, [
                'module'      => 'Authentication',
                'user_id'     => $event->user->getAuthIdentifier(),
                'user_name'   => $event->user->name ?? null,
                'description' => 'Logged in',
            ]);
        });

        Event::listen(Logout::class, function (Logout $event) {
            ActivityLogger::log('logout', null, [
                'module'      => 'Authentication',
                'user_id'     => optional($event->user)->getAuthIdentifier(),
                'user_name'   => optional($event->user)->name,
                'description' => 'Logged out',
            ]);
        });

        Event::listen(Failed::class, function (Failed $event) {
            $email = $event->credentials['email'] ?? 'unknown';
            ActivityLogger::log('login_failed', null, [
                'module'      => 'Authentication',
                'user_id'     => null,
                'user_name'   => $email,
                'description' => 'Failed login attempt for '.$email,
            ]);
        });
    }
}
