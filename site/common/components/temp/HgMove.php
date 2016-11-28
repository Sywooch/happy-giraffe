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
        \CommentLogger::model()->addToLog('HgMove', 'move()');
        $rubric = \CommunityRubric::model()->findByPk($rubricId);
        foreach ($rubric->contents as $oldPost) {
            if ($oldPost->by_happy_giraffe || $oldPost->author_id == 1) {
                $newPost = Content::model()->resetScope()->byEntity('CommunityContent', $oldPost->id)->find();
                if ($newPost === null) {
                    continue;
                }

                $oldPost->author_id = $userId;
                $newPost->authorId = $userId;
                $oldPost->save();
                $newPost->save();
                $newPost->delActivity();
                $newPost->addActivity();
            }
        }
    }

    public static function restore($postId, $userId)
    {
        \CommentLogger::model()->addToLog('HgMove', 'restore()');
        $oldPost = \CommunityContent::model()->findByPk($postId);
        $newPost = Content::model()->byEntity('CommunityContent', $oldPost->id)->find();
        $oldPost->author_id = $userId;
        $newPost->authorId = $userId;
        $oldPost->save();
        $newPost->save();
        $newPost->delActivity();
        $newPost->addActivity();
    }
} 