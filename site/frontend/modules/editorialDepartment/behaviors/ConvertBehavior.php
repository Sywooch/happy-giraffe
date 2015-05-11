<?php

namespace site\frontend\modules\editorialDepartment\behaviors;

use site\frontend\modules\posts\models\api\Content as Content;
use site\frontend\modules\som\modules\community\models\api\Label as Label;

/**
 * Description of ConvertBehavior
 *
 * @author Кирилл
 * 
 * @property \site\frontend\modules\editorialDepartment\models\Content $owner Owner
 */
class ConvertBehavior extends \EMongoDocumentBehavior
{

    protected $_post;

    public function getUrl()
    {
        return \Yii::app()->createAbsoluteUrl('community/default/view', array(
                    'forum_id' => $this->owner->forumId,
                    'content_type_slug' => 'advpost',
                    'content_id' => $this->owner->entityId,
        ));
    }

    public function beforeSave($event)
    {
        $entity = array_search(get_class($this), \site\frontend\modules\posts\models\Content::$entityAliases);
        if ($this->owner->isNewRecord) {
            $post = new Content();
        } else {
            try {
                $post = Content::model()->query('getByAttributes', array(
                    'entity' => $entity,
                    'entityId' => $this->owner->entityId,
                ));
            } catch (\Exception $e) {
                $post = new Content();
            }
        }

        $post->html = $this->owner->htmlText;
        $post->text = strip_tags($post->html);
        $post->authorId = $this->owner->fromUserId;
        $post->title = $this->owner->title;
        $post->dtimeCreate = time();
        $post->dtimeUpdate = $this->owner->dtimeUpdate;
        $labels = is_null($this->owner->forumId) ? Label::model()->findForBlog() : Label::model()->findByRubric($this->owner->rubricId);

        $post->labels = array_map(function($labelModel) {
            return $labelModel->text;
        }, $labels);
        $post->preview = $this->owner->htmlTextPreview;

        $post->template = array(
            'layout' => $this->owner->forumId ? 'newCommunityPost' : 'newBlogPost',
            'data' => array(
                'type' => 'post',
                'noWysiwyg' => true,
            ),
        );
        $post->isAutoMeta = true;
        $post->meta = array(
            'description' => $this->owner->meta->description,
            'title' => $this->owner->meta->title,
        );

        $post->social = array(
            'description' => $post->meta['description'],
        );

        $post->originService = 'advPost';
        $post->originEntityId = 0;
        $post->originEntity = 'AdvPost';
        $post->url = '#';
        $post->isRemoved = 1;
        if ($post->save()) {
            $this->owner->entity = get_class($post);
            $this->owner->entityId = $post->id;
            $this->_post = $post;
            return parent::beforeSave($event);
        } else {
            var_dump($post->errors);
            die;
            $event->isValid = false;
            return false;
        }
    }

    public function afterSave($event)
    {
        try {
            $this->_post->url = $this->url;
            $this->_post->originEntityId = $this->_post->id;
            $this->_post->dtimePublication = $this->owner->dtimeCreate;
            $this->_post->isDraft = 0;
            $this->_post->isNoindex = 0;
            $this->_post->isNofollow = 0;
            $this->_post->isRemoved = 0;
            $mInfo = $this->_post->originManageInfo;
            $mInfo['link']['url'] = 'editorialDepartment/redactor/edit';
            $mInfo['link']['get'] = array(
                'entity' => $this->owner->entity,
                'entityId' => $this->owner->entityId,
            );
            $this->_post->originManageInfo = $mInfo;
            $this->_post->save();
        } catch (\Exception $e) {
            
        }
        parent::afterSave($event);
    }

}

?>
