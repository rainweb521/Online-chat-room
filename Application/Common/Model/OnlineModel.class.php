<?php
/**
 * Created by PhpStorm.
 * User: Rain
 * Date: 2017/8/12
 * Time: 17:52
 */
namespace Common\Model;
use Think\Model;
class OnlineModel extends Model{
    private $_db = '';

    public function __construct() {
        $this->_db = M('online');
    }
    public function get_OnlineList($where=NULL){
        $data = $this->_db->where($where)->select();
        return $data;
    }
    public function add_OnlineInfo($user){
        $data = array();
        $data['o_name'] = $user['name'];
        $data['o_photo'] = $user['photo'];
        $data['o_addtime'] = $user['time'];
        $data['o_state'] = 1;
        return $this->_db->add($data);
    }
    public function get_OnlineInfo($o_id){
        $where['o_id'] = $o_id;
        return $this->_db->where($where)->find();
    }
    public function get_OnlineNum(){
        $data = $this->get_OnlineList();
        return sizeof($data);
    }

    public function get_Online_Num_List($num){
        $end = $this->_db->count();
        $data = $this->_db->limit($end-$num,$end)->select();
        return $data;

    }
    public function set_OnlineTime($o_id){
        $data = $this->get_OnlineInfo($o_id);
        $data['o_addtime'] = date("U");
        $this->_db->save($data);
    }
    public function set_OnlineState($o_id){
        $data = $this->get_OnlineInfo($o_id);
        $data['o_state'] = 0;
        $this->_db->save($data);
    }

    public function Clear_Online($time){
        $online_list = $this->get_OnlineList();
        foreach ($online_list as $online){
            if($online['o_state']==1&&$online['o_addtime']<$time){
                $this->set_OnlineState($online['o_id']);
            }
        }

    }
}