<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/15/12
 * Time: 4:08 PM
 */
class ProcessingImagesBehavior extends CActiveRecordBehavior
{
    public $attributes = true;
    public $searchPreviewPhoto = false;

    private $first_big_photo;
    private $preview_photo;

    public function afterSave($event)
    {
        $entity = get_class($this->owner);
        if ($entity == 'BlogContent')
            $entity = 'CommunityContent';
        $entity_id = $this->owner->id;

        foreach($this->owner->processed_photos as $photo)
            AttachPhoto::add($photo, $entity, $entity_id);

        parent::afterSave($event);
    }

    public function beforeSave($event)
    {
        include_once Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

        $attributes = array_keys($this->owner->getAttributes($this->attributes));
        foreach ($attributes as $attr) {
            if (strpos($this->owner->$attr, '<!-- widget') !== false)
                return parent::beforeSave($event);

            $doc = str_get_html($this->owner->$attr);

            $num = 1;
            foreach ($doc->find('img') as $image) {
                $element = null;
                for($i=1;$i<10;$i++)
                    $image->src = str_replace('http://img' . $i . '.happy-giraffe.ru/', 'http://img.happy-giraffe.ru/', $image->src);

                if (strpos($image->src, Yii::app()->params['photos_url']) !== 0 && strpos($image->src, '/') !== 0) {
                    if (isset($this->owner->author_id))
                        $author_id = $this->owner->author_id;
                    elseif (isset($this->owner->content) && isset($this->owner->content->author_id))
                        $author_id = $this->owner->content->author_id; else
                        $author_id = Yii::app()->user->id;

                    $photo = AlbumPhoto::createByUrl($image->src, $author_id, 2, isset($this->owner->content) ? $this->owner->content->title . ' фото ' . $num : null);
                    if ($photo !== false) {
                        $newSrc = $photo->getPreviewUrl(700, 700, Image::WIDTH);
                        $image->src = $newSrc;
                        $element = $image;
                        Yii::log(
                            'Image was replaced' . "\n" .
                            '------------------------------' . "\n" .
                            'Old image: ' . $image->src . "\n" .
                            'New image: ' . $newSrc . "\n" .
                            'Entity: ' . get_class($this->owner) . "\n" .
                            'Entity id: ' . $this->owner->id . "\n" .
                            '------------------------------' . "\n"
                            , 'warning');
                        $num++;
                    } else {
                        $image->outertext = '';
                        Yii::log(
                            'Image was deleted' . "\n" .
                            '------------------------------' . "\n" .
                            'Old image: ' . $image->src . "\n" .
                            'Entity: ' . get_class($this->owner) . "\n" .
                            'Entity id: ' . $this->owner->id . "\n" .
                            '------------------------------' . "\n"
                            , 'warning');
                    }
                } else {
                    #TODO когда удаляешь фото нумерация картинок сбивается
                    //если ссылки на фотки с http://img.happy-giraffe.ru/
                    $photo = AlbumPhoto::getPhotoFromUrl($image->src);
                    if ($photo && empty($photo->title) && isset($this->owner->content)) {
                        $photo->title = $this->owner->content->title . ' фото ' . $num;
                        $photo->save(false);
                    }
                    $element = $image;
                }

                if ($photo){
                    $num++;
                    $this->owner->processed_photos [] = $photo;
                }

                //выбор фото для превью
                if ($this->searchPreviewPhoto && $photo) {
                    if (empty($this->first_big_photo) && $photo->width >= 580)
                        $this->first_big_photo = $photo;
                    if (empty($this->preview_photo))
                        $this->preview_photo = $photo;
                }

                if ($element && in_array(get_class($this->owner), array('Comment', 'MessagingMessage'))){
                    $parent = $element->parent();
                    if ($parent && $parent->tag == 'a')
                        $element = $parent;
                }

                if (isset($photo) && $photo && $element) {
                    //если не смайл добавляем <--widget-->
                    if (strstr($image->src, '/images/widget/smiles/') === FALSE) {
                        if (isset(Yii::app()->controller))
                            $controller = Yii::app()->controller;
                        else
                            $controller = new CController('YiiC');
                        $element->outertext = $controller->renderInternal(Yii::getPathOfAlias('site.frontend.views.albums._widget') . '.php', array(
                            'model' => $photo,
                            'comments' => (get_class($this->owner) == 'Comment') ? true : false,
                            'parentModel' => $this->owner,
                        ), true);
                    }
                }
            }

            $externalLinksCount = 0;

            //чтобы работало из консоли
            if (isset($_SERVER['HTTP_HOST']))
                foreach ($doc->find('a') as $link) {
                    if (strpos($link->href, $_SERVER['HTTP_HOST']) === false && strpos($link->href, '/') !== 0)
                        $externalLinksCount++;
                }

            if ($externalLinksCount > 2) {
                $entity = in_array(get_class($this->owner), array('CommunityPost', 'CommunityVideo')) ? $this->owner->content : $this->owner;

                $report = new Report;
                $report->type = 0;
                $report->text = 'Наличие более 2-х внешних ссылок';
                $report->breaker_id = $entity->author_id;
                $report->entity = get_class($entity);
                $report->entity_id = $entity->id;
                $report->path = $entity->url;
                $report->save();
            }

            $this->owner->$attr = $doc->save();
        }

        if ($this->searchPreviewPhoto) {
            if (!empty($this->first_big_photo))
                $this->owner->photo_id = $this->first_big_photo->id;
            elseif (!empty($this->preview_photo))
                $this->owner->photo_id = $this->preview_photo->id; else
                $this->owner->photo_id = null;
        }

        parent::beforeSave($event);
    }
}
