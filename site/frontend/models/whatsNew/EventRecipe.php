<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/29/12
 * Time: 11:20 AM
 * To change this template use File | Settings | File Templates.
 */
class EventRecipe extends Event
{
    public function getRecipe()
    {
        $criteria = new CDbCriteria(array(
            'with' => array(
                'photo',
                'attachPhotos',
                'author',
                'commentsCount',
            ),
        ));

        return CookRecipe::model()->findByPk($this->id, $criteria);
    }
}
