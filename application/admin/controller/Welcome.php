<?php
namespace app\Admin\Controller;
use \think\Controller;


class Welcome extends Controller
{
    public function index()
    {
    //    return view('login');
       return $this->fetch('welcome');
   }

}
