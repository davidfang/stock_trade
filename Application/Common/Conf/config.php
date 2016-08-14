<?php
return array(
	//'配置项'=>'配置值'
    'VERIFY_NUM'    =>4,//验证码数量
    'PAGE_NUM'      =>10,//分页每页显示数据量
    'URL_MODEL'     =>2,
    'PUSH_BEGIN'    =>'23:30:00',//提成开始时间
    'PUSH_END'    =>'23:59:59',//提成结束时间

    /* 模板替换 */
    'TMPL_PARSE_STRING' => array(
        '__UPLOADS__'    => __ROOT__ . '/Uploads/download_xlsx',
        '__IMG__'    => __ROOT__ . '/Public/Images',
        '__HIMG__'     => __ROOT__ . '/Public/Home/Images',
        '__HEXCEL__'     => __ROOT__ . '/Public/Home/Excel',
        '__HCSS__'    => __ROOT__ . '/Public/Home/Css',
        '__HJS__'     => __ROOT__ . '/Public/Home/Js',
        '__ASSETS__'     =>__ROOT__ . '/Public/assets',
        '__STAICK__'     =>__ROOT__ . '/Public/Staick',
        '__ADHIBITION__'     =>__ROOT__ . '/Public/adhibition',
    ),

    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'stock_manage', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '123456', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => '', // 数据库表前缀

    //短信验证
    'RONGLIAN_ACCOUNT_SID'   => '8a48b5514c7d3d77014c8dbc5ef8079f', //容联云通讯 主账号 accountSid
    'RONGLIAN_ACCOUNT_TOKEN' => 'b9cf811c8c454d2d83cfdab6e00fa0c1', //容联云通讯 主账号token accountToken
    'RONGLIAN_APPID'         => '8aaf0708567749f0015686b6ab9b0a31', //容联云通讯 应用Id appid
    'RONGLIAN_TEMPLATE_ID'   => '1', //容联云通讯 模板Id【1：代表测试模板】
    'PAST_DUE_TIME'   => '60', //验证码过期时间【单位：秒】
);