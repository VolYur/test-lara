<?php

use App\Http\Controllers\BankBranchesController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\CurrenciesController;
use App\Http\Controllers\CurrencyExchangeRatesController;
use Illuminate\Support\Facades\Route;

Route::get('/currencies', [CurrenciesController::class, 'index']);
Route::get('/currencyExchangeRates', [CurrencyExchangeRatesController::class, 'index']);
Route::get('/banks', [BanksController::class, 'index']);
Route::get('/banks/{slug}', [BanksController::class, 'show']);
Route::get('/bankBranches', [BankBranchesController::class, 'index']);
