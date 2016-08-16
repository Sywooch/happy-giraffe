<?php
namespace site\frontend\modules\posts\modules\forums\components;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

/**
 * @author Никита
 * @date 20/06/16
 * @todo этот класс инкапсулирует костыльную прослойку между постами и рубриками и нарушает SOA, переосмыслить
 */
class TagHelper
{
    public static function getTag(Content $post)
    {
        $labelText = $post->getLabelTextByPrefix('Рубрика: ');
        if (! $labelText) {
            return null;
        }
        $rubric = \CommunityRubric::model()->findByAttributes([
            'title' => $labelText,    
        ], 'community_id IS NOT NULL');
        $url = \Yii::app()->controller->createUrl('/posts/forums/club/rubric', ['rubricId' => $rubric->id]);
        return [
            'text' => $labelText,
            'url' => $url,
        ];
    }
}