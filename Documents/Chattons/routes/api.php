<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('api')->post('/register', 'AuthController@register');