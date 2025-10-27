<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Task;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Kueri dasar untuk pengguna yang sedang login
    $userId = Auth::id();
    
    // --- 1. Statistik Perusahaan ---
    $totalCompanies = Company::where('user_id', $userId)->count();
    
    // --- 2. Statistik Kontak ---
    $totalContacts = Contact::where('user_id', $userId)->count();
    $newContactsThisMonth = Contact::where('user_id', $userId)
        ->where('created_at', '>=', Carbon::now()->startOfMonth())
        ->count();

    // --- 3. Statistik Tugas ---
    $totalPendingTasks = Task::where('user_id', $userId)
        ->where('is_completed', false)
        ->count();
        
    $totalCompletedTasks = Task::where('user_id', $userId)
        ->where('is_completed', true)
        ->count();
        
    $overdueTasks = Task::where('user_id', $userId)
        ->where('is_completed', false)
        ->where('due_date', '<', Carbon::today())
        ->count();

    return view('dashboard', compact(
        'totalCompanies',
        'totalContacts',
        'newContactsThisMonth',
        'totalPendingTasks',
        'totalCompletedTasks',
        'overdueTasks'
    ));

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Route untuk menyimpan interaksi baru (berada di bawah detail kontak)
    Route::post('/contacts/{contact}/interactions', [App\Http\Controllers\InteractionController::class, 'store'])
        ->name('interactions.store');
    Route::resource('tasks', TaskController::class);
    // CRUD Resource untuk Company
    // Perhatikan: kita menamainya 'companies' sesuai konvensi resource
    Route::resource('companies', CompanyController::class);
    // Routes Kontak (BARU)
    Route::resource('contacts', ContactController::class);

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('admin/users', \App\Http\Controllers\Admin\UserController::class)
            ->only(['index', 'edit', 'update'])
            ->names('admin.users');
    });
});

require __DIR__.'/auth.php';
