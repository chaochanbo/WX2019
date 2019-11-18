<?php
namespace app\admin\model;
use think\Model;
class Admin extends Model
{
    public function login($data){
        $admin=Admin::getByname($data['name']);
        if($admin){
            if($admin['password']==$data['password']){
                session('name', $admin['name']);
                session('id', $admin['id']);
                return 2;
            }else{
                return 3;
            }
        }else{
            return 1;
        }
    }
}