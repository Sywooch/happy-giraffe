<?php

return CMap::mergeArray(
	/*require(dirname(__FILE__) . '/../../common/config/main.php'),
	require(dirname(__FILE__) . '/../../common/config/main-local.php'),*/
	require(dirname(__FILE__).'/main.php'),
	require(dirname(__FILE__).'/main-local.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'db' => array(
				'connectionString' => 'mysql:host=192.168.0.140;port=3306;dbname=happy-giraffe',
				'emulatePrepare' => true,
				'username' => 'intel',
				'password' => 'dessel42',
				'charset' => 'utf8',
				//'schemaCacheID' => 'apc',
				//'schemaCachingDuration' => 5, // 2 часа
				'class'=>'DbConnectionMan',
				'enableSlave'=>true,
				'slaves'=>array(//slave connection config is same as CDbConnection
					array(
						'connectionString'=>'mysql:host=192.168.0.137;port=3306;dbname=happy_giraffe',
						'username'=>'intel',
						'password'=>'test',
						'charset' => 'utf8'
					),
				),
			),
		),
	)
);
