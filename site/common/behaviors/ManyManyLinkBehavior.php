<?php

class ManyManyLinkBehavior extends CActiveRecordBehavior
{
    public function link($relation, $fk)
    {
        /*$md = $this->owner->getMetaData();
        if(!isset($md->owner->relations[$relation]))
            throw new CDbException(Yii::t('yii','{class} does not have relation "{name}".',
                array('{class}'=>get_class($this), '{name}'=>$relation)));
        if($this->relation instanceof CManyManyRelation)
            throw
        */
    }

    public function unlink($relation, $fk)
    {

    }

    public function isLinked($relation, $fk)
    {

    }
}
