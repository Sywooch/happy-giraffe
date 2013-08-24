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
        require Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

        $attributes = array_keys($this->owner->getAttributes($this->attributes));
        foreach ($attributes as $attr) {
            $doc = str_get_html($this->owner->$attr);

            foreach ($doc->find('img') as $image) {
                $element = null;
                if (strpos($image->src, Yii::app()->params['photos_url']) !== 0 && strpos($image->src, '/') !== 0) {
                    if (isset($this->owner->author_id))
                        $author_id = $this->owner->author_id;
                    elseif (isset($this->owner->content) && isset($this->owner->content->author_id))
                        $author_id = $this->owner->content->author_id; else
                        $author_id = Yii::app()->user->id;

                    $photo = AlbumPhoto::createByUrl($image->src, $author_id, 2);
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
                    //если ссылки на фотки с http://img.happy-giraffe.ru/
                    $photo = AlbumPhoto::getPhotoFromUrl($image->src);
                    $element = $image;
                }

                if ($photo && $element) {
                    //если не смайл добавляем <--widget-->
                    if (strstr($image->src, '/images/widget/smiles/') === FALSE)
                        $element->outertext = Yii::app()->controller->renderFile(Yii::getPathOfAlias('site.frontend.views.albums._widget') . '.php', array(
                            'model' => $photo,
                            'comments' => (get_class($this->owner) == 'Comment') ? true : false
                        ), true);
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

        parent::beforeSave($event);
    }
}
