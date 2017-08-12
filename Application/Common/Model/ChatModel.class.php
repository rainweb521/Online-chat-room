<?php
/**
 * Created by PhpStorm.
 * User: Rain
 * Date: 2017/8/12
 * Time: 17:52
 */
namespace Common\Model;
use Think\Model;
class ChatModel extends Model{
    private $_db = '';

    public function __construct() {
        $this->_db = M('chat');
    }
    public function get_ChatList($where=NULL){
        $data = $this->_db->where($where)->select();
        return $data;
    }
    public function add_ChatInfo($data){
        $this->_db->add($data);
    }

    public function get_ChatNum(){
        $data = $this->get_ChatList();
        return sizeof($data);
    }

    public function get_Chat_Num_List($num){
        $end = $this->_db->count();
        $data = $this->_db->limit($end-$num,$end)->select();
        return $data;

    }
}