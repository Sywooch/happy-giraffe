<?php

namespace site\frontend\modules\editorialDepartment\behaviors;

use site\frontend\modules\posts\models\api\Content as Content;
use site\frontend\modules\som\modules\community\models\api\Label as Label;

include_once \Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

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

        $doc = str_get_html($this->owner->htmlTextPreview);
        $img = $doc->find('img', 0);
        $imageUrl = null;
        if ($img) {
            echo $img->src;
            $photo = \Yii::app()->thumbs->getPhotoByUrl($img->src);
            if ($photo) {
                $imageUrl = \Yii::app()->thumbs->getThumb($photo, 'socialImage')->getUrl();
            }
        }
        $post->social = array(
            'title' => $this->owner->title,
            'description' => trim(preg_replace('~\s+~', ' ', strip_tags($this->owner->htmlTextPreview))),
            'imageUrl' => $imageUrl,
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
            $mInfo['params'] = array(
                    'edit' => array(
                        'link' => array(
                            'url' => '/editorialDepartment/redactor/edit/?' . http_build_query(array('entity' => get_class($this->_post), 'entityId' => $this->_post->id)),
                        )
                    ),
                    'remove' => array(
                        'api' => array(
                            'url' => '/api/posts/remove/',
                            'params' => array(
                                'id' => (int) $this->_post->id,
                            ),
                        ),
                    ),
                    'restore' => array(
                        'api' => array(
                            'url' => '/api/posts/restore/',
                            'params' => array(
                                'id' => (int) $this->_post->id,
                            ),
                        ),
                    ),
            );
            $this->_post->originManageInfo = $mInfo;
            $this->_post->save();
        } catch (\Exception $e) {
            
        }
        parent::afterSave($event);
    }

}

?>
