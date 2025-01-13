<?php
require_once '../Helpers/pathUtils.php';
require_once '../autoload.php';
session_start();

use Core\Router;
use Core\Route;
use App\Controllers\AdminController as Admin;
use App\Controllers\ClientController as Client;
use App\Controllers\AuthController as Auth;
use App\Models\User;
use Helpers\Database;

$db = new Database();
if (!$db->connect()) {
    die('Could not connect to the database');
}
if (User::count($db) === 0) {
    $admin = User::create($db, 'admin', 'mkaroumi123@gmail.com', '123123', 'admin.jpg', 'admin');
}

$router = new Router();
Route::setRouter($router);
// Client routes (only for authenticated users)
Route::get('/', [Client::class, 'index']);

Route::get('/login', [Auth::class, 'login']);
Route::post('/login', [Auth::class, 'handleLogin']);
Route::get('/logout', [Auth::class, 'logout']);

Route::get('/admin', [Admin::class, 'index']);

Route::get('/admin/clients', [Admin::class, 'listClients']);
Route::get('/admin/clients/search', [Admin::class, 'searchClients']);
Route::get('/admin/clients/create', [Admin::class, 'showCreateClient']);
Route::post('/admin/clients/create', [Admin::class, 'createClient']);
Route::get('/admin/clients/{id}', [Admin::class, 'getClient']);
Route::post('/admin/clients/{id}/update', [Admin::class, 'updateClient']);
Route::post('/admin/clients/{id}/remove', [Admin::class, 'removeClient']);

Route::post('/admin/clients/{id}/accounts/create', [Admin::class, 'createBankAccount']);
Route::get('/admin/clients/{id}/accounts', [Admin::class, 'listClientAccounts']);
Route::post('/admin/clients/{id}/accounts/{accountId}/suspend', [Admin::class, 'suspendAccount']);
Route::post('/admin/clients/{id}/accounts/{accountId}/activate', [Admin::class, 'activateAccount']);
Route::post('/admin/clients/{id}/suspend', [Admin::class, 'suspendClient']);
Route::post('/admin/clients/{id}/activate', [Admin::class, 'activateClient']);

Route::get('/admin/reports', [Admin::class, 'getFinancialReport']);

// Add this route with the other admin routes
Route::get('/admin/transactions/search', [Admin::class, 'searchTransactions']);

// Client Routes

Route::get('/transfer', [Client::class,'transfer']);
Route::post('/transfer', [Client::class,'transfer']);
Route::get('/profile', [Client::class,'profile']);
Route::get('/history', [client::class,'history']);
Route::get('/compte', [client::class,'compte']);

Route::post('/update-profile', [Client::class,'updateProfile']);

Route::post('/fund-account', [Client::class, 'fundAccount']);
Route::post('/withdraw', [Client::class, 'withdraw']);


Route::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
