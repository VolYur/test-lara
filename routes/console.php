<?php

use App\Console\Commands\UpdateCurrencies;
use Illuminate\Support\Facades\Schedule;

Schedule::command(UpdateCurrencies::class)->everyMinute();
