<?php

namespace site\frontend\modules\som\modules\idea\behaviors;

use \site\frontend\modules\som\modules\community\models\api\Label;
use \site\frontend\modules\posts\models\api\Content;

class ConvertBehavior extends \CActiveRecordBehavior
{

    public function events()
    {
        return array_merge(parent::events(), array(
            'onAfterSoftDelete' => 'afterSoftDelete',
            'onAfterSoftRestore' => 'afterSoftRestore',
        ));
    }

    public function getPost($entity)
    {
        try {
            $post = Content::model()->query('getByAttributes', array(
                'entity' => $entity,
                'entityId' => $this->owner->id,
            ));
        } catch (\Exception $e) {
            $post = false;
        }

        if (!$post) {
            $post = new Content();
        }
        return $post;
    }

    public function afterSoftDelete($event)
    {
        $entity = array_search(get_class($this->owner), \site\frontend\modules\posts\models\Content::$entityAliases);
        $post = $this->getPost($entity);
        $post->isRemoved = true;
        $post->save();
    }

    public function afterSoftRestore($event)
    {
        $entity = array_search(get_class($this->owner), \site\frontend\modules\posts\models\Content::$entityAliases);
        $post = $this->getPost($entity);
        $post->isRemoved = false;
        $post->save();
    }

    public function afterSave()
    {
        $entity = array_search(get_class($this->owner), \site\frontend\modules\posts\models\Content::$entityAliases);

        $labels = $this->owner->labels;
            //is_null($this->owner->forumId) ? Label::model()->findForBlog() : Label::model()->findByForum($this->owner->forumId);

        $post = $this->getPost($entity);
        $post->url = $this->owner->getUrl(false);
        $post->authorId = (int) $this->owner->authorId;
        $post->dtimeCreate = (int) $this->owner->dtimeCreate;
        $post->dtimePublication = (int) $post->dtimeCreate;
        $post->dtimeUpdate = time();
        $post->isRemoved = (int) $this->owner->isRemoved;
        $post->isDraft = (int) $this->owner->isDraft;
        $post->title = htmlspecialchars(trim($this->owner->title));
        $post->text = '';
        $post->preview = $this->getPhotopostTag();
        $post->html = $post->preview;
        $post->labels = array_map(function($labelModel) {
            return $labelModel->text;
        }, $labels);
        $post->originEntity = $entity;
        $post->originEntityId = (int) $this->owner->id;
        $post->originService = 'idea';

        $post->template = array(
            'layout' => $this->owner->forumId ? 'newCommunityPost' : 'newBlogPost',
            'data' => array(
                'type' => 'photoPost',
                'noWysiwyg' => true,
            ),
        );
        $post->originManageInfo = array(
            'params' => array(
                'edit' => array(
                    'link' => array(
                        'url' => '/post/edit/photopost' . $this->owner->id . '/',
                    )
                ),
                'remove' => array(
                    'api' => array(
                        'url' => '/api/photopost/remove/',
                        'params' => array(
                            'id' => (int) $this->owner->id,
                        ),
                    ),
                ),
                'restore' => array(
                    'api' => array(
                        'url' => '/api/photopost/restore/',
                        'params' => array(
                            'id' => (int) $this->owner->id,
                        ),
                    ),
                ),
            ),
        );
        $post->isAutoMeta = true;
        $post->meta = array(
            'description' => '',
            'title' => $post->title,
        );

        $post->social = array(
            'description' => $post->meta['description'],
        );

        $post->save();
    }

    public function getIdeaTag()
    {
        try {
            $collection = \site\frontend\modules\photo\models\api\Collection::model()->findByPk($this->owner->collectionId);
            $cover = new \site\frontend\modules\photo\models\Photo();
            $cover->fromJSON($collection->cover['photo']);
            $thumb = \Yii::app()->thumbs->getThumb($cover, 'postCollectionCover');
            $photoAlbumTag = '<div class="b-album-cap">'
                . '<div class="b-album-cap_hold">'
                . '<div class="b-album">'
                . '<a class="b-album_img-hold" href="' . $this->owner->getUrl() . '" title="Начать просмотр">'
                . '<div class="b-album-img_a">'
                . '<div class="b-album_img-pad"></div>'
                . '<img width="' . $thumb->getWidth() . '" height="' . $thumb->getHeight() . '" class="b-album_img-big" alt="'
                . $cover->title . '" src="' . $thumb->getUrl() . '">'
                . '</div>'
                . '<div class="b-album_img-hold-ovr">'
                . '<div class="ico-zoom ico-zoom__abs"></div>'
                . '</div>'
                . '</a>'
                . '</div>'
                . '</div>'
                . \CHtml::tag('photo-collection', array(
                    'params' =>
                        'originalUrl: "' . $this->owner->getUrl() . '", ' .
                        'id: ' . (int) $collection->id . ', ' .
                        'attachCount: ' . (int) $collection->attachesCount . ', ' .
                        'userId: ' . (int) $this->owner->authorId . ', ' .
                        'coverId: ' . (int) $collection->cover['id'],
                ), '') . '</div>';
            return $photoAlbumTag;
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
