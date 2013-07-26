<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 7/9/13
 * Time: 10:44 AM
 * To change this template use File | Settings | File Templates.
 */

class CookDecorPhotoCollection extends PhotoCollection
{
    protected function generateIds()
    {
        return Yii::app()->db->createCommand('SELECT photo_id FROM cook__decorations ORDER BY created DESC')->queryColumn();
    }

    protected function getIdsCacheDependency()
    {
        return new CDbCacheDependency('SELECT COUNT(*) FROM cook__decorations');
    }

    protected function populatePhotos($ids)
    {
        $criteria = new CDbCriteria(array(
            'index' => 'id',
            'with' => array(
                'photo' => array(
                    'with' => array('author'),
                ),
            ),
            'order' => new CDbExpression('FIELD(t.photo_id, ' . implode(',', $ids) . ')')
        ));
        $criteria->addInCondition('t.photo_id', $ids);
        $decorations = CookDecoration::model()->findAll($criteria);
        $results = array();
        foreach ($decorations as $d)
            $results[] = $this->populatePhoto($d);

        return $results;
    }

    protected function populatePhoto($decoration)
    {
        return array(
            'id' => $decoration->photo_id,
            'title' => $decoration->title,
            'description' => $decoration->description,
            'src' => $decoration->photo->getPreviewUrl(804, null, Image::WIDTH),
            'date' => HDate::GetFormattedTime($decoration->created),
            'user' => array(
                'id' => $decoration->photo->author->id,
                'firstName' => $decoration->photo->author->first_name,
                'lastName' => $decoration->photo->author->last_name,
                'gender' => $decoration->photo->author->gender,
                'ava' => $decoration->photo->author->getAva('small'),
                'url' => $decoration->photo->author->url,
            ),
        );
    }
}