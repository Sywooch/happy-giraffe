<?php
/**
 * @author Никита
 * @date 29/10/14
 *
 * @property \User $pageOwner
 */

class PersonalAreaController extends LiteController
{
    public $ownerId;
    public $showMenu = false;

    private $_owner;

    public function init()
    {

        parent::init();
    }

    protected function beforeAction($action)
    {
        if ((isset($this->actionParams['userId']))) {
            $this->ownerId = $this->actionParams['userId'];
        }

        if ($this->isPersonalLayout()) {
            $this->layout = '//layouts/lite/personalArea';
        }

        if ($this->pageOwner !== null) {
            $this->breadcrumbs[$this->widget('Avatar', array('user' => $this->pageOwner, 'size' => Avatar::SIZE_MICRO, 'tag' => 'span'), true)] = array();
        }

        return parent::beforeAction($action);
    }

    public function isPersonalLayout()
    {
        return $this->isPersonalArea() && $this->showMenu;
    }

    public function isPersonalArea()
    {
        if (Yii::app()->user->isGuest) {
            return false;
        }

        return $this->ownerId == Yii::app()->user->id;
    }

    public function getPageOwner()
    {
        if ($this->_owner === null && $this->ownerId !== null) {
            $this->_owner = \User::model()->findByPk($this->ownerId);
        }
        return $this->_owner;
    }

    public function filterShowMenu($filterChain)
    {
        $this->showMenu = true;
        $filterChain->run();
    }
} 