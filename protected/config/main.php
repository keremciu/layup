<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Layup',
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
		'clientScript' => array(
			'scriptMap' => array('jquery.js' => false),
			'class' => 'ext.NLSClientScript',
			'compressMergedJs' => true,
   			'compressMergedCss' => true,
		),
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
		'assetManager' => [
			'excludeFiles' =>array('jquery.js','jui','treeview','yiitab','rating','autocomplete','jquery.yii.js'),
		],
		'db'=>require_once('_db.php'),
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'urlManager'=>array(
	        'urlFormat'=>'path',
	        'showScriptName'=>false,
			'caseSensitive'=>false,
			'rules'=>array(
				'<action:\w+>/'=>'site/index',
				'<controller:\w+>/<title:.*?>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<title:.*?>/<id:\d+>-<name:.*?>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
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
	// All paramaters from _app.php file
	'params'=>require_once('_app.php'),
);
