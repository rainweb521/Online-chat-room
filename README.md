﻿## 简介

## Rain在线聊天室是我很久之前就想做的一个东西，在QQ或者一些其他平台上，有些东西是不能乱说的，因为有关键词的筛查，而其他的聊天软件使用起来比较麻烦，所以我想写一个在线的即时聊天室，打开就可以说话，整个功能就搭建在我的服务器上，不怕什么筛查，更不会有社区送温暖，开门有快递，你的水表坏了，你有外卖等情况发生。

## 整个功能并不复杂，只是在消息的传送和刷新上有些麻烦，必须保证聊天记录的准确和同步性，调试了很多bug，还有就是用户列表的显示，用户状态的判断，这一块非常麻烦，我一直在思考一种高效实时的检测方式，现在只是一个简单请求方式，我会继续慢慢完善。截图和开发日志放在下面。

# 聊天室我已经放到服务器里，有想要尝试的可以直接访问[chat.rain1024.com](chat.rain1024.com)

## 开发日志

#### 更新了在线用户列表显示功能，可以实时的更新在线的用户，超时不说话的，会被认为已经离线，如果继续超过一定时间，则系统将会终结账号，还可以手动点击来刷新在线用户的列表。修复了在发送消息的时候，有时会重复出现两次，但数据库中只出现了一次记录的bug，因为在发送消息的时候会请求系统的聊天记录，而此时正好和页面自动请求发生了重合，导致信息被请求了多次

#### 更新说明：添加了数据库，支持聊天记录的保存，用户每次进入聊天室都需要登录，输入用户名即可，系统会自动分配一个头像。使用limint，和count，在每次进入系统，都会自动显示上一次的前十条聊天记录，聊天时每提交发言，都会请求一遍系统中的聊天记录，使用轮播技术，系统会每隔一段时间自动请求聊天记录

#### 项目开始开发，基础的thinkphp框架

## 聊天室截图



![](http://cos.rain1024.com/blog/php/php24.jpg)

![](http://cos.rain1024.com/blog/php/php25.jpg)