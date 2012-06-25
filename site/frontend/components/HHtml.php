<?php
/**
 * Author: choo
 * Date: 25.06.2012
 */
class HHtml extends CHtml
{
    public static function link($text, $url='#', $htmlOptions=array(), $seoHide = false)
    {
        if (! $seoHide) {
            parent::link($text, $url, $htmlOptions);
        }

        if ($url !== '') {
            $url = self::normalizeUrl($url);
            $hashString = md5($url);
            $htmlOptions['hashString'] = $hashString;
            Yii::app()->controller->seoHrefs[$hashString] = base64_encode($url);
        }
        self::clientChange('click', $htmlOptions);
        return self::tag('a', $htmlOptions, $text);
    }
}
