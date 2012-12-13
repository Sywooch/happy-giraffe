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
    public $recipe;

    public function setSpecificValues()
    {
        $this->recipe = $this->getRecipe();
    }

    public function getRecipe()
    {
        $criteria = new CDbCriteria(array(
            'with' => array(
                'photo',
                'attachPhotos',
                'author' => array(
                    'with' => 'avatar',
                ),
                'commentsCount',
                'tags',
            ),
        ));

        return CookRecipe::model()->findByPk($this->id, $criteria);
    }
}
