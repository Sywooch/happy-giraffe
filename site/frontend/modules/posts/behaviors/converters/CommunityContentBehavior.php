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

    protected function convertPost()
    {
        echo "post\n";
        $oldPost = $this->owner;
        $service = $oldPost->isFromBlog ? 'oldBlog' : 'oldCommunity';
        $entity = get_class($oldPost);
        $id = $oldPost->id;

        $tags = array();
        $rubric = $oldPost->rubric;
        while ($rubric)
        {
            $tags[] = $rubric->title;
            $rubric = $rubric->parent;
        }
        if ($oldPost->rubric->community)
        {
            $tags[] = $oldPost->rubric->community->title;
            if ($oldPost->rubric->community->club)
                $tags[] = $oldPost->rubric->community->club->title;
            if ($oldPost->rubric->community->club && $oldPost->rubric->community->club->section)
                $tags[] = $oldPost->rubric->community->club->section->title;
        }

        $newPost = \site\frontend\modules\posts\models\Content::model()->findByAttributes(array(
            'originService' => $service,
            'originEntity' => $entity,
            'originEntityId' => $id,
        ));
        if (!$newPost)
            $newPost = new \site\frontend\modules\posts\models\Content('oldPost');

        var_dump($newPost->isNewRecord);
        $newPost->labelsArray = array_reverse($tags);
        $newPost->url = $oldPost->getUrl(false, true);
        $newPost->originService = $service;
        $newPost->originEntity = $entity;
        $newPost->originEntityId = $id;
        $newPost->authorId = $oldPost->author_id;
        $newPost->title = trim($oldPost->title);
        $newPost->html = $oldPost->post->text;
        $newPost->text = $oldPost->post->text;
        $photo = $oldPost->post->photo;

        if ($photo)
            $newPost->preview = $oldPost->preview . '<div class="b-article_in-img">' . $photo->getPreviewHtml(580, 1100) . '</div>';
        else
            $newPost->preview = $oldPost->preview;

        $newPost->isAutoMeta = $oldPost->meta_description ? false : true;
        $newPost->metaObject->description = $newPost->isAutoMeta ? $oldPost->meta_description_auto : $oldPost->meta_description;
        $newPost->metaObject->title = trim($oldPost->title);
        $newPost->dtimeCreate = strtotime($oldPost->created);
        $newPost->dtimeUpdate = max($newPost->dtimeCreate, strtotime($oldPost->updated), strtotime($oldPost->last_updated));
        $newPost->dtimePublication = $newPost->dtimeCreate;

        $newPost->templateObject->layout = $oldPost->isFromBlog ? 'newBlogPost' : 'newCommunityPost';

        $newPost->originManageInfoObject->link = array('url' => '/' . ($oldPost->isFromBlog ? 'blogs' : 'community') . '/edit/post', 'get' => array('id' => $oldPost->id));

        $newPost->uniqueIndex = $oldPost->uniqueness;
        $newPost->isNoindex = !(is_int($oldPost->uniqueness) && $oldPost->uniqueness > 50);
        $newPost->isNofollow = false;
        $newPost->isRemoved = $oldPost->removed;
        $newPost->isDraft = 0;
        var_dump($newPost->save());
        var_dump($newPost->errors);
        var_export($newPost->attributes);
    }

    protected function convertPhotoPost()
    {
        echo 'photopost';
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
