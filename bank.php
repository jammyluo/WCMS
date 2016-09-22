<?php
// PHP version of merchant_result.jsp
//这是B2CAPI通用版的php客户端调用测试 用于支付成功之后 将状态设置为成功
//作    者：bocomm
//创建时间：2013-12-12
session_start ();
@header ( "Content-type: text/html; charset=utf-8" );

//关闭错误提示 0关闭  1开启
ini_set ( 'display_errors', 1 );

error_reporting ( E_ALL ^ E_NOTICE ^ E_STRICT ); //php5.4报错 E_STRICT


//配置时区
date_default_timezone_set ( 'Asia/Shanghai' );
define ( 'ROOT', realpath ( dirname ( __FILE__ ) ) . DIRECTORY_SEPARATOR );
define ( 'APP', './app/' );
//配置加载路径
set_include_path ( implode ( PATH_SEPARATOR, array (realpath ( './lib' ), realpath ( './config' ), realpath ( './lang' ), get_include_path () ) ) );

//是否捕获fatal error:non-object错误
define ( 'NONOBJECT', 1 );
require_once 'App.php';
$app = App::getInstance ();
$app->preDispath ();

$bank = new BankService ();
$bank->notify ();

      