<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ideascontroller;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/ideas', [ideascontroller::class, 'index'])->name('ideas');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/ideas/detail/{id}', [ideascontroller::class, 'detail'])->name('ideaDetail');
Route::post('/save-idea', [ideascontroller::class, 'saveIdea'])->name('saveIdea');
Route::post('/upvote', [IdeasController::class, 'upvote'])->name('upvote');


Route::middleware(['guest'])->group(function () {
    Route::get('/account/register', [AccountController::class, 'registration'])->name('account.registration');
    Route::get('/account/login', [AccountController::class, 'login'])->name('account.login');
    Route::post('/account/process-register', [AccountController::class, 'processRegistration'])->name('account.processRegistration');
    Route::post('/account/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::put('/account/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::post('/account/update-profile-pic', [AccountController::class, 'updateProfilePic'])->name('account.updateProfilePic');
    Route::get('/account/logout', [AccountController::class, 'logout'])->name('account.logout');
    Route::get('/account/create-idea', [AccountController::class, 'createIdea'])->name('account.createIdea');
    Route::get('/account/edit/{ideaId}', [AccountController::class, 'editIdea'])->name('account.editIdea');
    Route::post('/account/update-idea/{ideaId}', [AccountController::class, 'updateIdea'])->name('account.updateIdea');
    Route::post('/account/save-idea', [AccountController::class, 'saveIdea'])->name('account.saveIdea');
    Route::get('/account/saved-ideas', [AccountController::class, 'savedIdeas'])->name('account.savedIdeas');
    Route::get('/account/my-ideas', [AccountController::class, 'myIdeas'])->name('account.myIdeas');
    Route::post('/account/delete-idea', [AccountController::class, 'deleteIdea'])->name('account.deleteIdea');
    Route::post('/remove-saved-idea', [AccountController::class, 'removeSavedIdea'])->name('account.removeSavedIdea');
    Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');
    
});
