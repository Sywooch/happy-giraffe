<?php
namespace site\frontend\modules\posts\modules\buzz\components;
/**
 * @author Никита
 * @date 21/10/15
 */

class BuzzUrlRule extends \CBaseUrlRule
{
    public $advExceptions = array(
        247154,

        240984,
        691779,
        675554,

        697054,
        691084,
        268736,
        691864,

        270589,
        676679,
        256624,
        252664,
        250794,
    );

    public function createUrl($manager, $route, $params, $ampersand)
    {
        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        if (preg_match('#^community/(\d+)/forum/advpost/(\d+)#', $pathInfo, $matches)) {
            $postId = $matches[2];

            if (array_search($postId, $this->advExceptions) === false) {
                $_GET['content_type_slug'] = 'advpost';
                $_GET['content_id'] = $matches[2];
                return 'posts/buzz/post/view';
            }
        }
        return false;
    }
}