<?php
/**
 * @author Никита
 * @date 06/02/15
 */

namespace site\frontend\modules\ads\components\creatives;

\Yii::import('site.frontend.vendor.simplehtmldom_1_5.*');
require_once('simple_html_dom.php');

class PostCreative extends BaseCreative
{
    const SIZE_SMALL = 'small';
    const SIZE_BIG = 'big';
    
    const MAX_TITLE_LENGTH = 55;

    public $modelClass = 'site\frontend\modules\posts\models\Content';
    public $size;

    /**
     * @var \site\frontend\modules\posts\models\Content
     */
    protected $post;
    protected $html;
    protected $preview;

    public function init()
    {
        $this->html = str_get_html($this->model->html);
        $this->preview = str_get_html($this->model->preview);
    }

    public function getClubTitle()
    {
        return $this->getClub()->title;
    }

    public function getPhotosCount()
    {
        return count($this->html->find('img'));
    }

    public function getPhoto()
    {
        $docs = array($this->preview, $this->html);
        foreach ($docs as $doc) {
            $img = $doc->find('img', 0);
            if ($img !== null) {
                $src = $img->src;
                $photo = \Yii::app()->thumbs->getPhotoByUrl($src);
                if ($photo !== null) {
                    return $photo;
                }
            }
        }
        return null;
    }

    public function getName()
    {
        return $this->model->title;
    }

    public function getUrl()
    {
        return $this->model->url;
    }

    public function getOriginEntity()
    {
        return \CommunityContent::model()->findByPk($this->model->originEntityId);
    }

    public function getClub()
    {
        /** @var \CommunityContent $originEntity */
        $originEntity = $this->getOriginEntity();
        if ($originEntity !== null) {
            return $originEntity->rubric->community->club;
        }
        if (preg_match('#community\/(\d+)#', $this->model->url, $matches)) {
            $forumId = $matches[1];
            $forum = \Community::model()->findByPk($forumId);
            return $forum->club;
        }

    }
}