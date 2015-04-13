<?php
namespace site\common\components\temp;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 13/04/15
 */

class HgMove
{
    public static function move($rubricId, $userId)
    {
        $rubric = \CommunityRubric::model()->findByPk($rubricId);
        foreach ($rubric->contents as $oldPost) {
            $newPost = Content::model()->byEntity('CommunityContent', $oldPost->id);
            $oldPost->author_id = $userId;
            $newPost->authorId = $userId;
            $oldPost->save();
            $newPost->save();
            $newPost->delActivity();
            $newPost->addActivity();
        }
    }
}