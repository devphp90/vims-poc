<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'VIMS 3.0 Console',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=vims_ubs',
			'tablePrefix'=>'vims_',
			'username' => 'vims',
			'password' => 'yHP]pn**G&gP',
			'charset' => 'utf8',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, trace',
				),
			),
		),
		'ftp'=>array(
    	'class'=>'application.extensions.EFtpComponent',
      'host'=>'127.0.0.1',
      'port'=>21,
      'username'=>'',
      'password'=>'',
      'ssl'=>false,
      'timeout'=>90,
      'autoConnect'=>false,
		),
		'zip'=>array(
			'class'=>'application.extensions.EZip',
		),
	),
	'params'=>array(
		'rawDir'=>'c:\\vims\\sheets\\temp\\',
		'archiveDir'=>'c:\\vims\\sheets\\archive\\',
		'currentDir'=>'c:\\vims\\sheets\\current\\',
		'dbInputDir'=>'c:\\vims\\sheets\\toload\\',
		'vimsDelimeter'=>'[VIMS]',
	),
);