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
        self::process($comment, function($participant) {
            $participant->score += 1;
            $participant->update(array('scope'));
        });
    }

    public static function removed(Comment $comment)
    {
        if (! self::isValid($comment)) {
            return;
        }


    }

    protected function process(Comment $comment, $callback) {
        $participant = $this->getParticipant($comment);
        if (! self::isValid($comment) || $participant === null) {
            return;
        }
        call_user_func($callback, $participant);
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

    protected function isValid(Comment $comment)
    {
        return strlen(strip_tags($comment->text)) >= self::MIN_LENGTH;
    }
}