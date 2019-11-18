<?php
/**
 * Created by PhpStorm.
 * User: LDH
 * Date: 2019-11-08
 * Time: 15:11
 */

namespace app\api\controller;

header('Access-Control-Allow-Origin:*'); 
// header('Access-Control-Allow-Methods:POST'); 
// header('Access-Control-Allow-Headers:x-requested-with,content-type'); 

// header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");

use think\Controller;
use app\api\model\Comment as CommentModel;
use think\Request;
use think\Session;


class Comment extends Controller
{
    public $msgData = array();
    protected $appid = 'wxd4339a8e895f69b5';
    protected $appsecret = '868eb2a1ccc2038026ec02d79dea5187';

    public function __construct(Request $request = null)
    {
        $this->msgData = [
            'code'=>1,
            'msg'=>'',
            'data'=>''
        ];
        
        parent::__construct($request);
        // header('Access-Control-Allow-Origin:*'); 

    }


    /**
     * 获取评论列表
     * @return \think\response\Json
     */
    public function getComment()
    {
        $user_id=input('openid');
        $page=input('page');
        $arr['user_id']=$user_id;
        // $rep = $this->getRep(77);
        // var_dump($rep); exit;
        $list = CommentModel::getCom($page);
        // var_dump($list);exit;
        foreach ($list as $key => &$value){
            // $value['DATE'] = date('Y-m-d H:i:s');
            $to_id=$value['to_id'];
            $id=$value['id'];
            
            $arr['id']= $id;
            $res= CommentModel::FadNo($arr);
            if($res){
                //存在点赞
                $value['fab'] = '0';
            }else{
                //没有点过赞
                $value['fab'] = '1';
            }
            
                $rep = $this->getRep($id);         
                $value['reply'] = $rep;
            if(!$to_id==null){

            }
            
            
        }
        
        $data['list'] = $list;
        $data['total'] = count($list);
        
        $this->msgData['msg'] = '';
        $this->msgData['data'] = $data;
        return json($this->msgData);
    }

    public function getRep($id){
        $list = CommentModel::getReply($id);
    
        $data['list'] = $list;
        $data['total'] = count($list);
        return $data;
    }

    public function getUser($id){
        $touser = CommentModel::getUserName($id);
        return $touser;
        
    }


    /**
     * 新增评论
     * @return \think\response\Json
     */
    public function addComment(){

        $comment = input('comment');
        $user_image = input('headimgurl');
        $user_id = input('openid');
        $user_name = input('nickname');
        $pid= input('pid');
        $to_id = input('to_id');
        $code = input('code');
        if(empty($comment)){
            $this->msgData = ['code'=>10001, 'msg'=>'评论内容不能为空',];
            return json($this->msgData);
        };

        $data['comment']=$comment;
        $data['date'] = date('Y-m-d H:i:s');//时间设置为时间戳
 
        $data['user_id']=$user_id;
        $data['user_name']=$user_name;
        $data['user_img']=$user_image;
        $data['pid'] = $pid;
        $data['to_id'] = $to_id;
        $data['code'] = $code;
        if($code=='1'){
            $user = $this->getUser($to_id);
            $data['touser'] = $user;
        }
        $result=CommentModel::add($data);
        if(!$result){
            $this->msgData = ['code'=>10002, 'msg'=>'评论失败',];
            return json($this->msgData);
        }else{
            $this->msgData['id'] = $result;
        }
        $this->msgData['msg'] = '评论成功';
        return json($this->msgData);

    }
    /**
     * 点赞
     */
    //id 评论id
    public function addFab(){
        $id = input('id');
        $user_id = input('openid');
        $data['com_id']=$id;
        $data['user_id']=$user_id;
        $result=CommentModel::addFabNo($data);
        if($result){
            $this->msgData = ['code'=>10001, 'msg'=>'点赞成功',];
            return json($this->msgData);
            // return true;
        }else{
            $this->msgData = ['code'=>10002, 'msg'=>'点赞失败',];
            return json($this->msgData);
        }
    }

    /**
     * 取消点赞
     */
    public function delFab(){
        $id = input('id');

        $user_id = input('openid');
        $data['com_id']=$id;
        $data['user_id']=$user_id;
        $result=CommentModel::delFabNo($data);
        if($result){
            $this->msgData = ['code'=>10001, 'msg'=>'取消点赞成功',];
            return json($this->msgData);
            // return true;
        }else{
            $this->msgData = ['code'=>10002, 'msg'=>'取消点赞失败',];
            return json($this->msgData);
        }
    }

    public function delComment(){

    }


    // 获取用户openid
    public function  getBaseInfo(){
        //获取code
        $redirect_url = urlencode("https://www.chaochuanbo.com/tp5/getUserOpenId");
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".$redirect_url."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
        header('location:'.$url);
    }

