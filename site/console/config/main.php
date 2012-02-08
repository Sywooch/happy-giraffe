<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console Application',
    'commandMap' => array(
        'migrate' => array(
            'class' => 'system.cli.commands.MigrateCommand',
            'migrationPath' => 'site.common.migrations',
        ),
    ),
    'import' => array(
        'site.frontend.components.*',
        'site.frontend.models.*',
        'site.frontend.modules.names.models.*',
    ),
    'components' => array(
        'comet' => array(
            'class' => 'site.frontend.extensions.Dklab_Realplexor',
            'host' => 'chat.happy-giraffe.com',
            'port' => 10010,
            'namespace' => 'crm_',
        ),
        'db'=>require_once(dirname(__FILE__).'/db.php'),
    ),
);