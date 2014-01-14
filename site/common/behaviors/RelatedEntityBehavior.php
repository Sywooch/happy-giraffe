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

    public function beforeFind($event)
    {
        $criteria = $this->owner->getDbCriteria();
        $relationIndex = array_search('relatedModel', $criteria->with);
        if ($relationIndex !== false)
        {
            unset($criteria->with[$relationIndex]);
            $class = CActiveRecord::BELONGS_TO;

            foreach ($this->possibleRelations as $entity) {
                $relationName = 'RelatedEntity' . $entity;
                $this->owner->getMetaData()->relations[$relationName] =
                    new $class($relationName,
                        $entity,
                        'entity_id'
                    );
                $criteria->with[] = $relationName;
                $this->owner->setDbCriteria($criteria);
            }
        }
    }

    public function getRelatedModel()
    {
        $entityName = 'RelatedEntity' . $this->owner->entity;
        return $this->owner->$entityName;
    }
}