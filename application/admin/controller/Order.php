<?php
namespace app\Admin\Controller;
use \think\Controller;


class Order extends Controller
{
    public function order()
    {
        
       return $this->fetch();
   }

   public function orderlist(){
    return $this->fetch();
   }

}               