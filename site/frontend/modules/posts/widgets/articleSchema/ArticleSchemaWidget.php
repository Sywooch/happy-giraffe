<?php

namespace site\frontend\modules\posts\widgets\articleSchema;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 21/07/16
 */
class ArticleSchemaWidget extends \CWidget
{
    /** @var Content */
    public $post;

    public function run()
    {
        $articleSchema = \Yii::app()->dbCache->get($this->getCacheId());
        if ($articleSchema === false) {
            $articleSchema = \site\frontend\modules\posts\components\ArticleHelper::getJsonLd($this->post);
            \Yii::app()->dbCache->set($this->getCacheId(), $articleSchema);
        }
        
        echo '<script type="application/ld+json">' . $articleSchema . '</script>';
    }

    protected function getCacheId()
    {
        return 'articleSchema.1.' . $this->post->id;
    }
}