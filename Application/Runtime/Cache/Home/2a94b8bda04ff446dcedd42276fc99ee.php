<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>聊天室 - editor:yinq</title>
<link rel="shortcut icon" href="/Public/favicon.png">
<link rel="icon" href="/Public/favicon.png" type="image/x-icon">
<link type="text/css" rel="stylesheet" href="/Public/css/style.css">
<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
</head>

<body>
<div class="chatbox">
  <div class="chat_top fn-clear">
    <div class="logo"><img src="/Public/images/logo.png" width="190" height="60"  alt=""/></div>
    <div class="uinfo fn-clear">
      <div class="uface"><img src="<?php echo ($user["photo"]); ?>" width="40" height="40"  alt=""/></div>
      <div class="uname">
        <?php echo ($user["name"]); ?><i class="fontico down"></i>
        <ul class="managerbox">
          <!--<li><a href="#"><i class="fontico lock"></i>修改密码</a></li>-->
          <li><a href="/index.php?c=login&a=logout" onclick=""><i class="fontico logout"></i>退出登录</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="chat_message fn-clear">
    <div class="chat_left">
      <div class="message_box" id="message_box">
        <!--<div class="msg_item fn-clear">-->
          <!--<div class="uface"><img src="/Public/images/53f44283a4347.jpg" width="40" height="40"  alt=""/></div>-->
          <!--<div class="item_right">-->
            <!--<div class="msg">近日，TIOBE发布了2014年9月的编程语言排行榜，Java、C++跌至历史最低点，前三名则没有变化，依旧是C、Java、Objective-C。</div>-->
            <!--<div class="name_time">猫猫 · 3分钟前</div>-->
          <!--</div>-->
        <!--</div>-->
        
        <!--<div class="msg_item fn-clear">-->
          <!--<div class="uface"><img src="/Public/images/53f442834079a.jpg" width="40" height="40"  alt=""/></div>-->
          <!--<div class="item_right">-->
            <!--<div class="msg own">(Visual) FoxPro, 4th Dimension/4D, Alice, APL, Arc, Automator, Awk, Bash, bc, Bourne shell, C++CLI, CFML, cg, CL (OS/400), Clean, Clojure, Emacs Lisp, Factor, Forth, Hack, Icon, Inform, Io, Ioke, J, JScript.NET, LabVIEW, LiveCode, M4, Magic, Max/MSP, Modula-2, Moto, NATURAL, OCaml, OpenCL, Oz, PILOT, Programming Without Coding Technology, Prolog, Pure Data, Q, RPG (OS/400), S, Smalltalk, SPARK, Standard ML, TOM, VBScript, Z shell</div>-->
            <!--<div class="name_time">白猫 · 1分钟前</div>-->
          <!--</div>-->
        <!--</div>-->
        <?php if(is_array($chat_list)): $i = 0; $__LIST__ = $chat_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><div class="msg_item fn-clear">
            <div class="uface"><img src="<?php echo ($list["c_photo"]); ?>" width="40" height="40"  alt=""/></div>
            <div class="item_right">
              <div class="msg own"><?php echo ($list["c_text"]); ?></div>
              <div class="name_time"><?php echo ($list["c_name"]); ?> · <?php echo ($list["c_addtime"]); ?></div>
            </div>
          </div><?php endforeach; endif; else: echo "" ;endif; ?>
      </div>
      <div class="write_box">
        <textarea id="message" name="message" class="write_area" placeholder="说点啥吧..."></textarea>
        <input type="hidden" name="fromname" id="fromname" value="河图" />
        <input type="hidden" name="to_uid" id="to_uid" value="0">
        <div class="facebox fn-clear">
          <div class="expression"></div>
          <div class="chat_type" id="chat_type">群聊</div>
          <button name="" class="sub_but">提 交</button>
        </div>
      </div>
    </div>
    <!--<button onclick="get_OnlineUser()">online</button>-->
    <div class="online_userlist" id="online_userlist">
      <ul class="user_list"  title="点击可刷新用户列表">
        <li class="fn-clear selected" onclick="get_OnlineUser()"><em>所有用户(点击刷新)</em></li>

        <?php if(is_array($online_list)): $i = 0; $__LIST__ = $online_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li class="fn-clear" data-id="1"><span><img src="<?php echo ($list["o_photo"]); ?>" width="30" height="30"  alt=""/></span><em><?php echo ($list["o_name"]); ?></em><small class="online" title="在线"></small></li><?php endforeach; endif; else: echo "" ;endif; ?>
        <!--<li class="fn-clear" data-id="2"><span><img src="/Public/images/53f44283a4347.jpg" width="30" height="30"  alt=""/></span><em>猫猫</em><small class="online" title="在线"></small></li>-->
        <!--<li class="fn-clear" data-id="3"><span><img src="/Public/images/53f442834079a.jpg" width="30" height="30"  alt=""/></span><em>白猫</em><small class="offline" title="离线"></small></li>-->
      </ul>

    </div>
  </div>
