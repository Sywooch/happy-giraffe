<?php
/**
 * @author Никита
 * @date 08/04/15
 */

namespace site\frontend\modules\photo\helpers;


class PhotoHelper
{
    public static function adaptImages($html)
    {
        include_once \Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';
        $doc = str_get_html($html);

        if ($doc == false) {
            return $html;
        }

        foreach ($doc->find('img') as $image) {
            $attrs = $image->getAllAttributes();
            unset($attrs['src']);

            $photo = \Yii::app()->thumbs->getPhotoByUrl($image->src);
            if ($photo !== null) {
                $image->outertext = self::picture($photo, $attrs);
            }
        }
        return (string) $doc;
    }

    public static function picture($photo, $attrs = array())
    {
        return \HHtml::picture(\Yii::app()->thumbs->getThumb($photo, 'postImage'), array(
            '320' => \Yii::app()->thumbs->getThumb($photo, 'postImageMobile'),
        ), $attrs);
    }
}