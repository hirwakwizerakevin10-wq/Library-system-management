<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LostBookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Middleware\NoCache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::middleware(['auth', NoCache::class])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('role:administrator')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('students', StudentController::class);
        Route::resource('books', BookController::class)->except(['index', 'show']);
        Route::post('borrows/{borrow}/approve', [BorrowController::class, 'approve'])->name('borrows.approve');
        Route::post('borrows/{borrow}/reject', [BorrowController::class, 'reject'])->name('borrows.reject');
        Route::post('borrows/{borrow}/return', [BorrowController::class, 'returnBook'])->name('borrows.return');
        Route::post('borrows/{borrow}/lost', [BorrowController::class, 'lost'])->name('borrows.lost');

        Route::resource('lost-books', LostBookController::class)->only(['index', 'create', 'store', 'show']);

        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('borrowed', [ReportController::class, 'borrowed'])->name('borrowed');
            Route::get('returned', [ReportController::class, 'returned'])->name('returned');
            Route::get('lost', [ReportController::class, 'lost'])->name('lost');
            Route::get('available', [ReportController::class, 'available'])->name('available');
            Route::get('active-students', [ReportController::class, 'activeStudents'])->name('active-students');
        });
    });

    Route::resource('books', BookController::class)->only(['index', 'show']);
    Route::resource('borrows', BorrowController::class)->only(['index', 'create', 'store', 'show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
