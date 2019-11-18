<?php
/**
 * Created by PhpStorm.
 * User: LDH
 * Date: 2019-10-30
 * Time: 18:12
 */

namespace app\api\model;


use think\Model;
use think\Db;

class Product extends Model
{
    public static function getpro($id)
    {
        $result = Db::table('product')->where('code',$id)->select();
        return $result;
    }
}