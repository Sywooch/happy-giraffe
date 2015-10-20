<?php
/**
 * @author Никита
 * @date 12/10/15
 */

namespace site\frontend\modules\posts\modules\buzz\widgets;

use site\common\helpers\HStr;
use site\frontend\modules\posts\components\ReverseParser;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

class SidebarWidget extends \CWidget
{
    const LIMIT = 5;
    const CACHE_PREFIX = 'HappyGiraffe.Buzz.v6.';

    /**
     * @var \CommunityClub
     */
    public $club;

    public $cacheId = 'cache';

    public function run()
    {
        $labels = array(Label::LABEL_BUZZ);
        if ($this->club) {
            $labels[] = $this->club->toLabel();
        }
        $posts = Content::model()->byLabels($labels)->findAll(array(
            'condition' => 'id IN (48, 50, 78)',
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
        $previewParser = new ReverseParser($post->preview);
        if (count($parser->gifs) > 0) {
            return $this->render('_gif', $parser->gifs[0], true);
        }
        if (count($parser->videos) > 0) {
            $videoData = $parser->videos[0];
            $id = $videoData['id'];
            $url = 'http://www.youtube.com/watch?v=' . $id;
            $video = \Video::factory($url);
            return $this->render('_video', compact('video'), true);
        }
        $images = array_merge($parser->images, $previewParser->images);
        if (count($images) > 0) {
            return $this->render('_img', $images[0], true);
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