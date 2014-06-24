<?php

namespace site\frontend\modules\notifications\behaviors;

/**
 * Description of BaseBehavior
 *
 * @author Кирилл
 */
class BaseBehavior extends \CBehavior
{

    public function events()
    {
        return array_merge(parent::events(), array(
            'onBeforeSave' => 'beforeSave',
            'onAfterSave' => 'afterSave',
            'onBeforeDelete' => 'beforeDelete',
            'onAfterDelete' => 'afterDelete',
            'onBeforeFind' => 'beforeFind',
            'onAfterFind' => 'afterFind',
        ));
    }

    public function beforeSave($event)
    {
        return true;
    }

    public function afterSave($event)
    {
        return true;
    }

    public function beforeDelete($event)
    {
        return true;
    }

    public function afterDelete($event)
    {
        return true;
    }

    public function beforeFind($event)
    {
        return true;
    }

    public function afterFind($event)
    {
        return true;
    }

}

?>
