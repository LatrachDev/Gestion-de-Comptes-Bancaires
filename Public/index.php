<?php
require_once '../Helpers/pathUtils.php';
require_once '../autoload.php';

use Core\Router;
use Core\Route;
use App\Controllers\AdminController as Admin;
use App\Controllers\ClientController as Client;
$router = new Router();
Route::setRouter($router);


Route::get('/',[Admin::class,'string']);


Route::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

