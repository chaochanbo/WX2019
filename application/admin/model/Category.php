<?php
namespace app\admin\model;
use think\Model;
class Category extends Model
{
    public function category(){
        $data=$this::select();
        
    }

    public function add($data){
        db('category')->insert($data);
    }

    
}