</div>


<input type="hidden" name="0" value="<?php echo ($flag); ?>" id="flag">


<script type="text/javascript">
    setInterval("get_chatlist()",3000);
    setInterval("get_OnlineUser()",180000);
//    function sendMessage2(event){
//            var e = window.event || event;
//            var k = e.keyCode || e.which || e.charCode;
//            //按下ctrl+enter发送消息
//                sendMessage(event, fromname, to_uid, to_uname);
//    }

$(document).ready(function(e) {
	$('#message_box').scrollTop($("#message_box")[0].scrollHeight + 20);
	$('.uname').hover(
	    function(){
		    $('.managerbox').stop(true, true).slideDown(100);
	    },
		function(){
		    $('.managerbox').stop(true, true).slideUp(100);
		}
	);
	
	var fromname = $('#fromname').val();
	var to_uid   = 0; // 默认为0,表示发送给所有用户
	var to_uname = '';
	$('.user_list > li').dblclick(function(){
		to_uname = $(this).find('em').text();
		to_uid   = $(this).attr('data-id');
		if(to_uname == fromname){
		    alert('您不能和自己聊天!');
			return false;
		}
		if(to_uname == '所有用户'){
		    $("#toname").val('');
			$('#chat_type').text('群聊');
		}else{
		    $("#toname").val(to_uid);
			$('#chat_type').text('您正和 ' + to_uname + ' 聊天');
		}
		$(this).addClass('selected').siblings().removeClass('selected');
	    $('#message').focus().attr("placeholder", "您对"+to_uname+"说：");
	});
	
	$('.sub_but').click(function(event){
	    sendMessage(event, fromname, to_uid, to_uname);
	});
	
	/*按下按钮或键盘按键*/
	$("#message").keydown(function(event){
		var e = window.event || event;
        var k = e.keyCode || e.which || e.charCode;
		//按下ctrl+enter发送消息
		if((event.ctrlKey && (k == 13 || k == 10) )){
			sendMessage(event, fromname, to_uid, to_uname);
		}
	});
});
function add_chatinfo(){
    var msg = $("#message").val();
    if(msg!=''){
        $.get("/index.php?c=index&a=add_ajax&c_text=" + msg);
        document.getElementById('message').value = '';
    }
//    $("#message").val('');
}
function get_chatlist(){

    var c_id = document.getElementById('flag').value;
    $.get("/index.php?c=index&a=get_ajax&c_id="+c_id, function(data){
        var res = eval("(" + data + ")");//转为Object对象
        var htmlData = "";
        for (var i=0;i<res.length;i++){
            htmlData = htmlData + '<div class="msg_item fn-clear">'
                + '   <div class="uface"><img src='+ res[i].c_photo +' width="40" height="40"  alt=""/></div>'
                + '   <div class="item_right">'
                + '     <div class="msg own">' + res[i].c_text + '</div>'
                + '     <div class="name_time">' + res[i].c_name + ' · ' +res[i].c_addtime +'</div>'
                + '   </div>'
                + '</div>';
            document.getElementById('flag').value = res[i].c_id;
        }
        $("#message_box").append(htmlData);
        $('#message_box').scrollTop($("#message_box")[0].scrollHeight + 20);

    });
}
function sendMessage(event, from_name, to_uid, to_uname){
    add_chatinfo();
//    get_chatlist();

}
function logout(){
    $.get("/index.php?c=index&a=add_ajax&c_text=" + msg);
}
function get_OnlineUser(){
    htmlData = '<ul class="user_list"  title="点击可刷新用户列表"><li class="fn-clear selected" onclick="get_OnlineUser()"><em>所有用户(点击刷新)</em></li>';
    document.getElementById('online_userlist').innerHTML = htmlData + '</ul>';
    $.get("/index.php?c=index&a=get_onlineuser", function(data){
        var res = eval("(" + data + ")");//转为Object对象
//        htmlData = '<ul class="user_list"  title="点击可刷新用户列表"><li class="fn-clear selected" onclick="get_OnlineUser()"><em>所有用户(点击刷新)</em></li>';
        for (var i=0;i<res.length;i++){
            htmlData = htmlData + '<li class="fn-clear" data-id="1"><span>'
                + '   <img src='+ res[i].o_photo +' width="30" height="30"  alt=""/></span><em>'+res[i].o_name
                + '   </em><small class="online" title="在线"></small></li>';
        }
        htmlData = htmlData + '</ul>';
        document.getElementById('online_userlist').innerHTML = htmlData;
    });
}

//    window.onbeforeunload = function(){
//        $.get("/index.php?c=login&a=logout");
//    }
</script>
</body>
</html>