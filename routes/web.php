<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Livewire\NotePages;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');

    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
    Route::post('/notes/{note}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
});

require __DIR__ . '/auth.php';
