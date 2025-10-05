<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RolesController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Admin\Users\Index as UsersIndex;
use App\Livewire\Admin\Users\Create as UsersCreate;
use App\Livewire\Admin\Users\Edit as UsersEdit;
use App\Livewire\Admin\Category\Index as CategoryIndex;
use App\Livewire\Admin\Category\Create as CategoryCreate;
use App\Livewire\Admin\Category\Edit as CategoryEdit;
use App\Livewire\Auth\InviteSetPassword;
use App\Livewire\Requester\Ticket\Index as TicketIndex;
use App\Livewire\Requester\Ticket\Create as TicketCreate;
use App\Livewire\Requester\Ticket\Show as TicketShow;

use App\Livewire\Admin\Tickets\Index as AdminTicketsIndex;
use App\Livewire\Technician\Dashboard as TechDashboard;
use App\Livewire\Technician\Tickets\Index as TechTicketsIndex;
use App\Livewire\Technician\Tickets\Show as TechTicketShow;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/invite/accept/{token}', InviteSetPassword::class)
    ->name('invite.accept'); // volontairement sans middleware 'guest'

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth','role:Technicien']) // réservé aux Techniciens
    ->prefix('tech')->as('tech.')
    ->group(function () {
        Route::get('tickets', TechTicketsIndex::class)->name('tickets.index');
        Route::get('tickets/{ticket}', TechTicketShow::class)->name('tickets.show');
        Route::get('dashboard', TechDashboard::class)->name('dashboard');
    });

Route::middleware(['auth', 'permission:admin.access', 'must-set-password'])->prefix('admin')
    ->name('admin')->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('tickets', AdminTicketsIndex::class)->name('tickets.index');
        //Route::get('tickets/{ticket}/edit', AdminTicketsEdit::class)->name('tickets.edit');

        // Gestion utilisateurs “classiques”
        Route::get('users', UsersIndex::class)->name('users.index');
        Route::get('users/create', UsersCreate::class)->name('users.create');
        Route::get('users/{user}/edit', UsersEdit::class)->name('users.edit');

        // Gestion categories
        Route::get('categories', CategoryIndex::class)->name('categories.index');
        Route::get('categories/create', CategoryCreate::class)->name('categories.create');
        Route::get('categories/{category}/edit', CategoryEdit::class)->name('categories.edit');

        // Gestion rôles & permissions (option : Super-Admin uniquement)
        Route::resource('roles', RolesController::class)
              ->only(['index','store','update','destroy'])
              ->middleware('role:Super-Admin');
});

Route::middleware(['auth', 'must-set-password']) // pas besoin d'admin ici
    ->prefix('tickets')->as('tickets.')
    ->group(function () {
        Route::get('/', TicketIndex::class)->name('index')->middleware('permission:tickets.view');
        Route::get('/create', TicketCreate::class)->name('create')->middleware('permission:tickets.create');
        Route::get('/{ticket}', TicketShow::class)->name('show'); // policy fera le reste
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

//
// Invitation-only : bloquer /register s’il reste un lien perdu
Route::match(['get','post'], '/register', function () {
    return redirect()->route('login')
        ->withErrors(['email' => "L’inscription publique est désactivée. Demandez une invitation à l’administrateur (support@fecofa.cd)."]);
})->name('register')->middleware('guest');


require __DIR__.'/auth.php';

