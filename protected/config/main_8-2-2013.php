<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Information Tracking System',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.extensions.*',
        'application.extensions.giix-components.*',
        'application.modules.srbac.models.*',
		'application.modules.srbac.controllers.SBaseController',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'tracking',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
            'generatorPaths'=>array('ext.giix-core'),
		),
		'srbac' => array( 
			'userclass'=>'User', //default: User 
			'userid'=>'id', //default: userid 
			'username'=>'username', //default:username 
			'delimeter'=>'@', //default:- 
			'debug'=>false, //default :false 
			'pageSize'=>15, // default : 15 
			'superUser' =>'Administrator', //default: Authorizer 
			'css'=>'srbac.css', //default: srbac.css 
			'layout'=>'application.views.layouts.main', //default: application.views.layouts.main,
			'notAuthorizedView'=> 'srbac.views.authitem.unauthorized', // default: srbac.views.authitem.unauthorized, must be an existing alias 
			'alwaysAllowed'=>array(), 
			'userActions'=>array('Show','View','List'), //default: array() 
			'listBoxNumberOfLines' => 15, //default : 10 
			'imagesPath' => 'srbac.images', // default: srbac.images 
			'imagesPack'=>'noia', //default: noia 
			'iconText'=>true, // default : false 
			'header'=>'srbac.views.authitem.header',
			'footer'=>'srbac.views.authitem.footer',
			'showHeader'=>true, // default: false 
			'showFooter'=>true, // default: false 
			'alwaysAllowedPath'=>'srbac.components',
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=devcyber_ipddb',
			'emulatePrepare' => true,
			'username' => 'devcyber_ipdusr',
			'password' => 'ipd!@#db',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'authManager'=>array(
			'class'=>'application.modules.srbac.components.SDbAuthManager',
			'connectionID'=>'db',
			'itemTable'=>'items',
			'assignmentTable'=>'assignments',
			'itemChildTable'=>'itemchildren',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);