<?php
namespace app\Admin\Controller;
use \think\Controller;
use app\admin\Model\Admin;
use think\captcha\Captcha;

class Login extends Controller
{
    public function index()
    {
        if(request()->isPOST()){
            $data=input('post.');          
            // $code = $data['code'];
            // $this->check($data['code']);
           
            $admin=new Admin();
            $num=$admin->login(input('post.'));
            if($num==1){
                $this->error('用户名不存在！');
            }else if($num==2){
                $this->success('登陆成功！',url('index/index'));
            }else{
                $this->error('密码错误！');
            }
        }
    //    return view('login');
       return $this->fetch('login');
   }



   
   // 验证码检测
    public function check($code='')
    {
        
        if (!captcha_check($code)) {
            
            $this->error('验证码错误');
        } else {
            $this->success('验证码正确');
        }
    }

   
}
