<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware('auth')->get('/products', fn () => view('products.index'))->name('products.index');
    Route::get('/products/trash', [ProductController::class, 'trash'])->name('products.trash');
    Route::resource('products', ProductController::class)->except('index')->middleware('auth');

    Route::get('/activity-log', function () {
        $activities = \Spatie\Activitylog\Models\Activity::with('causer')->latest()->paginate(20);
        return view('activity-log.index', compact('activities'));
    })->middleware('permission:view-activity-log')->name('activity-log.index');
});

require __DIR__.'/auth.php';