    public function getUserOpenId(){
        $code= $_GET['code'];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid."&secret=".$this->appsecret."&code=".$code."&grant_type=authorization_code";
        $res = $this->http_curl($url,'get');
    }


    //获取用户详细信息
    public function  getBaseDetail(){
        // header('Access-Control-Allow-Origin:*'); 
        //获取code
        // return "123";
        $redirect_url = urlencode("https://www.chaochuanbo.com/tp5/getUserInfo");
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".$redirect_url."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header('location:'.$url);
    }


    public function getUserInfo(){
        session_start();
       
        if(session('openid')){
            // $access_token = $_SESSION['access_token'];
            // $openId = $_SESSION['openid'];
            $access_token = session('access_token');
            $openId = session('openid');
        }else{
            $code= $_GET['code'];
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid."&secret=".$this->appsecret."&code=".$code."&grant_type=authorization_code";
            $res = $this->http_curl($url,'get');
            
            // $_SESSION['openid'] = $res['openid'];
            // $_SESSION['access_token'] = $res['access_token'];
            $access_token = $res['access_token'];
            $openId = $res['openid'];
            session('openid',$openId);
            session('access_token',$access_token);
        }
        
        
        $urlInfo = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openId.'&lang=zh_CN';
        $result = $this->http_curl($urlInfo);
        
        return json($result);
        
    }

  
    


    public function http_curl($url,$type='get',$res='json',$arr=''){
        //1，初始化curl
        $ch = curl_init();
        //2,设置 curl的参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($type == 'post') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        }
        //3，采集
        $output = curl_exec($ch); 
        if ( curl_errno($ch) ) {
            print curl_error($ch);
        }
        curl_close($ch); //关闭curl链接    
        if($res == 'json'){
            return json_decode($output,true);
        }else{
            return $output;
        }
    }

    public function getInfo(){
        // 微信 JS 接口签名校验工具: https://mp.weixin.qq.com/debug/cgi-bin/sandbox?t=jsapisign
        // $appid = '---------';
        // $appsecret = '-------------------';
        // 获取token
        // $token_data = file_get_contents(__DIR__.'/token.txt');
        
        
        // $time = 7200;
        // if (!empty($token_data)) {
        //     $token_data = json_decode($token_data, true);
        //     $time  = time() - $token_data['time'];
        //     // $time  = time() - session('time');
        // }
        // // $token = $token_data['token'];
        // if ($time > 3600) {
            $token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";
            $token_res = $this->https_request($token_url);
            $token_res = json_decode($token_res, true);
            $token = $token_res['access_token'];
            // $data = array(
            //     'time' =>time(),
            //     'token' =>$token
            // );
            // $time=time();
            // session('token', $token);
            // session('time', $time);

            
            // file_put_contents(__DIR__.'/token.txt', json_encode($data));
            // if ($res) {
            //     echo '更新 token 成功';
            // }
        // }else{
        //     $token = $token_data['token'];
        // }
        
        // // 获取ticket
        // $ticket_data = file_get_contents(__DIR__.'/ticket.txt');
        // $time1 = 7200;
        // if (!empty($ticket_data)) {
        //     $ticket_data = json_decode($ticket_data, true);
        //     $time1  = time() - $ticket_data['time'];
        //     // $time1  = time() - session('time1');
        // }
        
        // if ($time1 > 3600) {
            $ticket_url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$token}&type=jsapi";
            $ticket_res = $this->https_request($ticket_url);
            $ticket_res = json_decode($ticket_res, true);
            $ticket = $ticket_res['ticket'];
            // $data = array(
            //     'time'    =>time(),
            //     'ticket'  =>$ticket
            // );
            // $time1=time();
            // session('ticket', $ticket);
            // session('time', $time1);
            // file_put_contents(__DIR__.'/ticket.txt', json_encode($data));
            // if ($res) {
            //     echo '更新 ticket 成功';
            // }
        // }else{
        //     $ticket = $ticket_data['ticket'];
        // }
        // 进行sha1签名
        $timestamp = time();
        $nonceStr = $this->createNonceStr();
        // 注意 URL 建议动态获取(也可以写死).
        $url = input('url');//获取前端传过来的页面地址
        // $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        // $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; // 调用JSSDK的页面地址
        //$url = $_SERVER['HTTP_REFERER']; // 前后端分离的, 获取请求地址(此值不准确时可以通过其他方式解决)
        $str = "jsapi_ticket={$ticket}&noncestr={$nonceStr}&timestamp={$timestamp}&url={$url}";
        $sha_str = sha1($str);
        $signPackage = array(
            "appId" =>  $this->appid,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "signature" => $sha_str,
        );
        return json($signPackage);
    }
    //随机字符串
    public function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    // 模拟 http 请求
    public function https_request($url, $data = null){
        // curl 初始化
        $curl = curl_init();
        // curl 设置
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        // 判断 $data get  or post
        if ( !empty($data) ) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // 执行
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

    



}