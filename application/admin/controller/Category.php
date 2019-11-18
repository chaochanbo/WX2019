<?php
namespace app\Admin\Controller;
use \think\Controller;
use app\admin\Model\Category as cate;


class Category extends Controller
{
   public function category(){
       return $this->fetch();
   }

   public function add(){
    //    $cate=new cate();
    //    $data=$cate->category();
    
       $data=db('category')->field("*,concat(path,',',id) as paths")->order('path')->select();
        // var_dump($data);
        foreach($data as $k=>$v){
            $data[$k]['name']=str_repeat('|---',$v['level']).$v['name'];
        }
        // var_dump($data);
       $this->assign('re',$data);
       return $this->fetch();
   }

   public function index(){
       $res['name']=$_POST['name'];
       $res['pid']=$_POST['pid'];
       if($res['name'] !="" && $res['pid'] !=0){
            $path=db('category')->field("path")->find($res['pid']);
            $res['path']=$path['path'];
            $res['level']=substr_count($res['path'],',');
            $count=db('category')->insertGetId($res);
    
            $path['id']=$count;
            $path['path']=$res['path'].','.$count;
            $path['level']=substr_count($path['path'],",");
            $data=db('category')->update($path);
            if($data){
                echo '<script>alert("添加成功！");parent.location.href="category"</script>';
            }else{
                echo '<script>alert("添加失败！");parent.location.href="category"</script>';
            }
       }else if($res['name'] !="" && $res['pid'] ==0){
            
            $res['path']=$res['pid'];
            $res['level']=1;
            $count=db('category')->insertGetId($res);
    
            $path['id']=$count;
            $path['path']=$res['path'].','.$count;
            
            $data=db('category')->update($path);
            if($data){
                echo '<script>alert("添加成功！");parent.location.href="category"</script>';
            }else{
                echo '<script>alert("添加失败！");parent.location.href="category"</script>';
            }
       }else{
            echo '<script>alert("添加失败！");parent.location.href="category"</script>';
       }
      
   }
//获取分类数据
    public function get(){
        $data=db('category')->field('id,pid,name')->select();
        echo json_encode($data);
    }
//删除分类信息
    public function del(){
        $id=$_GET['id'];
        $cou=db('category')->where('pid',$id)->find();
        if($cou){
            $str="分类下面还有子类，不能删除！";
            echo json_encode($str);
        }else{
            $re=db('category')->where('id',$id)->delete();
            if($re){
                echo 1;
            }
        }
        
    }


}
