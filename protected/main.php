<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'',

	// preloading 'log' component
	'preload'=>array('log','bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.behavior.*',
        'application.extensions.*',
        'application.extensions.giix-components.*',
        'application.modules.srbac.models.*',
		'application.modules.srbac.controllers.SBaseController',
        'ext.yii-mail.YiiMailMessage',
        'ext.bootstrap.widgets.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'tracking',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
            'generatorPaths'=>array('ext.giix-core','bootstrap.gii'),
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
		'appform'=>array(
		    'defaultController'=>'applicationForm',
		    'documentClass'=>'IncDocument',
		    'documentId'=>'document_id',
		    'documentNo'=>'inc_document_no',
		    'documentTitle'=>'document_title',
                    'documentDate'=>'document_date',
		),
	),

	// application components
	'components'=>array(
		'bootstrap' => array(
	    'class' => 'ext.bootstrap.components.Bootstrap',
	    'responsiveCss' => TRUE,
		),
		'email'=>array(
        'class'=>'application.extensions.email.Email',
        'delivery'=>'php', //Will use the php mailing function.  
        //May also be set to 'debug' to instead dump the contents of the email into the view
   		 ),
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
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		    'initSQLs'=>array('SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE;'),
		),
		/*'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=devcyber_ipddb',
			'emulatePrepare' => true,
			'username' => 'devcyber_ipdusr',
			'password' => 'ipd!@#db',
			'charset' => 'utf8',
		),*/
		
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
        'mail'=>array(
            'class'=>'ext.yii-mail.YiiMail',
            'transportType'=>'smtp',
            'transportOptions'=>array(
                'host'=>'sr2.supercp.com',
                'username'=>'test@dev.cyberia.la',
                'password'=>'cbr007007',
                'port'=>465,
                'encryption'=>'tls',
            ),
            'viewPath'=>'application.views.mail',
            'logging'=>true,
            'dryRun'=>false,
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'Isapplication_id'=>2, // fixed ID is application get form id documentType
		'Organization_id'=>8, // fixed ID is singer window get from id Organization
		'IsAppReOffice'=>9,	// fixed ID is application get form id documentType
		'IsAppMining'=>11,  // fixed ID is application get form id documentType
		'IsAppElectricity'=>12, //fixed ID is application get form id documentType
		'IsAppGeneral'=>13, //fixed ID is application get form id documentType
		'Region_Name_Domestic'=>'Domestic', // fixed form the table received_app_with_sector use to report
		'Region_Name_Foreign'=>'Foreign', // fixed form the table received_app_with_sector use to report
		'Region_Name_JointVenture'=>'Joint venture',
		'CountdownYear'=>2, //Fixed use search report app recieve Add to Countdown 2 year add in dropdown
		'yearsVisa'=>array('4','3','2','1','0'),// fixed array count down year loop back five year later use  to report Visa 
		'IDVisa_3_6_12'=>'16,17,18',//fiexed ID of table document type use to report visa between
		'IDVisa_border'=>15, // fixed ID of table document type user to report visa count of border
		///'DoctypeID_Changlaw'=>19,// Fixed ID of Table Document type Use to report Rechange Law 
		'DoctypeID_Changlaw'=>31,// Fixed ID of Table Document type Use to report Rechange Law
		'ApptypeID'=>1, // Fixed Id of table Applacation type Repoffice use to report Rechange Law
		'Contact_ipd'=>'020 77505017', // Contact of IPD Send Email
		'Month'=>array('1','2','3','4','5','6','7','8','9','10','11','12'),
		'typeDoc_id_general'=>'1,3,4,5,6', // Fixed ID of Table Document type Use to report General
		'typeDoc_id_qualification'=>'20,21,29,30', // Fixed ID of Table Document type Use to report General (qualification)
		
	),
	
	'language'=>'lo',
	'behaviors'=>array(
		'onBeginRequest'=>array(
			'class'=>'application.components.StartupBehavior',
		),
	),
);
