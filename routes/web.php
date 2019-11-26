<?php

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

Route::get('index',[
    'as'=>'trang-chu',
    'uses'=>'PageController@getIndex'
]);
Route::get('loai-san-pham/{type}',[
    'as'=>'loaisanpham',
    'uses'=>'PageController@getLoaiSp'
]);
Route::get('chi-tiet-san-pham/{id}',[
    'as'=>'chitietsanpham',
    'uses'=>'PageController@getchiTiet'
]);
Route::get('lien-he',[
    'as'=>'lienhe',
    'uses'=>'PageController@getLienhe'
]);
Route::get('gioi-thieu',[
    'as'=>'gioithieu',
    'uses'=>'PageController@getGioithieu'
]);
Route::get('dat-hang',[
    'as'=>'dathang',
    'uses'=>'PageController@getDatHang'
]);

//thêm vào giỏ hàng
Route::get('add-to-cart/{id}',[
    'as'=>'themgiohang',
    'uses'=>'PageController@getAddtoCart'
]);

//xóa giỏ hàng
Route::get('del-cart/{id}',[
    'as'=>'xoagiohang',
    'uses'=>'PageController@getDelitemCart'
]);

//dat hang
Route::post('dat-hang',[
    'as'=>'dathang',
    'uses'=>'PageController@postDatHang'
]);