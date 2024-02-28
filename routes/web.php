<?php

use App\Models\Note;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('notes', 'notes.index')
    ->middleware(['auth'])
    ->name('notes_list');

Route::view('notes/create', 'notes.create')
    ->middleware(['auth'])
    ->name('notes_create');

Volt::route('notes/{note}/edit', 'notes.edit-note')
    ->middleware(['auth'])
    ->name('note_edit');

Route::get('notes/{note}', static function (Note $note) {
    if (!$note->is_published) {
        abort(404);
    }

    $user = $note->user;

    return view('notes.view', compact('note', 'user'));
})->name('note_view');

require __DIR__.'/auth.php';
