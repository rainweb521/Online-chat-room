<?php
/**
 * Created by PhpStorm.
 * User: Rain
 * Date: 2017/8/12
 * Time: 18:45
 */
namespace Home\Controller;
use Think\Controller;

class LoginController extends Controller{
    public function index(){

        $this->display();
    }

    public function login(){
        $username = request('post','str','username','admin');
        $user['name'] = $username;
        $num = rand(1,24);
        $user['photo'] = 'http://cos.rain1024.com/blog/more/chat_photo/'.$num.'.jpg';
        $user['time'] = date("U");
        $user['o_id'] = D('Online')->add_OnlineInfo($user);
        session('User',$user);
        $this->redirect('/index.php?c=index');
    }

    /**
     * 登出操作
     */
    public function logout() {
//        Session::set();
        $user = $_SESSION['User'];
        $o_id = $user['o_id'];
        D('Online')->set_OnlineState($o_id);
        session('User', null);
        $this->redirect('/index.php?c=index');
        exit();
//        $this->get_session();
    }
}