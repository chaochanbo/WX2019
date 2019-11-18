<?php
/**
 * Created by PhpStorm.
 * User: LDH
 * Date: 2019-10-31
 * Time: 11:34
 */

namespace app\api\controller;
use think\Controller;

class Test extends Controller{

    public function index()
    {
        $id = input('id');
        var_dump($id);
//        var_dump(11);
    }
}