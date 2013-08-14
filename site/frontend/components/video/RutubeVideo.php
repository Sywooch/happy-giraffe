<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/14/13
 * Time: 2:03 PM
 * To change this template use File | Settings | File Templates.
 */

class RutubeVideo extends BasicVideo
{
    public function getEmbed()
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');

        $doc = phpQuery::newDocumentHTML($this->html, $charset = 'utf-8');
        $iframe = $doc->find('iframe');
        $ratio = pq($iframe)->attr('width') / 580;

        $height = round(pq($iframe)->attr('height') / $ratio);

        $iframe->attr('width', 580);
        $iframe->attr('height', $height);

        return $doc->html();
    }
}