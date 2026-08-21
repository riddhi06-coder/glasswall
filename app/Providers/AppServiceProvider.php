<?php

namespace App\Providers;

use App\Observers\AuditObserver;
use App\Support\ActivityLogger;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\ProjectCategory;
use App\Models\ContactDetail;

class AppServiceProvider extends ServiceProvider
{
    /** Every model whose activity should be recorded in the audit trail. */
    private array $auditedModels = [
        \App\Models\AboutUs::class,
        \App\Models\BoardDirector::class,
        \App\Models\Innovation::class,
        \App\Models\Media::class,
        \App\Models\ContactDetail::class,
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

        // Share project categories with the frontend header & footer (dynamic Projects menu).
        View::composer(['components.frontend.header', 'components.frontend.footer'], function ($view) {
            $view->with('navCategories', ProjectCategory::orderBy('priority')->orderBy('name')->get());
        });

        // Share the latest contact details with the frontend footer (address / email / phone).
        View::composer('components.frontend.footer', function ($view) {
            $view->with('footerContact', ContactDetail::with('socialLinks')->latest()->first());
        });
    }
}
