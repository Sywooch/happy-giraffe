<?php
/**
 * @author Никита
 * @date 12/10/15
 */

namespace site\frontend\modules\posts\modules\buzz\widgets;

use site\common\helpers\HStr;
use site\frontend\modules\posts\components\ReverseParser;
use site\frontend\modules\posts\models\Content;

class SidebarWidget extends \CWidget
{
    const LIMIT = 5;
    const CACHE_PREFIX = 'HappyGiraffe.Buzz.';

    /**
     * @var \CommunityClub
     */
    public $club;

    public $cacheId = 'dbCache';

    public function run()
    {
        $labels = array($this->club->toLabel(), 'Buzz');
        $posts = Content::model()->byLabels($labels)->findAll(array(
            'limit' => self::LIMIT,
        ));
        $this->render('main', compact('posts'));
    }

    public function getHtml($post)
    {
        $cacheId = $this->getCacheKey($post->id);
        $value = $this->getCache()->get($cacheId);
        if ($value === false) {
            $value = $this->getContentHtml($post);
            $dependency = new \CDbCacheDependency("SELECT dtimeUpdate FROM " . Content::model()->tableName() . " WHERE id = :id");
            $dependency->params = array(
                ':id' => $post->id,
            );
            $this->getCache()->set($cacheId, $value, 0, $dependency);
        }
        return $value;
    }

    protected function getContentHtml($post)
    {
        $parser = new ReverseParser($post->html);
        if (count($parser->gifs) > 0) {
            return $this->render('_gif', $parser->gifs[0]);
        }
        if (count($parser->videos) > 0) {
            $videoData = $parser->videos[0];
            $video = new \Video($videoData['url']);
            return $this->render('_video', compact('video'));
        }
        if (count($parser->images) > 0) {
            return $this->render('_img', $parser->images[0]);
        }
        return \CHtml::tag('p', array(), HStr::truncate($post->text));
    }

    protected function getCacheKey($postId)
    {
        return self::CACHE_PREFIX . $postId;
    }

    /**
     *
     * @return \CCache
     */
    protected function getCache()
    {
        return \Yii::app()->getComponent($this->cacheId);
    }
}