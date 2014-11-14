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

    public function events()
    {
        return array_merge(parent::events(), array(
            'onAfterSoftDelete' => 'afterSoftDelete',
            'onAfterSoftRestore' => 'afterSoftRestore',
        ));
    }

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

    public function afterSoftDelete($event)
    {
        $this->addTaskToConvert();
    }

    public function afterSoftRestore($event)
    {
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
        $oldPost->purified->clearCache();
        $service = $oldPost->isFromBlog ? 'oldBlog' : 'oldCommunity';
        $entity = get_class($oldPost);
        $id = $oldPost->id;

        $tags = array();
        $rubric = $oldPost->rubric;
        while ($rubric) {
            $tags[] = 'Рубрика: ' . $rubric->title;
            $rubric = $rubric->parent;
        }
        if ($oldPost->rubric->community) {
            $tags[] = 'Форум: ' . $oldPost->rubric->community->title;
            if ($oldPost->rubric->community->club)
                $tags[] = 'Клуб: ' . $oldPost->rubric->community->club->title;
            if ($oldPost->rubric->community->club && $oldPost->rubric->community->club->section)
                $tags[] = 'Секция: ' . $oldPost->rubric->community->club->section->title;
        }

        $newPost = \site\frontend\modules\posts\models\Content::model()->resetScope()->findByAttributes(array(
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
        $newPost = null;
        $oldPost = null;
        $this->convertCommon($oldPost, $newPost, 'oldPost');

        $newPost->templateObject->data['type'] = 'post';
        $oldPost->post->purified->clearCache();
        $newPost->html = $oldPost->post->purified->text;
        $newPost->text = $oldPost->post->text;
        $clearText = $newPost->fillText();
        $newPost->isNoindex = $newPost->isNoindex ? true : !\site\common\helpers\UniquenessChecker::checkBeforeTest($oldPost->author_id, $clearText);
        $photo = $oldPost->post->photo;

        $newPost->preview = '<p>' . \site\common\helpers\HStr::truncate($clearText, 200, ' <span class="ico-more"></span>') . '</p>';
        if ($photo) {
            $newPost->preview = '<div class="b-article_in-img">' . $photo->getPreviewHtml(600, 1100) . '</div>' . $newPost->preview;
            $newPost->socialObject->imageUrl = $photo->getPreviewUrl(200, 200);
        }

        if (empty($newPost->metaObject->description))
            $newPost->metaObject->description = trim(preg_replace('~\s+~', ' ', strip_tags($oldPost->post->text)));

        $newPost->save();
    }

    protected function convertPhotoPost()
    {
        $newPost = null;
        $oldPost = null;
        $this->convertCommon($oldPost, $newPost, 'oldPhotoPost');

        $newPost->templateObject->data['type'] = 'photoPost';
        $collection = \site\frontend\modules\photo\components\MigrateManager::syncPhotoPostCollection($oldPost);
        $count = $collection->attachesCount;
        $cover = \Yii::app()->thumbs->getThumb($collection->cover->photo, 'myPhotosAlbumCover')->getUrl();
        $url = $collection->observer->getSingle(0)->getUrl();
        $photoAlbumTag = \CHtml::tag('photo-collection', array(
            'params' =>
                'id: ' . (int) $collection->id . ', ' .
                'attachCount: ' . (int) $count . ', ' .
                'userId: ' . (int) $newPost->authorId . ', ' .
                'title: ' . htmlspecialchars($newPost->title) . ', ' .
                'coverId: ' . $collection->cover->photo->id,
            ), '<a href="' . $url . '" title="Начать просмотр"><div class="b-album_img-hold"><div class="b-album_img-a"><div class="b-album_img-picture"><img class="b-album_img-big" alt="' . $collection->cover->photo->title . '" src="' . $cover . '"></div><div class="b-album_count-hold b-album_count-hold__in"><div class="b-album_count">' . $count . '</div><div class="b-album_count-tx">фото</div></div><div class="b-album_img-pad"></div></div></div></a>');

        $newPost->html = $photoAlbumTag . $oldPost->photoPost->text;
        $newPost->text = $oldPost->photoPost->text;
        $newPost->preview = $photoAlbumTag . '<p>' . \site\common\helpers\HStr::truncate(trim(preg_replace('~\s+~', ' ', strip_tags($oldPost->photoPost->text))), 200, ' <span class="ico-more"></span>') . '</p>';
        $newPost->socialObject->imageUrl = \Yii::app()->thumbs->getThumb($collection->cover->photo, 'socialImage')->getUrl();
        $newPost->isNoindex = false;

        if (empty($newPost->metaObject->description))
            $newPost->metaObject->description = trim(preg_replace('~\s+~', ' ', strip_tags($oldPost->photoPost->text)));

        $newPost->save();
    }

    protected function convertVideoPost()
    {
        $newPost = null;
        $oldPost = null;
        $this->convertCommon($oldPost, $newPost, 'oldVideoPost');

        $newPost->templateObject->data['type'] = 'videoPost';
        $newPost->html = $this->render('site.frontend.modules.posts.behaviors.converters.views.video', array('content' => $oldPost, 'text' => $oldPost->video->text));
        $newPost->text = strip_tags($oldPost->video->text);
        $newPost->preview = $this->render('site.frontend.modules.posts.behaviors.converters.views.video', array('content' => $oldPost, 'text' => '<p>' . \site\common\helpers\HStr::truncate($newPost->text, 200, ' <span class="ico-more"></span>') . '</p>'));
        $newPost->isNoindex = false;

        if (empty($newPost->metaObject->description))
            $newPost->metaObject->description = trim(preg_replace('~\s+~', ' ', strip_tags($oldPost->video->text)));

        $newPost->save();
    }

    protected function convertStatus()
    {
        $newPost = null;
        $oldPost = null;
        $this->convertCommon($oldPost, $newPost, 'oldStatusPost');

        $newPost->templateObject->data['type'] = 'status';
        $newPost->isNoindex = true;

        $newPost->title = $oldPost->author->fullName . ' - статус от ' . date('d.m.y h:i', $newPost->dtimeCreate);
        $newPost->html = $this->render('site.frontend.modules.posts.behaviors.converters.views.status', array('content' => $oldPost));
        $newPost->text = strip_tags($oldPost->status->text);
        $newPost->preview = $this->render('site.frontend.modules.posts.behaviors.converters.views.statusPreview', array('content' => $oldPost));

        if (empty($newPost->metaObject->description))
            $newPost->metaObject->description = trim(preg_replace('~\s+~', ' ', strip_tags($oldPost->status->text)));

        $newPost->save();
    }

    protected function render($file, $data)
    {
        $file = \Yii::getPathOfAlias($file) . '.php';
        if (\Yii::app() instanceof \CConsoleApplication) {
            return \Yii::app()->command->renderFile($file, $data, true);
        }
        else {
            return \Yii::app()->controller->renderInternal($file, $data, true);
        }
    }

}

?>
