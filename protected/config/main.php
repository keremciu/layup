<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Dribbble Invite',
	'language'=>'en',
	'preload'=>array('log'),
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123654',
			'ipFilters'=>array('127.0.0.1',$_SERVER['REMOTE_ADDR']),
			'generatorPaths'=>array(
            	'booster.gii',
        	),
		),
	),
	'components'=>array(
		'mailer' => array(
      		'class' => 'application.extensions.EMailer',
      	),
		'user'=>array(
			'allowAutoLogin'=>true,
			'class' => 'WebUser',
		),
		'phpThumb'=>array(
		    'class'=>'application.extensions.EPhpThumb.EPhpThumb',
		    'options'=>array()
		),
		'bootstrap'=>array(
        	'class'=>'application.extensions.bootstrap.components.Booster',
        	'responsiveCss' => true,
    	),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=dribbble',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
		),
		'urlManager'=>array(
	        'urlFormat'=>'path',
	        'showScriptName'=>false,
			'caseSensitive'=>false,
			'rules'=>array(
				'<action:\w+>'=>'site/<action>',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// Dribbble app infos
		'client_id' => '892332a39770b7446ffe2e2aa3f4736f7bdc1df8180161c85d41bf047068770a',
		'client_secret' => '32b0079edd0803c0fd17d792202c724ec1bf9af86fe8311860c1aa01373025cc',
		// this is used in contact page
		'adminEmail'=>'kerem@ritmix.org',
	),
);