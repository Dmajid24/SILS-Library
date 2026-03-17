<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\adminController;




use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'student', 'lecturer', 'staff' => redirect()->route('user.dashboard'),
        default => abort(403),
    };
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    });

Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    });
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    


    Route::resource('books',BookController::class);

    // Route::get('/admin/borrowings',[BorrowingController::class,'requestAdmin'])->name('admin.borrow');
    Route::get('/admin/borrowings/{borrowings}',[adminController::class,'showBorrow'])->name('admin.borrowings.show');
    Route::get('/admin/users', [adminController::class,'indexUser'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [adminController::class,'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [adminController::class,'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [adminController::class,'destroy'])->name('admin.users.destroy');
    Route::get('/admin/information', [InformationController::class,'index'])->name('admin.information.index');
    Route::get('/admin/information/create', [adminController::class,'createInfo'])->name('admin.information.create');
    
    Route::post('/borrow/{book}',[BorrowingController::class,'requestUser'])->name('request.borrow');
    Route::delete('/borrow/{borrow}/cancel',[BorrowingController::class,'cancel'])->name('borrow.cancel');
    Route::get('/borrowed-books',[BorrowingController::class,'index'])->name('borrowed.index');
    Route::post('/approve/{borrowing}',[BorrowingController::class,'approve'])->name('borrowed.approve');
    Route::post('/reject/{borrowing}',[BorrowingController::class,'reject'])->name('borrowed.reject');
    Route::post('/return/{borrowing}',[BorrowingController::class,'return'])->name('borrowed.return');
    Route::post('/borrowed/{borrowing}',[BorrowingController::class,'markBorrowed'])->name('borrowed.markBorrowed');
    Route::get('/borrowed-books/{id}',[BorrowingController::class,'show'])->name('borrowed.show');


    Route::get('/information/create', [InformationController::class,'create'])->name('information.create');
    Route::post('/information', [InformationController::class,'store'])->name('information.store');
    Route::get('/information/{id}/edit',[InformationController::class,'edit'])->name('information.edit');
    Route::put('/information/{id}',[InformationController::class,'update'])->name('information.update');
    Route::delete('/information/{id}',[InformationController::class,'destroy'])->name('information.destroy');
    Route::get('/information/{id}',[DashboardController::class,'showInfo'])->name('information.show');
    
    Route::resource('book', BookController::class);

});

require __DIR__.'/auth.php';
