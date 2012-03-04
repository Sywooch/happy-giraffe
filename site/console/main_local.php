<?php

YiiBase::setPathOfAlias('site', 'path/to/site');

return array(
	'components' => array(
		'db' => array(
			'connectionString' => 'mysql:host=localhost;dbname=happy_giraffe',
			'emulatePrepare' => true,
			'username' => '',
			'password' => '',
			'charset' => 'utf8',
		),
	),
);