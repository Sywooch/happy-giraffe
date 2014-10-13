<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 14/01/14
 * Time: 22:49
 * To change this template use File | Settings | File Templates.
 */

class RelatedEntityBehavior extends CActiveRecordBehavior
{
    public $possibleRelations = array();

    public function beforeCount($event)
    {
        $this->run();
    }

    public function beforeFind($event)
    {
        $this->run();
    }

    public function getRelatedModel()
    {
        $this->run();
        $entityName = 'RelatedEntity' . $this->owner->entity;
        return $this->owner->$entityName;
    }

    protected function run()
    {
        $criteria = $this->owner->getDbCriteria();
        $relationIndex = $criteria->with === null ? false : array_search('relatedModel', $criteria->with);

        unset($criteria->with[$relationIndex]);
        $class = CActiveRecord::BELONGS_TO;

        foreach ($this->possibleRelations as $entity => $entityClass) {
            $relationName = 'RelatedEntity' . $entity;
            $this->owner->getMetaData()->relations[$relationName] =
                new $class($relationName,
                    $entityClass,
                    'entity_id'
                );
            if ($relationIndex !== false)
                $criteria->with[] = $relationName;
        }

        $this->owner->setDbCriteria($criteria);
    }
}