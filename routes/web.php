<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SchoolController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\School;


/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $school = School::first();
    return view('welcome', compact('school'));
});


/*
|--------------------------------------------------------------------------
| Localization Route
|--------------------------------------------------------------------------
*/

Route::middleware('web')->get('/lang/{locale}', function ($locale) {

    abort_unless(in_array($locale, ['id', 'en']), 404);

    session()->put('locale', $locale);
    session()->save();

    return redirect()->back();

})->name('lang.switch');
/*
|--------------------------------------------------------------------------
| Dashboard Redirect (ROLE BASED)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/dashboard', function () {

    return match (auth()->user()->role) {
        'admin'       => redirect()->route('admin.dashboard'),
        'student',
        'lecturer',
        'staff'       => redirect()->route('user.dashboard'),
        default       => abort(403),
    };

})->name('dashboard');







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

        Route::get('/users/create', [AdminController::class,'createUser'])
            ->name('users.create');

        Route::post('/users/store',[AdminController::class, 'storeUser'])
            ->name('users.store');

        Route::post('/admin/users/import/process', [AdminController::class, 'importPreview'])->name('users.import.process');

        Route::get('/admin/users/import/preview', [AdminController::class, 'showPreview'])->name('users.import.preview.show');

        Route::post('/admin/users/import/confirm', [AdminController::class, 'importConfirm'])->name('users.import.confirm');

        Route::post('/admin/users/import/confirm',[AdminController::class,'importConfirm'])
        ->name('users.import.confirm');

        Route::get('/admin/users/template/{role}',[AdminController::class, 'downloadTemplate'])
        ->name('users.template');

        Route::get('/users/{user}/edit', [AdminController::class,'editUser'])
            ->name('users.edit');

        Route::put('/users/{user}', [AdminController::class,'updateUser'])
            ->name('users.update');

        Route::delete('/users/{user}', [AdminController::class,'destroyUser'])
            ->name('users.destroy');

        // Borrowings Admin View
        Route::get('/borrowings/{borrowings}', [AdminController::class,'showBorrow'])
            ->name('borrowings.show');

        // Information Admin
        Route::get('/information', [InformationController::class,'index'])
            ->name('information.index');

        Route::get('/information/create', [AdminController::class,'createInfo'])
            ->name('information.create');

        Route::get('/school', [SchoolController::class,'edit'])
            ->name('school.edit');

        Route::put('/school', [SchoolController::class,'update'])
            ->name('school.update');

        Route::delete('/admin/review/{id}', [ReviewController::class,'destroy'])
            ->name('review.delete');

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
    | FAQ
    */
    Route::get('/faq', function () {
        return view('user.faq.index');
    })->name('faq');

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
    Route::post('/books/{id}/review',[ReviewController::class,'store'])->name('review.store');
    Route::get('/books/{book}/reviews',[ReviewController::class,'index'])->name('review.index');

    /*
    | Borrowing System
    */
    Route::post('/borrow/{book}', [BorrowingController::class,'requestUser'])
        ->middleware(['auth','phone.filled'])
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