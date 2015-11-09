<?php
/**
 * @author Никита
 * @date 04/08/15
 */

include_once \Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

class SocialHelper
{
    const CACHE_EXPIRATION_TIME = 300;
    const OK_PAGE = 'http://ok.ru/happygiraffe';

    public static function ok()
    {
        $cacheId = 'SocialHelper.ok';
        $value = self::getCacheComponent()->get($cacheId);
        if ($value === false) {
            $ctx = stream_context_create(array('http'=>
                array(
                    'timeout' => 3,
                )
            ));
            $page = @file_get_contents(self::OK_PAGE, null, $ctx);
            if ($page === false) {
                $value = 0;
            } else {
                $doc = str_get_html($page);
                $el = $doc->find('#groupMembersCntEl', 0);
                if ($el) {
                    $value = 0;
                } else {
                    $value = $doc->find('#groupMembersCntEl', 0)->plaintext;
                    $value = preg_replace('/&#?[a-z0-9]+;/i', '', $value);
                }
                self::getCacheComponent()->set($cacheId, $value, self::CACHE_EXPIRATION_TIME);
            }
        }
        return $value;
    }

    /**
     *
     * @return \CCache
     */
    protected static function getCacheComponent()
    {
        return \Yii::app()->getComponent('dbCache');
    }
}