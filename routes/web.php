<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;

// ─── Publieke & Medewerker Pagina's ──────────────────────────────────────────
Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/producten', [ProductController::class, 'index'])->name('products.index');
Route::get('/producten/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/winkelwagen', [CartController::class, 'index'])->name('cart.index');
Route::post('/winkelwagen/toevoegen', [CartController::class, 'add'])->name('cart.add');
Route::post('/winkelwagen/verwijderen', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/winkelwagen/claimen', [CartController::class, 'claim'])->name('cart.claim');
Route::get('/winkelwagen/bevestiging/{claimId}', [CartController::class, 'success'])->name('cart.success');

Route::get('/over', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');

// ─── Authenticatie ────────────────────────────────────────────────────────────
Route::get('/inloggen', [AuthController::class, 'showLogin'])->name('login');
Route::post('/inloggen', [AuthController::class, 'login'])->name('login.post');
Route::get('/aanmelden', [AuthController::class, 'showRegister'])->name('register');
Route::post('/aanmelden', [AuthController::class, 'register'])->name('register.post');
Route::post('/uitloggen', [AuthController::class, 'logout'])->name('logout');

// ─── Ingelogde Medewerkers ────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/account', [AuthController::class, 'account'])->name('account');
    Route::post('/account', [AuthController::class, 'updateAccount'])->name('account.update');
});

// ─── Admin Beheer ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Producten beheren
    Route::get('/producten', [AdminController::class, 'products'])->name('products.index');
    Route::get('/product-aanmaken', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/product-aanmaken', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/product-bewerken/{id}', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::post('/product-bewerken/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::post('/product-verwijderen/{id}', [AdminController::class, 'deleteProduct'])->name('products.delete');
    Route::post('/product-beschikbaarheid/{id}', [AdminController::class, 'toggleAvailability'])->name('products.toggle');
    
    // Codes beheren
    Route::get('/codes', [AdminController::class, 'codes'])->name('codes.index');
    Route::post('/codes', [AdminController::class, 'storeCode'])->name('codes.store');
    Route::post('/codes-verwijderen/{id}', [AdminController::class, 'deleteCode'])->name('codes.delete');
});
