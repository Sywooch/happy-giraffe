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

    public function getUrl()
    {
        
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
                    'entityId' => $this->id,
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
        $post->dtimePublication = $this->owner->dtimeCreate;
        $post->dtimeUpdate = $this->owner->dtimeUpdate;
        $labels = is_null($this->owner->forumId) ? Label::model()->findForBlog() : Label::model()->findByRubric($this->owner->rubricId);

        $post->labels = array_map(function($labelModel) {
            return $labelModel->text;
        }, $labels);
        $post->preview = $this->owner->htmlTextPreview;

        $post->template = array(
            'layout' => $this->owner->forumId ? 'newCommunityPost' : 'newBlogPost',
            'data' => array(
                'type' => 'photoPost',
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
        $post->originManageInfo = array(
            'link' => array(
                'url' => '/post/edit/photopost/#',
            ),
        );
        $post->url = '#';
        if ($post->save()) {
            $this->owner->entity = get_class($post);
            $this->owner->entityId = $post->id;
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
        $entity = array_search(get_class($this), \site\frontend\modules\posts\models\Content::$entityAliases);
        try {
            $post = Content::model()->query('getByAttributes', array(
                'entity' => $entity,
                'entityId' => $this->id,
            ));
            $post->url = $this->url;
            $post->originManageInfo['link']['url'] = '/post/edit/photopost/' . $post->id;
            $post->save();
        } catch (\Exception $e) {
            
        }

        parent::afterSave($event);
    }

}

?>
