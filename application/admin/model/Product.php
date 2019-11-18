<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class Product extends Model
{
    public function getname($id){
        $data=Db::table('category')->where('id',$id)->field('name')->find();
        return $data;
    }
}