<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SchoolController;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('welcome'));


/*
|--------------------------------------------------------------------------
| Dashboard Redirect (ROLE BASED)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/dashboard', function () {

    return match (auth()->user()->role) {
        'super_admin' => redirect()->route('superAdmin.dashboard'),
        'admin'       => redirect()->route('admin.dashboard'),
        'student',
        'lecturer',
        'staff'       => redirect()->route('user.dashboard'),
        default       => abort(403),
    };

})->name('dashboard');


/*
|--------------------------------------------------------------------------
| SUPER ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('super-admin')
    ->name('superAdmin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class,'index'])
            ->name('dashboard');

        // School Management
        Route::resource('schools', SchoolController::class);

});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class,'index'])
            ->name('dashboard');

        // Users Management
        Route::get('/users', [AdminController::class,'indexUser'])
            ->name('users.index');

        Route::get('/users/{user}/edit', [AdminController::class,'editUser'])
            ->name('users.edit');

        Route::put('/users/{user}', [AdminController::class,'update'])
            ->name('users.update');

        Route::delete('/users/{user}', [AdminController::class,'destroy'])
            ->name('users.destroy');

        // Borrowings Admin View
        Route::get('/borrowings/{borrowings}', [AdminController::class,'showBorrow'])
            ->name('borrowings.show');

        // Information Admin
        Route::get('/information', [InformationController::class,'index'])
            ->name('information.index');

        Route::get('/information/create', [AdminController::class,'createInfo'])
            ->name('information.create');

});


/*
|--------------------------------------------------------------------------
| USER DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class,'index'])
            ->name('dashboard');

});


/*
|--------------------------------------------------------------------------
| SHARED AUTH FEATURES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    | Profile
    */
    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class,'destroy'])->name('profile.destroy');


    /*
    | Books
    */
    Route::resource('books', BookController::class);


    /*
    | Borrowing System
    */
    Route::post('/borrow/{book}', [BorrowingController::class,'requestUser'])
        ->name('request.borrow');

    Route::delete('/borrow/{borrow}/cancel', [BorrowingController::class,'cancel'])
        ->name('borrow.cancel');

    Route::get('/borrowed-books', [BorrowingController::class,'active'])
        ->name('borrowed.index');

    Route::get('/borrowed-books/history', [BorrowingController::class,'history'])
        ->name('borrowed.history');

    Route::get('/borrowed-books/{id}', [BorrowingController::class,'show'])
        ->name('borrowed.show');

    Route::post('/approve/{borrowing}', [BorrowingController::class,'approve'])
        ->name('borrowed.approve');

    Route::post('/reject/{borrowing}', [BorrowingController::class,'reject'])
        ->name('borrowed.reject');

    Route::post('/return/{borrowing}', [BorrowingController::class,'return'])
        ->name('borrowed.return');

    Route::post('/borrowed/{borrowing}', [BorrowingController::class,'markBorrowed'])
        ->name('borrowed.markBorrowed');


    /*
    | Information (Announcement)
    */
    Route::get('/information/create', [InformationController::class,'create'])
        ->name('information.create');

    Route::post('/information', [InformationController::class,'store'])
        ->name('information.store');

    Route::get('/information/{id}', [DashboardController::class,'showInfo'])
        ->name('information.show');

    Route::get('/information/{id}/edit', [InformationController::class,'edit'])
        ->name('information.edit');

    Route::put('/information/{id}', [InformationController::class,'update'])
        ->name('information.update');

    Route::delete('/information/{id}', [InformationController::class,'destroy'])
        ->name('information.destroy');

});

require __DIR__.'/auth.php';