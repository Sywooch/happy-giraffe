<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 1:40 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventRecipe extends FriendEvent
{
    public $type = FriendEvent::TYPE_RECIPE_ADDED;
    public $recipe_id;

    private $_recipe;

    public function init()
    {
        $this->_recipe = $this->_getRecipe();
    }

    public function getRecipe()
    {
        return $this->_recipe;
    }

    public function setRecipe($recipe)
    {
        $this->_recipe = $recipe;
    }

    private function _getRecipe()
    {
        return CookRecipe::model()->resetScope()->findByPk($this->recipe_id);
    }

    public function getLabel()
    {
        return HDate::simpleVerb('Добавил', $this->user->gender) . ' <span class="sub-category"><span class="icon-cook"></span>Кулинарный рецепт</span>';
    }

    public function createBlock()
    {
        $this->recipe_id = (int) $this->params['model']->id;
        $this->user_id = (int) $this->params['model']->author_id;

        parent::createBlock();
    }
}
