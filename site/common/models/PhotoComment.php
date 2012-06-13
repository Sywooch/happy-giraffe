<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eugene
 * Date: 07.06.12
 * Time: 18:23
 * To change this template use File | Settings | File Templates.
 */
class PhotoComment extends Comment
{
    /**
     * Returns the static model of the specified AR class.
     * @return Comment the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
