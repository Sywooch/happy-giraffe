<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 2/4/13
 * Time: 5:08 PM
 * To change this template use File | Settings | File Templates.
 */

return array(
    'urlFormat' => 'path',
    'showScriptName' => false,
    'urlSuffix' => '/',
    'useStrictParsing' => true,
    'rules' => array(
        'community/<community_id:\d+>/forum/<content_type_slug:\w+>/<content_id:\d+>' => 'community/view',
    ),
);