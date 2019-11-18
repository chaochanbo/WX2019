<?php
namespace app\Admin\Controller;
use \think\Controller;


class Picture extends Controller
{
    public function picturelist()
    {
    //    return view('login');
        
       return $this->fetch();
   }

}
