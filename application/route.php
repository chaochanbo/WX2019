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
use think\Route;
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//    'testList/:id'=>'api/test/index',
    'Product/:id'=>'api/Product/getProduct',
    'getComment'=>'api/Comment/getComment',
    'addComment'=>'api/Comment/addComment',
    'getBaseInfo'=>'api/Comment/getBaseInfo',
    'getUserOpenId'=>'api/Comment/getUserOpenId',
    'getBaseDetail'=>'api/Comment/getBaseDetail',
    'getUserInfo'=>'api/Comment/getUserInfo',
    'getUser'=>'api/Comment/getUser',
    'addFab'=>'api/Comment/addFab',
    'getInfo'=>'api/Comment/getInfo',
    'delFab'=>'api/Comment/delFab',

];
//

//Route::get('Product/:id','api/v1.Product/Product');
//Route::rule('testList','api/test/index');
// Route::rule('hello','');