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
    protected function _getEmbed($width = 580)
    {
        $doc = phpQuery::newDocumentHTML($this->html);
        $iframe = $doc->find('iframe');
        $ratio = pq($iframe)->attr('width') / $width;

        $height = round(pq($iframe)->attr('height') / $ratio);

        $iframe->attr('width', $width);
        $iframe->attr('height', $height);

        return $doc->html();
    }
}