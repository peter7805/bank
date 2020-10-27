<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

#頁面
//登入
Route::get('/bank', 'AccountsController@index');
//註冊
Route::get('/bank/signup', function () {
    return view('signup');
});
//主頁
Route::get('/bank/homepage', function () {
    return view('homepage');
});
//存款
Route::get('/bank/deposit', function () {
    return view('deposit');
});
//提款
Route::get('/bank/withdrawal', function () {
    return view('withdrawal');
});
//搜尋
Route::get('/bank/search', function () {
    return view('search');
});

#功能
//登入
Route::post('/bank/login', 'AccountsController@login');
//註冊
Route::post('/bank/signup', 'AccountsController@signup');



//讀取資料庫資料
// Route::get('/accounts/accountInfo', function () {
//     return App\Models\AccountInfo::all();
// });
