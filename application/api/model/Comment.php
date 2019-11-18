<?php
namespace app\api\model;

use think\Db;
use think\Model;

class Comment extends Model
{
    public static function add($data){

        $result=Db::table('comment')->insertGetId($data);
        if($result){
            return $result;
        }else{
            return false;
        }

    }

    public static function getCom($page){      
        $data=Db::table('comment')->where('pid',0)->whereor('pid',null)->order('date desc')->page($page,'10')->select();
        return $data;
    }

    public static function getReply($id){
        $data = Db::table('comment')->where('to_id',$id)->select(); 
        return $data;
    }

    //获取回复人的名称
    public static function getUserName($id){
        $name = Db::table('comment')->where('id',$id)->value('user_name');
        return $name;
    }

    public static function FadNo($data){
        $user_id=$data['user_id'];
        $id = $data['id'];
        $res = DB::table('fabulous')->where('user_id',$user_id)->where('com_id',$id)->select();
        if($res){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $id评论人id
     * $user_id点赞人id
     * 点赞数增加
     */
    public static function addFabNo($data){
//        $data=Db::table('COMMENT')->where('USER_ID',$id)->find();
////        var_dump($data);exit;
       
        $id=$data['com_id'];
        // $user_id=$data['user_id'];
        // $user = DB::table('comment')->where('id',$id)->find();
        // $user_id=$user['user_id'];
        
        $result = Db::table('fabulous')->insert($data);
        // $mn=Db::table('comment')->where('id',$id)->find();
        // $num=$mn['num'];
        // $num=$num+1;
        // Db::table('comment')->where('id',$id)->update(['num'=>$num]);
            Db::table('comment')->where('id',$id)->setInc('num',1);//NUM 每次增加1
            if($result>0){
                return true;
            }else{
                return false;
            }
    }

    public static function delFabNo($data){
        $id = $data['com_id'];
        $user_id = $data['user_id'];

        $result = Db::table('fabulous')->where('com_id',$id)->where('user_id',$user_id)->delete();

        Db::table('comment')->where('id',$id)->setDec('num',1);//NUM 每次减少1
            if($result>0){
                return true;
            }else{
                return false;
            }

    }
}