<?php
/**
 * Class PhotoUrlRule
 *
 * Урлы для фото в фотопостах и галереи в старых постах
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class PhotoUrlRule extends CBaseUrlRule
{
    public $pattern;
    public $route;
    public $blog = false;

    public function createUrl($manager, $route, $params, $ampersand)
    {
        if ($route == 'albums/singlePhoto' && isset($params['photo_id'])) {
            $photo = AlbumPhoto::model()->findByPk($params['photo_id']);
            if (isset($photo->galleryItem) && isset($photo->galleryItem->gallery) && isset($photo->galleryItem->gallery->content)) {
                if ($photo->galleryItem->gallery->content->getIsFromBlog() && $this->blog ||
                    !$photo->galleryItem->gallery->content->getIsFromBlog() && !$this->blog
                ) {
                    if ($photo->galleryItem->gallery->content->type_id == CommunityContent::TYPE_PHOTO_POST)
                        $this->pattern = str_replace('(post|photoPost)', 'photoPost', $this->pattern);
                    else
                        $this->pattern = str_replace('(post|photoPost)', 'post', $this->pattern);
                    $urlRuleClass = Yii::import(Yii::app()->urlManager->urlRuleClass, true);
                    $rule = new $urlRuleClass($this->route, $this->pattern);
                    return $rule->createUrl($manager, $route, $params, $ampersand);
                }
            }
        }

        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        $urlRuleClass = Yii::import(Yii::app()->urlManager->urlRuleClass, true);
        $rule = new $urlRuleClass($this->route, $this->pattern);
        return $rule->parseUrl($manager, $request, $pathInfo, $rawPathInfo);
    }
}