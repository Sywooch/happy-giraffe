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

    protected function beforeSave($event)
    {
        return true;
    }

    protected function afterSave($event)
    {
        return true;
    }

    protected function beforeDelete($event)
    {
        return true;
    }

    protected function afterDelete($event)
    {
        return true;
    }

    protected function beforeFind($event)
    {
        return true;
    }

    protected function afterFind($event)
    {
        return true;
    }

}

?>
