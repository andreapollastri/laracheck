<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/jobs/'.config('project.jobsPath'), function () {
    Artisan::call('schedule:run');

    return 'OK';
});
