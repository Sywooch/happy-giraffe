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
        if ($this->owner->type_id == \CommunityContent::TYPE_POST) {
            $advContent = \site\frontend\modules\editorialDepartment\models\Content::model()->findByAttributes(array(
                'entity' => $this->owner->getIsFromBlog() ? 'BlogContent' : 'CommunityContent',
                'entityId' => (int) $this->owner->id
            ));
            if (!is_null($advContent)) {
                return $this->convertAdvPost($advContent);
            } else {
                return $this->convertPost();
            }
        } elseif ($this->owner->type_id == \CommunityContent::TYPE_PHOTO_POST)
            return $this->convertPhotoPost();
        elseif ($this->owner->type_id == \CommunityContent::TYPE_VIDEO)
            return $this->convertVideoPost();
        elseif ($this->owner->type_id == \CommunityContent::TYPE_STATUS)
            return $this->convertStatus();
        elseif ($this->owner->type_id == \CommunityContent::TYPE_QUESTION)
            return $this->convertQuestion();
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
        if($oldPost->isFromBlog) {
            $tags[] = 'Блог';
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
        $newPost->isNoindex = is_numeric($oldPost->uniqueness) && $oldPost->uniqueness < 50;
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

    protected function convertAdvPost(\site\frontend\modules\editorialDepartment\models\Content $advContent)
    {
        $newPost = null;
        $oldPost = null;
        $this->convertCommon($oldPost, $newPost, 'advPost');
        $newPost->preview = $advContent->htmlTextPreview;
        $newPost->html = $advContent->htmlText;
        $newPost->templateObject->data['type'] = 'advPost';
        $newPost->isNoindex = false;
        
        return $newPost->save();
    }

    protected function convertQuestion()
    {
        $newPost = null;
        $oldPost = null;
        $this->convertCommon($oldPost, $newPost, 'oldQuestion');

        $newPost->templateObject->data['type'] = 'question';
        $oldPost->question->purified->clearCache();
        $newPost->html = $oldPost->question->purified->text;
        $newPost->text = $oldPost->question->text;
        $clearText = $newPost->fillText();
        $newPost->isNoindex = $newPost->isNoindex ? true : !\site\common\helpers\UniquenessChecker::checkBeforeTest($oldPost->author_id, $clearText);
        $newPost->preview = '<p>' . \site\common\helpers\HStr::truncate($clearText, 200, ' <a class="ico-more" href="' . $oldPost->url . '"></a>') . '</p>';

        if (empty($newPost->metaObject->description))
            $newPost->metaObject->description = trim(preg_replace('~\s+~', ' ', strip_tags($oldPost->question->text)));

        return $newPost->save();
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

        $newPost->preview = '<p>' . \site\common\helpers\HStr::truncate($clearText, 200, ' <a class="ico-more" href="' . $oldPost->url . '"></a>') . '</p>';
        if ($oldPost->gallery) {
            // Скопировано из convertPhotoPost
            $collection = \site\frontend\modules\photo\components\MigrateManager::syncPhotoPostCollection($oldPost);
            $count = $collection->attachesCount;
            $cover = \Yii::app()->thumbs->getThumb($collection->cover->photo, 'postCollectionCover');
            $url = $collection->observer->getSingle(0)->getUrl();

            $photoAlbumTag = '<div class="b-album-cap">'
                    . '<div class="b-album-cap_hold">'
                        . '<div class="b-album">'
                            . '<a class="b-album_img-hold" href="' . $url . '" title="Начать просмотр">'
                                . '<div class="b-album-img_a">'
                                    . '<div class="b-album_img-pad"></div>'
                                    . '<img width="' . $cover->getWidth() . '" height="' . $cover->getHeight() . '" class="b-album_img-big" alt="'
                                    . $collection->cover->photo->title . '" src="' . $cover->getUrl() . '">'
                                . '</div>'
                                . '<div class="b-album_img-hold-ovr">'
                                    . '<div class="ico-zoom ico-zoom__abs"></div>'
                                . '</div>'
                            . '</a>'
                        . '</div>'
                    . '</div>'
                    . \CHtml::tag('photo-collection', array(
                        'params' =>
                        'id: ' . (int) $collection->id . ', ' .
                        'attachCount: ' . (int) $count . ', ' .
                        'userId: ' . (int) $newPost->authorId . ', ' .
                        'coverId: ' . $collection->cover->id,
                            ), '') . '</div>';

            $newPost->html .= $photoAlbumTag;
            $newPost->preview = $this->render('site.frontend.modules.posts.behaviors.converters.views.photopostPreview', array('tag' => $photoAlbumTag, 'text' => \site\common\helpers\HStr::truncate(trim(preg_replace('~\s+~', ' ', strip_tags($newPost->text))), 200, ' <span class="ico-more"></span>')));
            $newPost->socialObject->imageUrl = \Yii::app()->thumbs->getThumb($collection->cover->photo, 'socialImage')->getUrl();
        } elseif ($photo) {
            $newPost->preview = '<div class="b-article_in-img"><a href="' . $oldPost->url . '">' . $photo->getPreviewHtml(600, 1100) . '</a></div>' . $newPost->preview;
            $newPost->socialObject->imageUrl = $photo->getPreviewUrl(200, 200);
        }

        if (empty($newPost->metaObject->description))
            $newPost->metaObject->description = trim(preg_replace('~\s+~', ' ', strip_tags($oldPost->post->text)));

        return $newPost->save();
    }

    protected function convertPhotoPost()
    {
        $newPost = null;
        $oldPost = null;
        $this->convertCommon($oldPost, $newPost, 'oldPhotoPost');

        $newPost->templateObject->data['type'] = 'photoPost';
        $newPost->templateObject->data['noWysiwyg'] = true;
        $collection = \site\frontend\modules\photo\components\MigrateManager::syncPhotoPostCollection($oldPost);
        $count = $collection->attachesCount;
        $cover = \Yii::app()->thumbs->getThumb($collection->cover->photo, 'postCollectionCover');
        $url = $collection->observer->getSingle(0)->getUrl();

        $photoAlbumTag = '<div class="b-album-cap">'
                . '<div class="b-album-cap_hold">'
                    . '<div class="b-album">'
                        . '<a class="b-album_img-hold" href="' . $url . '" title="Начать просмотр">'
                            . '<div class="b-album-img_a">'
                                . '<div class="b-album_img-pad"></div>'
                                . '<img width="' . $cover->getWidth() . '" height="' . $cover->getHeight() . '" class="b-album_img-big" alt="'
                                . $collection->cover->photo->title . '" src="' . $cover->getUrl() . '">'
                            . '</div>'
                            . '<div class="b-album_img-hold-ovr">'
                                . '<div class="ico-zoom ico-zoom__abs"></div>'
                            . '</div>'
                        . '</a>'
                    . '</div>'
                . '</div>'
                . \CHtml::tag('photo-collection', array(
                    'params' =>
                    'id: ' . (int) $collection->id . ', ' .
                    'attachCount: ' . (int) $count . ', ' .
                    'userId: ' . (int) $newPost->authorId . ', ' .
                    'coverId: ' . $collection->cover->id,
                        ), '') . '</div>';

        $newPost->text = $oldPost->photoPost->text;
        $newPost->html = $this->render('site.frontend.modules.posts.behaviors.converters.views.photopost', array('tag' => $photoAlbumTag, 'text' => nl2br($oldPost->photoPost->text)));
        $newPost->preview = $this->render('site.frontend.modules.posts.behaviors.converters.views.photopostPreview', array('tag' => $photoAlbumTag, 'text' => str_replace("\n", "\n ", \site\common\helpers\HStr::truncate(trim(preg_replace('~\s+~', ' ', strip_tags($oldPost->photoPost->text))), 200, ' <span class="ico-more"></span>'))));
        $newPost->socialObject->imageUrl = \Yii::app()->thumbs->getThumb($collection->cover->photo, 'socialImage')->getUrl();
        $newPost->isNoindex = false;

        if (empty($newPost->metaObject->description))
            $newPost->metaObject->description = trim(preg_replace('~\s+~', ' ', strip_tags($oldPost->photoPost->text)));

        return $newPost->save();
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

        return $newPost->save();
    }

    protected function convertStatus()
    {
        $newPost = null;
        $oldPost = null;
        $this->convertCommon($oldPost, $newPost, 'oldStatusPost');

        $newPost->templateObject->data['type'] = 'status';
        $newPost->templateObject->data['noWysiwyg'] = true;
        $newPost->templateObject->data['hideTitle'] = true;
        $newPost->isNoindex = true;

        $newPost->title = $oldPost->author->fullName . ' - статус от ' . date('d.m.y h:i', $newPost->dtimeCreate);
        $newPost->html = $this->render('site.frontend.modules.posts.behaviors.converters.views.status', array('content' => $oldPost));
        $newPost->text = strip_tags($oldPost->status->text);
        $newPost->preview = $this->render('site.frontend.modules.posts.behaviors.converters.views.statusPreview', array('content' => $oldPost));

        if (empty($newPost->metaObject->description))
            $newPost->metaObject->description = trim(preg_replace('~\s+~', ' ', strip_tags($oldPost->status->text)));

        return $newPost->save();
    }

    protected function render($file, $data)
    {
        $file = \Yii::getPathOfAlias($file) . '.php';
        if (\Yii::app() instanceof \CConsoleApplication) {
            return \Yii::app()->command->renderFile($file, $data, true);
        } else {
            return \Yii::app()->controller->renderInternal($file, $data, true);
        }
    }

}

?>
