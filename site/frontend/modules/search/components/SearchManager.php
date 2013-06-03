<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 6/3/13
 * Time: 4:35 PM
 * To change this template use File | Settings | File Templates.
 */

class SearchManager
{
    public static function search($query, $len)
    {
        $raw = Yii::app()->indexden->search('main', $query, null, $len);

        $data = array(
            'total' => $raw->matches,
        );

        return $data;
    }
}