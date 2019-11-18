<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'                       =>'mysql',
	'DB_HOST'                       =>'localhost',
	'DB_NAME'                       =>'',//
	'DB_USER'                       =>'root',
	'DB_PWD'                        =>'ldh123456',
	'DB_PROT'                       =>'3306',
	'TMPL_PARSE_STRING' =>array(
        '__ALIB__'         =>  __ROOT__.'/Public/Admin/lib',
        '__ASTATIC__'      =>  __ROOT__.'/Public/Admin/static',
        '__ATEMP__'        =>  __ROOT__.'/Public/Admin/temp',
		'__UPIMG__'        =>  __ROOT__.'/Public/Uploads/',
		),
	// 'LAYOUT_ON'=>true,
	// 'LAYOUT_NAME'=>'layout',
	 // 'SHOW_PAGE_TRACE'=>true,
);