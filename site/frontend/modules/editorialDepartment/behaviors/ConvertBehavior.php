<?php

namespace site\frontend\modules\editorialDepartment\behaviors;

use site\frontend\modules\posts\components\ReverseParser;
use site\frontend\modules\posts\models\api\Content as Content;
use site\frontend\modules\posts\modules\buzz\widgets\SidebarWidget;
use site\frontend\modules\som\modules\community\models\api\CommunityClub;
use site\frontend\modules\posts\modules\contractubex\components\ContractubexHelper;
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
    public static $migration = false;

    protected $_post;

    public function getUrl()
    {
        if ($this->owner->forumId == ContractubexHelper::getForum()->id) {
            return \Yii::app()->createAbsoluteUrl('/posts/contractubex/view/view', array(
                'content_type_slug' => 'advpost',
                'content_id' => $this->owner->entityId,
            ));
        }

        if (self::$migration) {
            return \Yii::app()->createAbsoluteUrl('community/default/view', array(
                'forum_id' => $this->owner->forumId,
                'content_type_slug' => 'advpost',
                'content_id' => $this->owner->entityId,
            ));
        }

        switch ($this->owner->scenario) {
            case 'forums':
                return \Yii::app()->createAbsoluteUrl('community/default/view', array(
                    'forum_id' => $this->owner->forumId,
                    'content_type_slug' => 'advpost',
                    'content_id' => $this->owner->entityId,
                ));
            case 'news':
                return \Yii::app()->createAbsoluteUrl('som/community/newsView/view', array(
                    'forum_id' => 36,
                    'content_type_slug' => 'advpost',
                    'content_id' => $this->owner->entityId,
                ));
            case 'buzz':
                return \Yii::app()->createAbsoluteUrl('posts/buzz/post/view', array(
                    'content_type_slug' => 'advpost',
                    'content_id' => $this->owner->entityId,
                ));
        }

        throw new \CException('Can\'t create url');
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
                var_dump($e);
                die;
                $post = new Content();
            }
        }

        $post->html = $this->owner->htmlText;
        $post->text = strip_tags($post->html);
        $post->authorId = $this->owner->fromUserId;
        $post->title = $this->owner->title;
        $post->dtimeCreate = time();
        $post->dtimeUpdate = $this->owner->dtimeUpdate;

        if ($this->owner->rubricId !== null) {
            $labels = Label::model()->findByRubric($this->owner->rubricId);
        } elseif ($this->owner->forumId !== null) {
            $labels = Label::model()->findByForum($this->owner->forumId);
        } elseif ($this->owner->clubId !== null) {
            $labels = Label::model()->findByClub($this->owner->clubId);
        } else {
            $labels = Label::model()->findForBlog();
        }

        $labels = array_map(function($labelModel) {
            return $labelModel->text;
        }, $labels);
        if ($this->owner->label !== null) {
            $labels[] = $this->owner->label;
        }
        $post->labels = $labels;

        switch ($this->owner->scenario) {
            case 'news':
                $authorView = 'empty';
                break;
            case 'buzz':
                $authorView = 'club';
                break;
            default:
                $authorView = 'default';
        }

        $post->template = array(
            'layout' => $this->owner->forumId ? 'newCommunityPost' : 'newBlogPost',
            'data' => array(
                'type' => 'post',
                'noWysiwyg' => true,
                'hideRubrics' => true,
                'hideRelap' => true,
                'extraLikes' => true,
                'authorView' => $authorView,
                'clubData' => CommunityClub::getClub($labels),
            ),
        );
        $post->isAutoMeta = true;
        $post->meta = array(
            'description' => $this->owner->meta->description,
            'title' => $this->owner->meta->title,
        );

        $doc = str_get_html($this->owner->htmlTextPreview);
        $doc2 = str_get_html($this->owner->htmlTextPreview);
        $img = $doc->find('img', 0);
        if (! $img) {
            $img = $doc2->find('img', 0);
        }
        $imageUrl = null;
        if ($img) {
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
        $post->url = '###';
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
            if ($this->_post->url == '###') {
                $this->_post->url = $this->url;
            }
            $this->_post->preview = $this->getPreview($this->_post);
            $this->_post->originEntityId = $this->_post->id;
            $this->_post->dtimePublication = $this->owner->dtimeCreate;
            $this->_post->isDraft = 0;
            $this->_post->isNoindex = 0;
            $this->_post->isNofollow = 0;
            $this->_post->isRemoved = 0;
            $mInfo = $this->_post->originManageInfo;

            switch ($this->owner->scenario) {
                case 'buzz':
                    $editAction = 'editBuzz';
                    break;
                case 'news':
                    $editAction = 'editNews';
                    break;
                default:
                    $editAction = 'edit';
            }

            $mInfo['params'] = array(
                    'edit' => array(
                        'link' => array(
                            'url' => '/editorialDepartment/redactor/' . $editAction . '/?' . http_build_query(array('entity' => get_class($this->_post), 'entityId' => $this->_post->id)),
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
            $saved = $this->_post->save();
            if ($saved) {
                $this->warmCache($this->_post);
            }
            if (! $saved) {
                var_dump($this->_post->isNewRecord);
                var_dump($this->_post->errors);
                die;
            }
        } catch (\Exception $e) {

        }
        parent::afterSave($event);
    }

    protected function warmCache($post)
    {
        $parser = new ReverseParser($post->html);
        foreach ($parser->gifs as $gif) {
            \Yii::app()->gearman->client()->doBackground('createThumb', serialize(array(
                'photoId' => $gif['photo']->id,
                'usageName' => 'postGifImage',
            )));
        }
        $widget = new SidebarWidget();
        $widget->getHtml($post, true);
    }

    protected function getPreview($post)
    {
        include_once \Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';
        $html = str_get_html($this->owner->htmlText);
        $mediaTags = array('gif-image', 'iframe', 'img');
        $endElements = $this->findEndElements($html->find('.b-markdown', 0));

        // выясняем большой ли пост
        $isBigPost = false;
        $media = array_merge($html->find('gif-image'), $html->find('iframe'), $html->find('img'));
        if (count($media) > 1) {
            $isBigPost = true;
        } else {
            foreach ($endElements as $element) {
                $isLead = strpos($element->class, 'b-markdown_t-sub') !== false;
                $isEmpty = empty($element->innertext);

                if (! $isEmpty && ! $isLead) {
                    $isBigPost = true;
                    break;
                }
            }
        }

        // готовим "сырой" html
        $markDownPreview = trim($this->owner->markDownPreview);
        if (! empty($markDownPreview)) {
            $rawPreview = $this->owner->htmlTextPreview;
        } else {
            $rawPreview = '';

            if (count($html->find('.b-markdown_t-sub'))) {
                $rawPreview .= $html->find('.b-markdown_t-sub', 0)->outertext;
            }

            if (count($media) > 0) {
                $rawPreview .= $media[0]->outertext;
            }

            if (empty($rawPreview)) {
                foreach ($endElements as $element) {
                    if ($element->tag == 'p') {
                        $rawPreview .= $element->outertext;
                        break;
                    }
                }
            }
        }

        // подгоняем под верстку
        $previewHtml = str_get_html($rawPreview);
        $nextLinkAdded = false;
        foreach ($mediaTags as $tag) {
            if (count($previewHtml->find($tag)) > 0) {
                $element = $previewHtml->find($tag, 0);
                $text = $element->outertext;
                if ($tag == 'img' && $isBigPost) {
                    $class = ($this->owner->scenario == 'buzz') ? 'middle' : '';
                    $text = '<a href="' . $post->url . '" class="btn btn-default btn-l btn-feed ' . $class . '">Читать далее</a>' . $text;
                    $nextLinkAdded = true;
                }
                if ($tag != 'gif-image') {
                    $element->outertext = '<div class="b-album-cap feed-cap"><div class="b-album-cap_hold">' . $text . '</div></div>';
                }
            }
        }

        if ($isBigPost && ! $nextLinkAdded) {
            $previewHtml .= '<div class="b-album-cap feed-cap">
                      <div class="b-album-cap_hold">
                        <a href="' . $post->url . '" class="btn btn-default btn-l btn-feed_noimage">Читать далее</a>
                      </div>
                    </div>';
        }

        return (string) $previewHtml;
    }

    protected function findEndElements($element, $array = array())
    {
        $children = $element->children;
        if (count($element->children) == 0) {
            $array[] = $element;
        } else {
            foreach ($children as $child) {
                $array = $this->findEndElements($child, $array);
            }
        }
        return $array;
    }
}

?>
