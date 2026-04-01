<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// The Secret Database Setup Route 
Route::get('/setup-database', function () {
    Artisan::call('migrate:fresh', [
        '--force' => true,
        '--seed' => true
    ]);
    return 'Database migrated and seeded successfully! You can go back to the dashboard now.';
});

// The Main Route 
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');