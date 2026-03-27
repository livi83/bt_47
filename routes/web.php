<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Homepage


Route::get('/', function () {
    return view('site.home');
});

Route::get('/about', function () {
    return view('site.about');
});

Route::get('/contact', function () {
    return view('site.contact');
});

Route::post('/contact', function (Request $request) {
    $data = $request->validate([
        'name' => ['required', 'min:2'],
        'email' => ['required', 'email'],
        'message' => ['required', 'min:5'],
    ]);

    return view('site.thanks', $data);
});