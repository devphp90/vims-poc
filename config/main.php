<?php



// uncomment the following to define a path alias

// Yii::setPathOfAlias('local','path/to/local-folder');



// This is the main Web application configuration. Any writable

// CWebApplication properties can be configured here.

return array(

	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',

	'name'=>'VIMS 4.2',



	// preloading 'log' component

	'preload'=>array(

		'log',

		'bootstrap',

	),



	// autoloading model and component classes

	'import'=>array(

		'application.models.*',

		'application.components.*',

		'application.widgets.*',

	),



	'modules'=>array(

		// uncomment the following to enable the Gii tool

		///*

		'importcsv'=>array(

			'path'=>'upload/importCsv/', // path to folder for saving csv file and file with import params

		),

		'gii'=>array(

			'class'=>'system.gii.GiiModule',

			'password'=>'cannotguessit',

			// If removed, Gii defaults to localhost only. Edit carefully to taste.

			'ipFilters'=>array('127.0.0.1','::1','*'),

			'generatorPaths' => array(

				'bootstrap.gii'

			),

		),

		//*/



	),





	// application components

	'components'=>array(

			'bootstrap' => array(

		    'class' => 'ext.bootstrap.components.Bootstrap',

		    'responsiveCss' => false,

		),



		'mutex' => array(

			'class' => 'application.extensions.EMutex',

		),

		'cache'=>array(

		    'class'=>'system.caching.CFileCache',

		  ),

		'clientScript'=>array(

			'packages'=>array(

				'jquery'=>array(

					'baseUrl'=>'//ajax.googleapis.com/ajax/libs/jquery/1.8.3/',

					'js'=>array('jquery.min.js'),

				),

				'jquery.ui'=>array(

					'baseUrl'=>'//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2',

					'js'=>array('jquery-ui.min.js'),

				),

			),

			// other clientScript config

		),



		'user'=>array(

			// enable cookie-based authentication

			'allowAutoLogin'=>false,

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

		'db'=>array(

			'connectionString' => 'mysql:host=localhost;dbname=vims_ubs',

			'tablePrefix'=>'vims_',

			'username' => 'vims',

			'password' => 'yHP]pn**G&gP',

			'charset' => 'utf8',

			'enableParamLogging'=>true,

			'enableProfiling'=>true,

		),

		'db2'=>array(

			'class'=>'application.extensions.PHPPDO.CPdoDbConnection',

      'pdoClass' => 'PHPPDO',



		   // old MS PDO + MSSQL 2000:

		   'connectionString' => 'dblib:host=24.187.208.82:1433;dbname=ubsInterimTestDB',

		  // 'connectionString' => 'sqlsrv:Server=24.187.208.82;Database=ubsInterimTestDB',

		  	'pdoClass' => 'PDO',

		      'username' => 'VimsConnectUser1',

		      'password' => 'V1mS4sA1e',

		      'charset' => 'utf8',

		),

		'errorHandler'=>array(

			// use 'site/error' action to display errors

			'errorAction'=>'site/error',

		),

		'log'=>array(

			'class'=>'CLogRouter',

			'routes'=>array(

/*
				array(

					'class'=>'CFileLogRoute',

					'levels'=>'error, warning, trace',

				),
*/





				array(

	            	'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',

	            	'ipFilters'=>array('219.84.63.17','219.85.164.215','1.34.172.93','192.168.1.102'),

	            ),





			),

		),

	),

	// application-level parameters that can be accessed

	// using Yii::app()->params['paramName']

	'params'=>array(

		// this is used in contact page

		'adminEmail'=>'admin@axeo.com',

	),

);