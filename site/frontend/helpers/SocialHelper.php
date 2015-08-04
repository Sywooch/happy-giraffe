<?php
/**
 * @author Никита
 * @date 04/08/15
 */

include_once \Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

class SocialHelper
{
    const OK_PAGE = 'http://ok.ru/happygiraffe';

    public static function ok()
    {
        $cacheId = 'SocialHelper.ok';
        $value = self::getCacheComponent()->get($cacheId);
        if ($value === false) {
            $page = file_get_contents(self::OK_PAGE);
            $doc = str_get_html($page);
            $value = $doc->find('#groupMembersCntEl', 0)->plaintext;
            $value = preg_replace('/&#?[a-z0-9]+;/i', '', $value);
            self::getCacheComponent()->set($cacheId, $value, 300);
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