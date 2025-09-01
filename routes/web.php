<?php

use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Admin\Users\Index as UsersIndex;
use App\Livewire\Admin\Users\Create as UsersCreate;
use App\Livewire\Admin\Users\Edit as UsersEdit;
use App\Livewire\Admin\Category\Index as CategoryIndex;
use App\Livewire\Auth\InviteSetPassword;
use App\Models\Category;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/invite/accept/{token}', InviteSetPassword::class)
    ->name('invite.accept'); // volontairement sans middleware 'guest'

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware(['auth', 'permission:admin.access', 'must-set-password'])->prefix('admin')
    ->name('admin')->as('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Gestion utilisateurs “classiques”
        Route::get('users', UsersIndex::class)->name('users.index');
        Route::get('users/create', UsersCreate::class)->name('users.create');
        Route::get('users/{user}/edit', UsersEdit::class)->name('users.edit');

        // Gestion categories
        Route::get('categories', CategoryIndex::class)->name('categories.index');
        Route::get('categories/create', CategoryIndex::class)->name('categories.create');
        Route::get('categories/{category}/edit', CategoryIndex::class)->name('categories.edit');

        // Gestion Admins (restreinte au Super-Admin)
       // Route::resource('admins', AdminsController::class)->only(['index','create','store','edit','update','destroy'])->middleware('role:Super-Admin');

        // Gestion rôles & permissions (option : Super-Admin uniquement)
        Route::resource('roles', RolesController::class)
              ->only(['index','store','update','destroy'])
              ->middleware('role:Super-Admin');
    });

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';

