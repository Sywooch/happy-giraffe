<?php
namespace site\frontend\modules\comments\modules\contest\components;
use site\frontend\modules\comments\models\Comment;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

/**
 * @author Никита
 * @date 20/02/15
 */

class CommentsHandler
{
    const MIN_LENGTH = 60;

    public static function added(Comment $comment)
    {
        if ($participant = self::getParticipant($comment)) {
            $participant->score += 1;
            $participant->update(array('score'));
        }
    }

    public static function updated(Comment $comment, $oldText)
    {
        if ($participant = self::getParticipant($comment)) {
            $oldCounts = self::counts($oldText);
            $newCounts = self::counts($comment);
            $result = -intval($oldCounts) + $newCounts;
            $participant->score += $result;
            $participant->update(array('score'));
        }
    }

    public static function removed(Comment $comment)
    {
        if ($participant = self::getParticipant($comment)) {
            $counts = self::counts($comment->text);
            if ($counts) {
                $participant->score -= 1;
                $participant->update(array('score'));
            }
        }
    }

    protected function getParticipant(Comment $comment)
    {
        $contest = CommentatorsContest::model()->active()->find();
        /** @var \site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant $participant */
        return CommentatorsContestParticipant::model()->findByPk(array(
            'userId' => $comment->author_id,
            'contestId' => $contest->id,
        ));
    }

    protected function counts($text)
    {
        return strlen(strip_tags($text)) >= self::MIN_LENGTH;
    }
}