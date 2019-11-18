<?php
namespace app\Admin\Controller;
// use \think\Controller;
use app\admin\controller\Common;




class Index extends Common
{
    public function index()
    {
    //    return view('login');
       return $this->fetch('index');
   }

   public function adminrole(){
    return $this->fetch('adminrole');
   }

   public function adminroleadd()
   {
    return $this->fetch('adminroleadd');
   }
   
   public function adminlist()
   {
    $re=db('admin')->paginate(10);
    $this->assign('re',$re);
    return $this->fetch('adminlist');
   }
   
   public function adminadd()
   {
    if(request()->isPost()){
        $data=input('post.');
        
        $res=db('admin')->insert($data);
        if($res){
            $this->success('添加管理员成功',url('adminadd'));
        }
        $this->error('添加管理员失败！');
        return;
    }
       return $this->fetch('adminadd');
   }

   public function adminedit($id)
   {
       if(request()->isPost()){
            $data1=input('post.');
            $res1=db('admin')->where(array('id'=>$id))->update($data1);
            if($res1){
                $this->success('修改管理员成功',url('adminlist'));
            }
            return;
       }
       $result=db('admin')->find($id);
       $this->assign('stu',$result);
    return $this->fetch('adminedit');
   }

   public function admindel($id)
   {
        
            
            $res1=db('admin')->where(array('id'=>$id))->delete();
            if($res1){
                $this->success('删除管理员成功',url('adminlist'));
            }
            
        
   }

   public function articlelist(){
       return $this->fetch('articlelist');
   }

   public function welcome(){
       return $this->fetch('welcome');
   }

   public function logout(){
        session(null);
       $this->success('退出登陆成功！',url('login/index'));
   }

}
