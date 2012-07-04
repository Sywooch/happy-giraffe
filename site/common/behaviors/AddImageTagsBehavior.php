<?php
/**
 * Author: alexk984
 * Date: 04.07.2012
 */
class AddImageTagsBehavior extends CActiveRecordBehavior
{
    public function addTags()
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');

        $doc = phpQuery::newDocumentXHTML($this->owner->text, $charset = 'utf-8');
        $i = 0;
        foreach (pq('img') as $image) {
            $alt = pq($image)->attr('alt');
            $title = pq($image)->attr('title');

            if (empty($alt) || empty($title)){
                $i++;

                if (empty($alt))
                    pq($image)->attr('alt', $this->owner->content->title.' фото '.$i);

                if (empty($title))
                    pq($image)->attr('title', $this->owner->content->title.' фото '.$i);
            }
        }
        $this->owner->text = $doc->html();
    }

    public function attach($owner)
    {
        parent::attach($owner);

        $owner->attachEventHandler('onBeforeSave', array($this, 'addTags'));
    }

    public function detach($owner)
    {
        parent::detach($owner);

        $owner->detachEventHandler('onBeforeSave', array($this, 'addTags'));
    }
}
