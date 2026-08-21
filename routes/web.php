<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\PreventBackHistoryMiddleware;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Backend\HomeBannerController;
use App\Http\Controllers\Backend\HomeAboutController;
use App\Http\Controllers\Backend\HomeClienteleController;
use App\Http\Controllers\Backend\HomeBlogController;
use App\Http\Controllers\Backend\ProjectCategoryController;
use App\Http\Controllers\Backend\ProjectListingController;
use App\Http\Controllers\Backend\ProjectDetailsController;
use App\Http\Controllers\Backend\ContactDetailsController;
use App\Http\Controllers\Backend\AboutUsController;
use App\Http\Controllers\Backend\BoardDirectorController;





//frontend controller
use App\Http\Controllers\Frontend\HomeController;


    // ----------------------
    // Guest-only auth routes (login / register / forgot password)
    // ----------------------
    Route::middleware('guest')->group(function () {
        // Login
        Route::get('/login',  [LoginController::class, 'login'])->name('admin.login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('admin.authenticate');

        // Register 
        Route::get('/register',  [LoginController::class, 'register'])->name('admin.register');
        Route::post('/register', [LoginController::class, 'authenticate_register'])->name('admin.register.authenticate');

        // Forgot password — request a reset link
        Route::get('/forgot-password',  [LoginController::class, 'showForgotPasswordForm'])->name('admin.password.request');
        Route::post('/forgot-password', [LoginController::class, 'sendResetLink'])->name('admin.password.email');

        // Reset password — clicked from email
        Route::get('/reset-password/{token}', [LoginController::class, 'showResetPasswordForm'])->name('password.reset');
        Route::post('/reset-password',         [LoginController::class, 'resetPassword'])->name('admin.password.update');
    });

    // ----------------------
    // Authenticated admin routes
    // ----------------------
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout',   [LoginController::class, 'logout'])->name('admin.logout');

        // ---- Roles ----
        Route::get('roles',             [RoleController::class, 'index'])->middleware('permission:roles.view')->name('admin.roles.index');
        Route::get('roles/create',      [RoleController::class, 'create'])->middleware('permission:roles.create')->name('admin.roles.create');
        Route::post('roles',            [RoleController::class, 'store'])->middleware('permission:roles.create')->name('admin.roles.store');
        Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:roles.edit')->name('admin.roles.edit');
        Route::put('roles/{role}',      [RoleController::class, 'update'])->middleware('permission:roles.edit')->name('admin.roles.update');
        Route::delete('roles/{role}',   [RoleController::class, 'destroy'])->middleware('permission:roles.delete')->name('admin.roles.destroy');

        // ---- Users ----
        Route::get('users',             [UserController::class, 'index'])->middleware('permission:users.view')->name('admin.users.index');
        Route::get('users/create',      [UserController::class, 'create'])->middleware('permission:users.create')->name('admin.users.create');
        Route::post('users',            [UserController::class, 'store'])->middleware('permission:users.create')->name('admin.users.store');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->middleware('permission:users.edit')->name('admin.users.edit');
        Route::put('users/{user}',      [UserController::class, 'update'])->middleware('permission:users.edit')->name('admin.users.update');
        Route::delete('users/{user}',   [UserController::class, 'destroy'])->middleware('permission:users.delete')->name('admin.users.destroy');

        // ---- Permissions (per-role matrix) ----
        Route::get('permissions',             [PermissionController::class, 'index'])->middleware('permission:permissions.view')->name('admin.permissions.index');
        Route::get('permissions/{role}/edit', [PermissionController::class, 'edit'])->middleware('permission:permissions.assign')->name('admin.permissions.edit');
        Route::put('permissions/{role}',      [PermissionController::class, 'update'])->middleware('permission:permissions.assign')->name('admin.permissions.update');

        // ---- Permission catalog (add new permissions as new modules appear) ----
        Route::get('permissions-catalog',                   [PermissionController::class, 'manage'])->middleware('permission:permissions.assign')->name('admin.permissions.manage');
        Route::get('permissions-catalog/create',            [PermissionController::class, 'createPermission'])->middleware('permission:permissions.assign')->name('admin.permissions.manage.create');
        Route::post('permissions-catalog',                  [PermissionController::class, 'storePermission'])->middleware('permission:permissions.assign')->name('admin.permissions.manage.store');
        Route::get('permissions-catalog/{permission}/edit', [PermissionController::class, 'editPermission'])->middleware('permission:permissions.assign')->name('admin.permissions.manage.edit');
        Route::put('permissions-catalog/{permission}',      [PermissionController::class, 'updatePermission'])->middleware('permission:permissions.assign')->name('admin.permissions.manage.update');
        Route::delete('permissions-catalog/{permission}',   [PermissionController::class, 'destroyPermission'])->middleware('permission:permissions.assign')->name('admin.permissions.manage.destroy');

        // ---- Activity Log (Super Admin only; gated inside the controller) ----
        Route::get('activity-logs',      [ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
        Route::get('activity-logs/{id}', [ActivityLogController::class, 'show'])->whereNumber('id')->name('admin.activity-logs.show');
    
    
        // Home Page
        Route::resource('banner-details', HomeBannerController::class);
        Route::resource('home-about-details', HomeAboutController::class);
        Route::resource('home-clientele', HomeClienteleController::class);
        Route::resource('home-blog-details', HomeBlogController::class);


        // Projects
        Route::resource('manage-project-category', ProjectCategoryController::class);
        Route::post('manage-project-listing/{id}/toggle-home', [ProjectListingController::class, 'toggleHome'])->name('manage-project-listing.toggle-home');
        Route::resource('manage-project-listing', ProjectListingController::class);
        Route::get('manage-project-details/listings-by-category/{category}', [ProjectDetailsController::class, 'listingsByCategory'])->name('manage-project-details.listings-by-category');
        Route::resource('manage-project-details', ProjectDetailsController::class);
        Route::resource('manage-project-details', ProjectDetailsController::class);

        // Contact
        Route::resource('manage-contact-details', ContactDetailsController::class);
  
        // Overview Pages
        Route::resource('manage-about-us', AboutUsController::class);
        Route::resource('manage-board-of-directors', BoardDirectorController::class);

    
    
    });





    // ----------------------
    // 🔹 Frontend Routes
    // ----------------------

    Route::get('/', [HomeController::class, 'index'])->name('frontend.index');
    Route::get('/projects/{category:slug}', [HomeController::class, 'projects'])->name('frontend.projects');
    Route::get('/{category:slug}/{project:slug}', [HomeController::class, 'projects_details'])->name('frontend.projects_details');
    Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('frontend.contact_us');
    Route::get('/about-us', [HomeController::class, 'about_us'])->name('frontend.about_us');
    Route::get('/board-of-directors', [HomeController::class, 'board_of_directors'])->name('frontend.board_of_directors');
