<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FunctionalityController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Xml\Source;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ModuleController::class, 'index'])->name('Main');
Route::resource('modules', ModuleController::class);
Route::post('modules/all', [ModuleController::class, 'all'])->name('modules.all');

Route::resource('functionalities', FunctionalityController::class);
Route::post('functionalities/all', [FunctionalityController::class, 'all'])->name('functionalities.all');

Route::resource('criteria', CriterionController::class);
Route::post('criteria/all', [CriterionController::class, 'all'])->name('criteria.all');

Route::resource('attachments', AttachmentController::class)->only(['index', 'destroy', 'all', 'store']);
Route::post('attachments/all', [AttachmentController::class, 'all'])->name('attachments.all');

Route::resource('users', UserController::class);

Route::resource('dashboards', DashboardController::class)->only(['index']);
Route::post('dashboards/{functionality}/functionalitystate', [DashboardController::class, 'changeFunctionalityState'])->name('dashboards.functionality.state');
Route::post('dashboards/{criterion}/criterionstate', [DashboardController::class, 'changeCriterionState'])->name('dashboards.criterion.state');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
