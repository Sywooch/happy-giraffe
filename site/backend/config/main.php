<?php

return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Админка',
    'language'=>'ru',
	'import'=>array(
        'site.common.models.*',
        'site.common.models.mongo.*',
        'application.models.*',
        'application.components.*',
        'site.frontend.components.Video',
        'site.frontend.helpers.FileHandler',
        'site.frontend.helpers.CArray',
        'site.frontend.components.*',
        'site.frontend.extensions.*',
        'site.frontend.extensions.shoppingCart.*',
        'site.frontend.extensions.LinkPager',
        'site.frontend.extensions.ufile.*',
    	'site.frontend.extensions.image.Image',
        'site.frontend.extensions.YiiMongoDbSuite.*',
        'site.frontend.modules.attribute.models.*',
        'site.frontend.modules.names.models.*',
        'site.frontend.helpers.*'
	),
	'components' => array(
        'widgetFactory' => array(
            'widgets' => array(
                'LinkPager' => array(
                    'cssFile' => FALSE,
                    'header' => '',
                    'nextPageLabel' => '',
                    'prevPageLabel' => '',
                    'maxButtonCount' => 5,
                ),
            ),
        ),
		'urlManager' => array(
			'urlFormat'=>'path',
            'showScriptName'=>false
		),
        'db' => array(
            'schemaCachingDuration' => 3600,
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'tablePrefix'=> '',
        ),
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
            'itemTable'=>'auth_item',
            'itemChildTable'=>'auth_item_child',
            'assignmentTable'=>'auth_assignment',
            'defaultRoles' => array('guest'),
        ),
        'mongodb' => array(
            'class'            => 'EMongoDB',
            'connectionString' => 'mongodb://localhost',
            'dbName'           => 'happy_giraffe_db',
            'fsyncFlag'        => true,
            'safeFlag'         => true,
            'useCursor'        => false
        ),
        'comet'=>array(
            'class' => 'site.frontend.extensions.Dklab_Realplexor',
            'host' => 'plexor.dev.happy-giraffe.ru',
            'port' => 10010,
            'namespace' => 'crm_',
        ),
        'cache'=>array(
            //	'class' => 'CMemCache',
            'class' => 'CDummyCache',
        )
	),

    'params' => array(
        'ufileStorageRoot' => 'temp_upload',
        'frontend_url'=>'http://www.happy-giraffe.ru/'
    )
);