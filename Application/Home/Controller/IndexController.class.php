<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    protected $over_time = 300;
    public function index(){

//       print_r($_SESSION);
//        exit();
        $time = date('U') - $this->over_time;
        $online_list = D('Online')->get_OnlineList(array('o_state=1 AND o_addtime>'.$time));
        $chat_list = D('Chat')->get_Chat_Num_List(10);
        $flag = D('Chat')->get_ChatNum();
        $user = $_SESSION['User'];
        $this->assign('online_list',$online_list);
        $this->assign('chat_list',$chat_list);
        $this->assign('flag',$flag);
        $this->assign('user',$user);

//        var_dump($chat_list);
//        exit();
        $this->display();
//        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    public function add_ajax(){
        $data['c_text'] = request('get','str','c_text','');
        $user = $_SESSION['User'];
        $data['c_name'] = $user['name'];
        $data['c_photo'] = $user['photo'];
        $data['c_addtime'] = date("h:i:sa");
        D('Chat')->add_ChatInfo($data);
        D('Online')->set_OnlineTime($user['o_id']);
    }

    public function get_ajax(){
        $c_id = request('get','int','c_id',0);
        $chat_list = D('Chat')->get_ChatList("c_id>".$c_id);
        if ($chat_list!=NULL){
            echo json_encode($chat_list);
        }
    }
    public function get_onlineuser(){
        $time = date('U') - $this->over_time;
        $online_list = D('Online')->get_OnlineList(array('o_state=1 AND o_addtime>'.$time));
        if ($online_list!=NULL){
            echo json_encode($online_list);
        }
    }
    public function clear_online(){
        $time = date('U') - 600;
        D('Online')->Clear_Online($time);
        echo "<h1>已经清除时长不在线好友</h1>";
    }

//    public function set_session(){
//        $user['name'] = 'rain';
//        $user['photo'] = '';
//        session('User',$user);
//        $this->redirect('/index.php?c=index');
//    }
}