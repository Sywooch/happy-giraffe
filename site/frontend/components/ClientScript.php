<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 6/28/13
 * Time: 11:23 AM
 * To change this template use File | Settings | File Templates.
 */

class ClientScript extends CClientScript
{
    public function getHasNoindex()
    {
//        $robotsTxt = array(
//            'albums',
//            'signup',
//            'search',
//            'messaging',
//        );
//
//        foreach ($robotsTxt as $segment)
//            if (strpos(Yii::app()->request->requestUri, '/' . $segment) === 0)
//                return true;
//
//
//        foreach ($this->metaTags as $tag)
//            if ($tag['name'] == 'robots' && $tag['content'] == 'noindex')
//                return true;

        return false;
    }
}