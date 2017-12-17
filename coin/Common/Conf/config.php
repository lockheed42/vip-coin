<?php
return array(
	//'配置项'=>'配置值'
    'URL_CASE_INSENSITIVE'  =>  true,
    'URL_MODEL' => 0,

    'VAR_MODULE'            =>  'm',     // 默认模块获取变量
    'VAR_CONTROLLER'        =>  'c',    // 默认控制器获取变量
    'VAR_ACTION'            =>  'a',    // 默认操作获取变量

    'URL_PARAMS_BIND'       =>  true, // URL变量绑定到操作方法作为参数

    //数据库配置信息
    //本地
//    'DB_TYPE'   => 'mysql', // 数据库类型
//    'DB_HOST'   => 'localhost', // 服务器地址
//    'DB_NAME'   => 'd_vip_coin', // 数据库名
//    'DB_USER'   => 'root', // 用户名
//    'DB_PWD'    => '', // 密码
//    'DB_PORT'   => 3306, // 端口
//    'DB_PREFIX' => 't_', // 数据库表前缀
//    'DB_CHARSET'=> 'utf8', // 字符集
//    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增

//远程连接线上
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '120.26.160.130', // 服务器地址
    'DB_NAME'   => 'd_vip_coin', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'P20fivm3i348sfhjhjy', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 't_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
);