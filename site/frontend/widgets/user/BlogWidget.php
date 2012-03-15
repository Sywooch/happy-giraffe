<?php
/**
 * Author: alexk984
 * Date: 01.03.12
 */
class BlogWidget extends UserCoreWidget
{
    public $articles;
    public $count;

    public function init()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('type_id', 1);
        $criteria->order = 't.id desc';
        $criteria->limit = 4;
        $this->count = CommunityContent::model()->count($criteria);

        if ($this->count == 0){
            $this->visible = false;
        }else{
            $this->articles = CommunityContent::model()->full()->findAll($criteria);
            $this->visible = true;
        }
        parent::init();
    }
}