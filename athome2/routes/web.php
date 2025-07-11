<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\User\Dashboard as UserDashboard;
use App\Livewire\HouseListings;
use App\Livewire\CreateListing;
use App\Livewire\MediaManager;
use App\Livewire\HouseDetails;
use App\Livewire\FavoritesList;
use App\Livewire\RentalManagement;
use App\Livewire\UserRentals;
use App\Livewire\ConversationsList;
use App\Livewire\ConversationMessages;
use App\Livewire\CreateConversation;
use Livewire\Livewire;


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->isAdmin() ? redirect('/admin/dashboard') : redirect('/user/dashboard');
    })->name('dashboard');

    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');

    });

    Route::middleware('user')->group(function () {
        Route::get('/user/dashboard', UserDashboard::class)->name('user.dashboard');

    });
});

Route::get('/', HouseListings::class)->name('home');
Route::get('/new-listing', CreateListing::class)->name('new-listing')->middleware(['auth']);
Route::get('/add-images/{houseId}', MediaManager::class)->name('add-images')->middleware(['auth']);
Route::get('/house/{houseId}', HouseDetails::class)->name('house.show');
Route::get('/favorites', FavoritesList::class)->name('favorites');
Route::get('/rentals', RentalManagement::class)->middleware(['auth'])->name('rentals');
Route::get('/my-rentals', UserRentals::class)->name('my-rentals')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/conversations', ConversationsList::class)->name('conversations.index');
    Route::get('/conversations/create/{house_id?}', CreateConversation::class)->name('conversations.create');
    Route::get('/conversations/{conversation}', function($conversation) {
        return view('conversations.show', ['conversationId' => $conversation]);
    })->name('conversations.show');
});

// Footer Content Routes
Route::view('/privacy-policy', 'privacy-policy')->name('privacy.policy');
Route::view('/terms-of-service', 'terms-service')->name('terms.service');

require __DIR__.'/auth.php';