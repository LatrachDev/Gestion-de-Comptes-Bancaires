<?php
require_once '../Helpers/pathUtils.php';
require_once '../autoload.php';

use Core\Router;
use Core\Route;
use App\Controllers\AdminController as Admin;
use App\Controllers\ClientController as Client;
use App\Controllers\AuthController as Auth;
$router = new Router();
Route::setRouter($router);


Route::get('/',[Admin::class,'string']);
Route::get('/signup', [Auth::class,'showSignup']);
Route::post('/signup', [Auth::class,'handleSignup']);


Route::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

