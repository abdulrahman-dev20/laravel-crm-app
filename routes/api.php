<?php
// routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import Controllers API Anda
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ContactController; // Tambahkan ini
use App\Http\Controllers\Api\TaskController;    // Tambahkan ini


// Kelompokkan semua route yang memerlukan token Sanctum
Route::middleware('auth:sanctum')->group(function () {
    
    // ----------------------------------------------------------------------
    // 4. Route default (URL: /api/user)
    // ----------------------------------------------------------------------
    Route::get('/user', function (Request $request) {
        // Mengembalikan data user yang sedang login
        return $request->user();
    });
});
