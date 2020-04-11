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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[
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
Route::get('dat-hang',[
    'as'=>'dathang',
    'uses'=>'PageController@getDatHang'
]);
Route::post('dat-hang',[
    'as'=>'dathang',
    'uses'=>'PageController@postDatHang'
]);

//dang nhap
Route::get('dang-nhap',[
    'as'=>'dangnhap',
    'uses'=>'PageController@getdangNhap'
]);
Route::post('dang-nhap',[
    'as'=>'dangnhap',
    'uses'=>'PageController@postdangNhap'
]);

//dang ky
Route::get('dang-ky',[
    'as'=>'dangky',
    'uses'=>'PageController@getdangKy'
]);
Route::post('dang-ky',[
    'as'=>'dangky',
    'uses'=>'PageController@postdangKy'
]);

//dang xuat
Route::get('dang-xuat',[
    'as'=>'dangxuat',
    'uses'=>'PageController@getdangXuat'
]);

//tim kiem
Route::get('search',[
    'as'=>'search',
    'uses'=>'PageController@getSearch'
]);