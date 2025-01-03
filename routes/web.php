<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/reset-password', function (Request $request) {
    $token = $request->query('token');
    $email = $request->query('email');

    return view('mail.confirm', compact('token', 'email'));
})->name('password.reset');


Route::get('/', function () {
    return view('welcome');
});
