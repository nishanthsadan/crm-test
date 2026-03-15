<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes are in Modules/Auth/Routes/web.php
// Dashboard routes are in Modules/Dashboard/Routes/web.php
// Module routes are registered in each module's service provider
