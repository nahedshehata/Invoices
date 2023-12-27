<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomersReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesAttachmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SectionController;
require __DIR__ . '/auth.php';





Route::get('/',[AuthenticatedSessionController::class,'create']);
Route::get('/home', [HomeController::class,'index'])->middleware(['auth', 'verified'])->name('home');
Route::middleware('auth')->group(function () {
    Route::resource('invoices', InvoicesController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('invoicesAttachment', InvoicesAttachmentController::class);
    Route::get('/section/{id}', [InvoicesController::class, 'getproducts']);
    Route::post('Search_invoices', [InvoicesReportController::class, 'Search_invoices']);
    Route::get('/statusShow/{invoice}/edit', [InvoicesController::class, 'showStatusUpdate'])->name('statusShow');
    Route::post('/statusUpdate/{invoice}', [InvoicesController::class, 'statusUpdate'])->name('statusUpdate');
    Route::get('invoicesReports', [InvoicesReportController::class, 'index'])->name('invoicesReports.index');
    Route::get('customersReport', [CustomersReportController::class,'index'])->name("customersReport");
    Route::post('searchCustomers',[CustomersReportController::class,'searchCustomers'])->name('searchCustomers');
});


 
