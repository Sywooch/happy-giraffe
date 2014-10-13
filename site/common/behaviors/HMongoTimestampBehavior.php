<?php

namespace site\common\behaviors;

/**
 * Description of HMongoTimestampBehavior
 *
 * @author Кирилл
 * @property \EMongoDocument $owner Description
 */
class HMongoTimestampBehavior extends \EMongoDocumentBehavior
{

    public $createAttribute = 'dtimeCreate';
    public $updateAttribute = 'dtimeUpdate';
    public $setUpdateOnCreate = true;

    public function beforeSave($event)
    {
        if ($this->owner->isNewRecord)
        {
            $this->owner->{$this->createAttribute} = $this->getTime();
            if ($this->setUpdateOnCreate)
                $this->owner->{$this->updateAttribute} = $this->owner->{$this->createAttribute};
        }
        else
        {
            $this->owner->{$this->updateAttribute} = $this->getTime();
        }

        return parent::beforeSave($event);
    }

    public function getTime()
    {
        return time();
    }

}

?>
