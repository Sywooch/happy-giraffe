<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/15/12
 * Time: 4:08 PM
 * To change this template use File | Settings | File Templates.
 */
class ExternalImagesBehavior extends CActiveRecordBehavior
{
    public $attributes = true;

    public function beforeSave($event)
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');

        $attributes = array_keys($this->owner->getAttributes($this->attributes));
        foreach ($attributes as $attr) {
            $doc = phpQuery::newDocumentXHTML($this->owner->$attr, $charset = 'utf-8');

            foreach (pq('img') as $e) {
                $src = pq($e)->attr('src');
                if (strpos($src, $_SERVER['HTTP_HOST']) === FALSE) {
                    $photo = AlbumPhoto::createByUrl($src, Yii::app()->user->id, 2);
                    if ($photo !== false) {
                        $newSrc = $photo->getPreviewUrl(700, 700, Image::WIDTH);
                        pq($e)->attr('src', $newSrc);
                        Yii::log(
                            'Image was replaced' . "\n" .
                            '------------------------------' . "\n" .
                            'Old image: ' . $src . "\n" .
                            'New image: ' . $newSrc . "\n" .
                            'Entity: ' . get_class($this->owner) . "\n" .
                            'Entity id: ' . $this->owner->id ."\n" .
                            '------------------------------' . "\n"
                        , 'warning');
                    } else {
                        pq($e)->remove();
                        Yii::log(
                            'Image was deleted' . "\n" .
                                '------------------------------' . "\n" .
                                'Old image: ' . $src . "\n" .
                                'Entity: ' . get_class($this->owner) . "\n" .
                                'Entity id: ' . $this->owner->id ."\n" .
                                '------------------------------' . "\n"
                        , 'warning');
                    }
                }
            }

            $this->owner->$attr = $doc->html();
            $doc->unloadDocument();
        }

        parent::beforeSave($event);
    }
}
