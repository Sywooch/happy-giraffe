<?php

YiiBase::setPathOfAlias('site', '/home/choo/Mira/happy-giraffe/site');

return array(
	'components' => array(
		'db' => array(
			'connectionString' => 'mysql:host=localhost;dbname=happy_giraffe',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
	),
);