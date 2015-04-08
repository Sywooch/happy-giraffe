<?php

/**
 * Author: choo
 * Date: 25.06.2012
 */
class HHtml extends CHtml
{

    public static function link($text, $url = '#', $htmlOptions = array(), $seoHide = false)
    {
        return ($seoHide && Yii::app()->user->isGuest && !Yii::app()->request->isAjaxRequest && $url != '#') ?
            Yii::app()->controller->renderDynamic(array('HHtml', 'renderLink'), $text, $url, $htmlOptions, $seoHide) :
            HHtml::renderLink($text, $url, $htmlOptions, $seoHide);
    }

    public static function renderLink($text, $url = '#', $htmlOptions = array(), $seoHide = false)
    {
        if ($url !== '')
        {
            $url = self::normalizeUrl($url);
            if ($seoHide && !Yii::app()->request->isAjaxRequest && $url != '#')
            {
                $hashString = md5($url);
                $htmlOptions['data-key'] = $hashString;
                $htmlOptions['data-type'] = 'href';
                Yii::app()->controller->seoHrefs[$hashString] = base64_encode($url);
            }
            else
            {
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

    public static function timeTag($model, $htmlOptions = array(), $content = false)
    {
        $id = substr(strrchr(get_class($model), '\\'), 1) . '_' . $model->id . '_' . 'time';
        $htmlOptions['id'] = $id;
        if ($content === false) {
            $content = Yii::app()->format->formatDatetime($model->pubUnixTime);
        }
        return self::timeTagByOptions($model->pubUnixTime, $htmlOptions, $content);
    }

    public static function timeTagByOptions($unixTime, $htmlOptions, $content = false)
    {
        $htmlOptions['data-bind'] = 'moment: ' . $unixTime;
        $htmlOptions['datetime'] = date('Y-m-d\TH:i:sP', $unixTime);

        $cs = Yii::app()->clientScript;
        $id = $htmlOptions['id'];
        $js = 'ko.cleanNode(document.getElementById(\'' . $id . '\')); ko.applyBindings({}, document.getElementById(\'' . $id . '\'));';
        if ($cs->useAMD) {
            $cs->registerAMD($id, array('ko' => 'knockout', 'ko_library' => 'ko_library'), $js);
        } else {
            $cs->registerScript($id, $js);
        }

        return '<!-- ko stopBinding: true -->' . self::tag('time', $htmlOptions, $content) . '<!-- /ko -->';
    }

    public static function picture($defaultSrc, $alt = '', $adaptive = array())
    {
        $output = '';
        $output .= self::openTag('picture');
        foreach ($adaptive as $width => $src) {
            $output .= CHtml::tag('source', array(
                'srcset' => $src,
                'media' => '(max-width: ' . $width . 'px)',
            ));
        }
        $output .= CHtml::tag('img', array(
            'srcset' => $defaultSrc,
            'alt' => $alt,
            'style' => 'width: auto;',
        ));
        $output .= self::closeTag('picture');
        return $output;
    }
}
