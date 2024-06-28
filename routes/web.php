<?php

use App\Livewire\LobbyPage;
use App\Livewire\RegisterPage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use \Illuminate\Support\Facades\Auth;

Route::get('/', LobbyPage::class)->name('lobby')->middleware('auth:web');
Route::get('auth', RegisterPage::class)->name('login')->middleware('guest');

Route::post('/logout/', function () {
    auth()->logout();
    return redirect(route('login'));
})->name('logout');
