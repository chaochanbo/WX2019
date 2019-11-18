<?php
namespace app\Admin\Controller;
use \think\Controller;


class Common extends Controller
{
    public function _initialize()
    {
        if(!session('id') || !session('name')){
            $this->error('请先登陆！',url('login/index'));
        }
   }

}
