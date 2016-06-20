<?php
namespace site\frontend\modules\posts\modules\forums\components;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 20/06/16
 */
class TagHelper
{
    public static function getTag(Content $post)
    {
        $rubricLabel = $post->getLabelByPrefix('Рубрика');

        if ($rubricLabel) {
            return str_replace('Рубрика: ', '', $rubricLabel->text);
        }
        return null;
    }
}