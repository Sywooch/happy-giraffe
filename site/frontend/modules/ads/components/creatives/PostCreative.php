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

    public $template = 'post';
    public $modelClass = 'site\frontend\modules\posts\models\Content';
    public $size;

    /**
     * @var \site\frontend\modules\posts\models\Content
     */
    protected $post;
    protected $dom;

    public function init()
    {
        $this->dom = str_get_html($this->model->html);
    }

    public function getClubTitle()
    {
        /** @var \CommunityContent $originEntity */
        $originEntity = \CommunityContent::model()->findByPk($this->model->originEntityId);
        $club = $originEntity->rubric->community->club;
        return $club->title;
    }

    public function getPhotosCount()
    {
        return count($this->dom->find('img'));
    }

    public function getPhoto()
    {
        $img = $this->dom->find('img', 0);
        $src = $img->src;
        $photo = \Yii::app()->thumbs->getPhotoByUrl($src);
        return $photo;
    }

    public function getName()
    {
        return $this->model->title;
    }

    public function getUrl()
    {
        return $this->model->url;
    }
}