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

// Route::get('/', function () {
//     return view('welcome');
// });

#頁面
//登入
Route::get('/', 'AccountsController@index');
//註冊
Route::get('/bank/signup', function () {
    return view('signup');
});
//主頁
Route::get('/bank/homepage', 'AccountInfoController@index')->middleware('userAuth');;
// 存款
Route::get('/bank/deposit', 'AccountInfoController@deposit_page')->middleware('userAuth');;
//提款
Route::get('/bank/withdrawal', 'AccountInfoController@withdrawal_page')->middleware('userAuth');;
//登出
Route::get('/bank', 'AccountsController@signout');


#功能
//登入
Route::post('/bank/login', 'AccountsController@login');
//註冊
Route::post('/bank/signup', 'AccountsController@signup');
//存款
Route::post('/bank/deposit', 'AccountInfoController@deposit')->middleware('userAuth');;
//提款
Route::post('/bank/withdrawal', 'AccountInfoController@withdrawal')->middleware('userAuth');;
//搜尋
Route::post('/bank/show', 'AccountInfoController@show')->middleware('userAuth');;



//讀取資料庫資料
// Route::get('/accounts/accountInfo', function () {
//     return App\Models\AccountInfo::all();
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
