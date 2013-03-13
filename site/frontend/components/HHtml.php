<?php
/**
 * Author: choo
 * Date: 25.06.2012
 */
class HHtml extends CHtml
{
    public static function link($text, $url='#', $htmlOptions=array(), $seoHide = false)
    {
        return ($seoHide && ! Yii::app()->request->isAjaxRequest && $url != '#') ?
            Yii::app()->controller->renderDynamic(array('HHtml', 'renderLink'), $text, $url, $htmlOptions, $seoHide)
            :
            HHtml::renderLink($text, $url, $htmlOptions, $seoHide);
    }

    public static function renderLink($text, $url='#', $htmlOptions=array(), $seoHide = false)
    {
        if ($url !== '') {
            $url = self::normalizeUrl($url);
            if ($seoHide && ! Yii::app()->request->isAjaxRequest && $url != '#') {
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

    public static function lazyImage($src, $width, $height, $alt = '', $htmlOptions = array())
    {
        $htmlOptions['src'] = 'http://images2.wikia.nocookie.net/__cb20100822143346/runescape/images/2/21/1x1-pixel.png';
        isset($htmlOptions['class']) ? $htmlOptions['class'] .= ' lazy' : $htmlOptions['class'] = 'lazy';
        $htmlOptions['data-original'] = $src;
        $htmlOptions['width'] = $width;
        $htmlOptions['height'] = $height;
        $htmlOptions['alt'] = $alt;

        return self::tag('img', $htmlOptions);
    }
}
