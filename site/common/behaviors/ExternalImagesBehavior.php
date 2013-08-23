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
            try {
                $doc = phpQuery::newDocumentXHTML($this->owner->$attr, 'utf-8');
            } catch (Exception $e) {
                $tidy_config = array(
                    'show-body-only' => true,
                );
                $tidy = tidy_repair_string($this->owner->$attr, $tidy_config, 'utf8');
                $doc = phpQuery::newDocumentXHTML($tidy, 'utf-8');
            }

            foreach (pq('img') as $e) {
                $src = pq($e)->attr('src');
                $element = null;
                if (strpos($src, Yii::app()->params['photos_url']) !== 0 && strpos($src, '/') !== 0) {
                    if (isset($this->owner->author_id))
                        $author_id = $this->owner->author_id;
                    elseif (isset($this->owner->content) && isset($this->owner->content->author_id))
                        $author_id = $this->owner->content->author_id; else
                        $author_id = Yii::app()->user->id;

                    $photo = AlbumPhoto::createByUrl($src, $author_id, 2);
                    if ($photo !== false) {
                        $newSrc = $photo->getPreviewUrl(700, 700, Image::WIDTH);
                        pq($e)->attr('src', $newSrc);
                        $element = pq($e);
                        Yii::log(
                            'Image was replaced' . "\n" .
                            '------------------------------' . "\n" .
                            'Old image: ' . $src . "\n" .
                            'New image: ' . $newSrc . "\n" .
                            'Entity: ' . get_class($this->owner) . "\n" .
                            'Entity id: ' . $this->owner->id . "\n" .
                            '------------------------------' . "\n"
                            , 'warning');
                    } else {
                        pq($e)->remove();
                        Yii::log(
                            'Image was deleted' . "\n" .
                            '------------------------------' . "\n" .
                            'Old image: ' . $src . "\n" .
                            'Entity: ' . get_class($this->owner) . "\n" .
                            'Entity id: ' . $this->owner->id . "\n" .
                            '------------------------------' . "\n"
                            , 'warning');
                    }
                } else {
                    //если ссылки на фотки с http://img.happy-giraffe.ru/
                    $photo = AlbumPhoto::getPhotoFromUrl($src);
                    if (count(pq($e)->parent()->children()) == 1)
                        $element = pq($e)->parent();
                    else
                        $element = pq($e);
                }

                if ($photo && $element) {
                    //если не смайл добавляем <--widget-->
                    if (strstr($src, '/images/widget/smiles/') === FALSE)
                        pq($element)->replaceWith(Yii::app()->controller->renderFile(Yii::getPathOfAlias('site.frontend.views.albums._widget') . '.php', array(
                            'model' => $photo,
                            'comments' => (get_class($this->owner) == 'Comment') ? true : false
                        ), true));
                }
            }

            $externalLinksCount = 0;

            //чтобы работало из консоли
            if (isset($_SERVER['HTTP_HOST']))
                foreach (pq('a') as $e) {
                    $href = pq($e)->attr('href');
                    if (strpos($href, $_SERVER['HTTP_HOST']) === false && strpos($href, '/') !== 0)
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

            $this->owner->$attr = $doc->html();
            $doc->unloadDocument();
        }

        parent::beforeSave($event);
    }
}
