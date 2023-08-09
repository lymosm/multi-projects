<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');
Route::get('product/:id', 'Product/index');
Route::get('cate/:uri', 'Cate/index');
Route::get('account/view-order/:type', 'Home/account');
Route::get('account/:type', 'Home/account');
Route::get('account', 'Home/account');
Route::get('logout', 'Home/logout');
// Route::get('checkout/key/:order', 'Checkout/result');
