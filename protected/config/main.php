<?php
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SAHABAT | DEMOKRAT',
	'preload'=>array('log','maintenance','nodeSocket'),
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.select2.Select2'
	),
	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Arafat12',
			'ipFilters'=>array('110.50.84.111','36.68.38.113','66.96.231.139','127.0.0.1','::1'),
		),
	),
	'components'=>array(
		'user'=>array(
            'class' => 'application.components.EWebUser',
			'allowAutoLogin'=>true,
			//'authTimeout'=>1800, //30 Menit 60 Detik x 30 Menit
		),
		'helpers' => array(
            'class' => 'application.components.Helpers',
        ),
		'global' => array(
            'class' => 'application.components.Globals',
        ),
		'setting' => array(
            'class' => 'application.components.Settings',
        ),
		'maintenance' => array(
            'class' => 'application.components.Maintenance',
			'allowedIPs'=>array('110.50.84.111','36.68.38.113','66.96.231.139','127.0.0.1','::1'),
			'locked'=>false,//ubah jadi true bila maintenance
            'redirectURL'=>'/maintenance.html',
        ),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'caseSensitive'=>false,
			'rules'=>array(
				'bpokk'=>'users/login',
				//API Controller For Restfull
				array('_api/list', 'pattern'=>'_api/<model:\w+>', 'verb'=>'GET'),
				array('_api/view', 'pattern'=>'_api/<model:\w+>/<id:\d+>', 'verb'=>'GET'),
				array('_api/update', 'pattern'=>'_api/<model:\w+>/<id:\d+>', 'verb'=>'PUT'),
				array('_api/delete', 'pattern'=>'_api/<model:\w+>/<id:\d+>', 'verb'=>'DELETE'),
				array('_api/create', 'pattern'=>'_api/<model:\w+>', 'verb'=>'POST'),
				//API Controller For Native Android / IOS
				array('_api/postOne', 'pattern'=>'api/v2/<model:\w+>', 'verb'=>'POST'),
				array('_api/getList', 'pattern'=>'api/v2/<model:\w+>', 'verb'=>'GET'),
				array('_api/getOne', 'pattern'=>'api/v2/<model:\w+>/<id:\d+>', 'verb'=>'GET'),
				array('_api/putOne', 'pattern'=>'api/v2/<model:\w+>/<id:\d+>', 'verb'=>'PUT'),
				array('_api/delete', 'pattern'=>'api/v2/<model:\w+>/<id:\d+>', 'verb'=>'DELETE'),
				array('_api/images', 'pattern'=>'api/v2/images/<model:\w+>/<id:\d+>', 'verb'=>'GET'),
				// Default Web Page Controller
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=sahabat_databases',
			'emulatePrepare' => true,
			'username' => 'sahabat_user',
			'password' => 'tqYrGECZ',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			'errorAction'=>YII_DEBUG ? null : 'error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'system.*',
				),/*
				array(
					'class'=>'CWebLogRoute',
					'levels'=>'trace, info, error, warning',
				),/*
				array(
					'class'=>'ext.LogDb',
                    'autoCreateLogTable'=>true,
                    'connectionID'=>'db',
                    'enabled'=>true,
                    'levels'=>'error',
				),*/
			),
		),
	),/*
	'nodeSocket' => array(
		'class' => 'application.extensions.yii-node-socket.lib.php.NodeSocket',
		'host' => 'localhost',	// default is 127.0.0.1, can be ip or domain name, without http
		'port' => 3001		// default is 3001, should be integer
	),*/
	'params'=>array(
		'adminEmail'=>'admin@sahabatdemokrat.org',
		'developerEmail'=>'arafat.jr@icloud.com',
		'FIREBASE_API_KEY'=>'AAAATPRwMg0:APA91bEaNzbwqYZ08JSW59yXp3qBZH61LHNHpeorNVgzEME80XGNWXVnQNgkBdiUx8_T766CF6KilQ4E2tmG55PNQrxTH8vbViyZ2_nMWb-b9ZHdlVgD_N7G420yVhBauivk2fZ3XD1t',
		'FIREBASE_LEGACY_API_KEY'=>'AIzaSyC9KHMrU-tgpOkVzDl7cAOOEwF8ysRB57w',
	),
);
