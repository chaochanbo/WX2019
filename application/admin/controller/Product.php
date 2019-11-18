<?php
namespace app\Admin\Controller;
use \think\Controller;
use app\admin\Model\Product as ProductModel;
use \think\Request;


class Product extends Controller
{
    public function product()
    {
    //    return view('login');
        $pro=new ProductModel();
        $data=$pro->select();
        
        
        $this->assign('re',$data);
       return $this->fetch();
   }

   public function add(){
    $pro=new ProductModel();
       if($_POST){
           $resu=input('post.');
        //    var_dump($resu);
        //    die;
        $pic=$resu['imgs'];
        
           $mm['code']=$resu['code'];
           $mm['name']=$resu['name'];
           $mm['pid']=$resu['pid'];

           $mm['price']=$resu['price'];
           $mm['desc']=$resu['desc'];
           $mm['model']=$resu['model'];
           $mm['num']=$resu['num'];
           if(array_key_exists('editorValue',$resu)){
            $mm['content']=$resu['editorValue'];
           }
           $id=$resu['pid'];
           
           $name=$pro->getname($id);
        //    $name=db('category')->where('id',$resu['pid'])->field('name')->find();

           $mm['classification']=$name['name'];
          
           $mm['pic']=$pic[0];
           $stu=$pro->insert($mm);
           foreach($pic as $value){
                $ss=['code'=>$resu['code'],'route'=>$value];
                db('picture')->insert($ss);
            }
            if($stu){
                $this->success('添加产品成功！',url('product'));
            }else{
                $this->error('添加失败！');
            }
            
            
       }else{
        //    $data=$pro->getlist();
            $data=db('category')->field("*,concat(path,',',id) as paths")->order('path')->select();
            // var_dump($data);
            foreach($data as $k=>$v){
                $data[$k]['name']=str_repeat('|---',$v['level']).$v['name'];
            }
            // var_dump($data);
            $this->assign('re',$data);
    
        return $this->fetch();
       }
        
   }

   public function padd(){

   }

   public function category(){
       return $this->fetch();
   }

   public function upload(){
       $file=request()->file('img');
       if($file){
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
          // 成功上传后 获取上传信息ROOT_PATH
        //   $img_src = './uploads/'.$info->getSaveName();获取上传信息
          $img_src = '//'.$_SERVER['HTTP_HOST'].'/tp5/public/uploads/'.$info->getSaveName();
        //   $img_src = ROOT_PATH.'/public/uploads/'.$info->getSaveName();
          echo $img_src; //返回ajax请求
        }else{
          // 上传失败获取错误信息
          $this->error($file->getError());
        }
      }

   }
   public function lower(){
       $id=$_GET['id'];
       
       $cou=db('product')->where('code',$id)->update(['state'=>'0']);
       if($cou){
        echo '0';
       }
       
   }

   public function upper(){
    $id=$_GET['id'];
    
    $cou=db('product')->where('code',$id)->update(['state'=>'1']);
    if($cou){
        echo '1';
       }
}
    public function del()
    {
        $id=$_POST['id'];

        $res=db('product')->where('code',$id)->delete();
        if($res){
            db('picture')->where('code',$id)->delete();
            echo '1';
        }
    }

    public function edit()
    {

        $id = input('id');
        $res=db('product')->where('code',$id)->select();
        // if($res){
        //     $name=$res['name'];
        //     $this->assign('codename',$name);
        // }
        $data=db('category')->field("*,concat(path,',',id) as paths")->order('path')->select();
            // var_dump($data);
            foreach($data as $k=>$v){
                $data[$k]['name']=str_repeat('|---',$v['level']).$v['name'];
            }
        $ss=db('picture')->where('code',$id)->select();
            // var_dump($res);
            // die;
            // $name=$res[0]['name'];
            $this->assign('pic',$ss);
            $this->assign('product',$res);
            $this->assign('re',$data);
        return $this->fetch('edit');
    }

    public function update(){
        if($_POST){
            $res=input('post.');
            
            $pic=$res['imgs'];
        
            $mm['code']=$res['code'];
            $mm['name']=$res['name'];
            $mm['pid']=$res['pid'];
 
            $mm['price']=$res['price'];
            $mm['desc']=$res['desc'];
            $mm['model']=$res['model'];
            $mm['num']=$res['num'];
            if(array_key_exists('editorValue',$res)){
             $mm['content']=$res['editorValue'];
            }
            $name=db('category')->where('id',$res['pid'])->field('name')->find();

           $mm['classification']=$name['name'];
          
           $mm['pic']=$pic[0];
           $stu=db('product')->where('code',$res['code'])->update($mm);
           db('picture')->where('code',$res['code'])->delete();
           foreach($pic as $value){
            $ss=['code'=>$res['code'],'route'=>$value];
            db('picture')->insert($ss);
            }
            if($stu){
                $this->success('更新产品成功！',url('product'));
            }else{
                $this->error('更新失败！');
            }
        }
    }

}
