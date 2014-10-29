<?php

namespace site\frontend\modules\posts\behaviors\converters;

/**
 * Description of CommunityContentBehavior
 *
 * @author Кирилл
 * @property \CommunityContent $owner Description
 */
class CommunityContentBehavior extends \CActiveRecordBehavior
{

    public function convertToNewPost()
    {
        if ($this->owner->type_id == \CommunityContent::TYPE_POST)
            $this->convertPost();
        elseif ($this->owner->type_id == \CommunityContent::TYPE_PHOTO_POST)
            $this->convertPhotoPost();
        elseif ($this->owner->type_id == \CommunityContent::TYPE_VIDEO)
            $this->convertVideoPost();
        elseif ($this->owner->type_id == \CommunityContent::TYPE_STATUS)
            $this->convertStatus();
    }

    public function afterSave($event)
    {
        parent::afterSave($event);
        $this->addTaskToConvert();
    }

    public function addTaskToConvert()
    {
        if (!\site\frontend\modules\posts\commands\ConvertCommand::addConvertTask($this->owner))
            $this->convertToNewPost();
    }

    protected function convertCommon(&$oldPost, &$newPost, $scenario)
    {
        $oldPost = $this->owner;
        $service = $oldPost->isFromBlog ? 'oldBlog' : 'oldCommunity';
        $entity = get_class($oldPost);
        $id = $oldPost->id;

        $tags = array();
        $rubric = $oldPost->rubric;
        while ($rubric)
        {
            $tags[] = 'Рубрика: ' . $rubric->title;
            $rubric = $rubric->parent;
        }
        if ($oldPost->rubric->community)
        {
            $tags[] = 'Форум: ' . $oldPost->rubric->community->title;
            if ($oldPost->rubric->community->club)
                $tags[] = 'Клуб: ' . $oldPost->rubric->community->club->title;
            if ($oldPost->rubric->community->club && $oldPost->rubric->community->club->section)
                $tags[] = 'Секция: ' . $oldPost->rubric->community->club->section->title;
        }

        $newPost = \site\frontend\modules\posts\models\Content::model()->findByAttributes(array(
            'originService' => $service,
            'originEntity' => $entity,
            'originEntityId' => $id,
        ));
        if (!$newPost)
            $newPost = new \site\frontend\modules\posts\models\Content('oldPost');

        $newPost->scenario = $scenario;

        $newPost->labelsArray = array_reverse($tags);
        $newPost->url = $oldPost->getUrl(false, true);
        $newPost->originService = $service;
        $newPost->originEntity = $entity;
        $newPost->originEntityId = $id;
        $newPost->authorId = $oldPost->author_id;
        $newPost->dtimeCreate = strtotime($oldPost->created);
        $newPost->dtimeUpdate = max($newPost->dtimeCreate, strtotime($oldPost->updated), strtotime($oldPost->last_updated));
        $newPost->dtimePublication = $newPost->dtimeCreate;
        $newPost->uniqueIndex = $oldPost->uniqueness;
        $newPost->isNoindex = is_int($oldPost->uniqueness) && !$oldPost->uniqueness > 50;
        $newPost->isNofollow = false;
        $newPost->isRemoved = $oldPost->removed;
        $newPost->isDraft = 0;
        $newPost->title = trim($oldPost->title);

        $newPost->templateObject->layout = $oldPost->isFromBlog ? 'newBlogPost' : 'newCommunityPost';
        $newPost->originManageInfoObject->link = array('url' => '/' . ($oldPost->isFromBlog ? 'blogs' : 'community') . '/edit/post', 'get' => array('id' => $oldPost->id));
        $newPost->isAutoMeta = $oldPost->meta_description ? false : true;
        $newPost->metaObject->description = $newPost->isAutoMeta ? $oldPost->meta_description_auto : $oldPost->meta_description;
        $newPost->metaObject->title = trim($oldPost->title);

        $newPost->socialObject->description = $newPost->metaObject->description;
        $newPost->isAutoSocial = true;
    }

    protected function convertPost()
    {
        //echo "post\n";
        $newPost = null;
        $oldPost = null;
        $this->convertCommon($oldPost, $newPost, 'oldPost');

        $newPost->html = $oldPost->post->text;
        $newPost->text = $oldPost->post->text;
        $photo = $oldPost->post->photo;

        if ($photo)
        {
            $newPost->preview = $oldPost->preview . '<div class="b-article_in-img">' . $photo->getPreviewHtml(580, 1100) . '</div>';
            $newPost->socialObject->imageUrl = $photo->getPreviewUrl();
        }
        else
        {
            $newPost->preview = $oldPost->preview;
        }

        $newPost->save();
    }

    protected function convertPhotoPost()
    {
        $newPost = null;
        $oldPost = null;
        $this->convertCommon($oldPost, $newPost, 'oldPhotoPost');

        $collection = \site\frontend\modules\photo\components\MigrateManager::syncPhotoPostCollection($oldPost);
        $count = $collection->attachesCount;
        $cover = \Yii::app()->thumbs->getThumb($collection->cover->photo, 'myPhotosAlbumCover')->getUrl();
        $photoAlbumTag = \CHtml::tag('photo-collection', array(
                'params' =>
                'id: ' . (int) $collection->id . ', ' .
                'attachCount: ' . (int) $count . ', ' .
                'coverId: ' . $collection->cover->photo->id,
                ), '<div class="b-album_img-hold"><div class="b-album_img-a"><div class="b-album_img-picture"><img class="b-album_img-big" alt="' . $collection->cover->photo->title . '" src="' . $cover . '"></div><div class="b-album_count-hold b-album_count-hold__in"><div class="b-album_count">' . $count . '</div><div class="b-album_count-tx">фото</div></div><div class="b-album_img-pad"></div></div></div>');

        $newPost->html = $photoAlbumTag . $oldPost->photoPost->text;
        $newPost->text = $oldPost->photoPost->text;
        $newPost->preview = $photoAlbumTag . \CHtml::tag('p', array('class' => 'wysiwyg-content clearfix'), $oldPost->preview . '<span class="ico-more"></span>');
        $newPost->socialObject->imageUrl = \Yii::app()->thumbs->getThumb($collection->cover->photo, 'uploadPreview')->getUrl();

        $newPost->save();
    }

    protected function convertVideoPost()
    {
        echo 'videopost';
    }

    protected function convertStatus()
    {
        echo 'status';
    }

}

?>
