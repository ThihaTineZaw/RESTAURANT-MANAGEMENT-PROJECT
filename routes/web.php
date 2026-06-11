<?php


use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

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
});


Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

Route::get('/menu',[MenuController::class,'index'])->name('menu.index');
Route::get('/menu/create',[MenuController::class,'create'])->name('menu.create');
Route::post('/menu',[MenuController::class,'store'])->name('menu.store');
Route::get('/menu/{menu}/edit',[MenuController::class,'edit'])->name('menu.edit');
Route::put('/menu/{menu}',[MenuController::class,'update'])->name('menu.update');
Route::delete('/menu/{menu}',[MenuController::class,'destroy'])->name('menu.destroy');



require __DIR__.'/auth.php';
