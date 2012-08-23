<?php
/**
 * Author: choo
 * Date: 25.06.2012
 */
class HHtml extends CHtml
{
    public static function link($text, $url='#', $htmlOptions=array(), $seoHide = false)
    {
        if ($url !== '') {
            $url = self::normalizeUrl($url);
            if ($seoHide && !Yii::app()->request->isAjaxRequest && $url != '#') {
                $hashString = md5($url);
                $htmlOptions['data-key'] = $hashString;
                $htmlOptions['data-type'] = 'href';
                Yii::app()->controller->seoHrefs[$hashString] = base64_encode($url);
            } else {
                $htmlOptions['href'] = $url;
            }
        }
        self::clientChange('click', $htmlOptions);
        return self::tag('a', $htmlOptions, $text);
    }
}
