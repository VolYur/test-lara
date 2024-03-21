Test edu project

How to run:

- composer install
- php artisan migrate:refresh --seed
- php -S localhost:8000 -t public
- add to cron configuration: * * * * * cd /project-path && php artisan schedule:run >> /dev/null 2>&1


Postman collection [test.postman_collection.json](test.postman_collection.json)

```
Route::get('/currencies', [CurrenciesController::class, 'index']);
Route::get('/currencyExchangeRates', [CurrencyExchangeRatesController::class, 'index']);
Route::get('/banks', [BanksController::class, 'index']);
Route::get('/banks/{slug}', [BanksController::class, 'show']);
Route::get('/bankBranches', [BankBranchesController::class, 'index']);
```

```
Schedule::command(UpdateCurrencies::class)->hourly();
```