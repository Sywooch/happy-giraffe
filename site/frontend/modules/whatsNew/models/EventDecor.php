<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/29/12
 * Time: 11:18 AM
 * To change this template use File | Settings | File Templates.
 */
class EventDecor extends Event
{
    public $decorations;

    protected $clusterable = true;

    public function setSpecificValues()
    {
        $this->decorations = $this->getDecorations();
    }

    public function getDecorations()
    {
        $criteria = new CDbCriteria(array(
            'with' => 'photo',
            'limit' => 9,
        ));

        return CookDecoration::model()->findAll($criteria);
    }

    public function canBeCached()
    {
        return false;
    }
}
