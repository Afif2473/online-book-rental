<?php
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RentalController;
use App\Models\Rental;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('auth.register');
});

Route::get('/dashboard', [RentalController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/settings', function () {
    return view('settings', [
        'user' => auth()->user()
    ]);
})->middleware(['auth', 'verified'])->name('settings');

Route::post('/books/{book}/rent', [RentalController::class, 'store'])->name('rentals.store')->middleware('auth');
Route::resource('books', BookController::class)->middleware('auth');
Route::patch('/rentals/{rental}/approve', [App\Http\Controllers\RentalController::class, 'approve'])->name('rentals.approve')->middleware('auth');
Route::patch('/rentals/{rental}/reject', [App\Http\Controllers\RentalController::class, 'reject'])->name('rentals.reject')->middleware('auth');
Route::patch('/rentals/{rental}/return', [App\Http\Controllers\RentalController::class, 'markReturned'])->name('rentals.return')->middleware('auth');
Route::delete('/rentals/{rental}', [App\Http\Controllers\RentalController::class,'cancel'])->name('rentals.cancel')->middleware('auth');
Route::patch('/rentals/{rental}/pickup', [App\Http\Controllers\RentalController::class, 'markPickedUp'])->name('rentals.pickup')->middleware('auth');

Route::get('/report', [ReportController::class, 'index'])->name('report.index')->middleware('auth');

Route::get('/email/verify', function(){
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request){
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request){
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6.1'])->name('verification.send');

Route::get('/report/exportPDF', [ReportController::class, 'exportPDF'])->name('report.exportPDF')->middleware('auth');

require __DIR__.'/auth.php';
