<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('dashboard/edit/{id}', [CustomAuthController::class, 'edit'])->name('edit');
Route::post('dashboard/update/{id}', [CustomAuthController::class, 'update'])->name('update');
Route::post('dashboard/delete/{id}', [CustomAuthController::class, 'delete'])->name('delete');
Route::post('dashboard/fav/{id}', [CustomAuthController::class, 'fav'])->name('fav');
Route::post('dashboard/deletefav/{id}', [CustomAuthController::class, 'deletefav'])->name('deletefav');
Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
Route::post('dashboard', [CustomAuthController::class, 'insert'])->name('post'); 
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');