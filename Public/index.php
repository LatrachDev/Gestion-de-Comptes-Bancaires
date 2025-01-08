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

Route::get('/', [Client::class, 'index']);

Route::get('/admin', [Admin::class, 'index']);
Route::get('/admin/client/add', [Admin::class, 'addClient']);

Route::get('/login', [Auth::class, 'login']);
Route::post('/login', [Auth::class, 'handleLogin']);
Route::get('/logout', [Auth::class, 'logout']);

Route::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
