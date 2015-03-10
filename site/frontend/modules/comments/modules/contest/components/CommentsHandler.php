<?php
namespace site\frontend\modules\comments\modules\contest\components;
use site\frontend\modules\comments\models\Comment;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestComment;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

/**
 * @author Никита
 * @date 20/02/15
 */

class CommentsHandler
{
    const EVENT_ADD = 0;
    const EVENT_UPDATE = 1;
    const EVENT_REMOVE = 2;
    const EVENT_RESTORE = 3;

    const MIN_LENGTH = 40;

    public static function handle($commentId, $event)
    {
        $comment = Comment::model()->resetScope()->findByPk($commentId);
        $participant = self::getParticipant($comment);
        if ($participant === null) {
            return true;
        }
        switch ($event) {
            case self::EVENT_ADD:
                self::added($comment, $participant);
                break;
            case self::EVENT_UPDATE:
                self::updated($comment, $participant);
                break;
            case self::EVENT_REMOVE:
                self::removed($comment, $participant);
                break;
            case self::EVENT_RESTORE:
                self::restored($comment, $participant);
                break;
        }
        return $participant->update(array('score'));
    }

    public static function added(Comment $comment, CommentatorsContestParticipant $participant)
    {
        $counts = self::counts($comment->text);

        $contestComment = new CommentatorsContestComment();
        $contestComment->commentId = $comment->id;
        $contestComment->participantId = $participant->id;
        $contestComment->counts = (int) $counts;
        $contestComment->save();

        if ($counts) {
            $participant->score += 1;
        }
    }

    public static function updated(Comment $comment, CommentatorsContestParticipant $participant)
    {
        $contestComment = self::getContestComment($comment, $participant);
        if ($contestComment === null) {
            return;
        }
        $newCounts = self::counts($comment->text);
        $result = -intval($contestComment->counts) + intval($newCounts);
        $contestComment->counts = $newCounts;
        $contestComment->update(array('counts'));
        $participant->score += $result;
    }

    public static function removed(Comment $comment, CommentatorsContestParticipant $participant)
    {
        $contestComment = self::getContestComment($comment, $participant);
        if ($contestComment === null) {
            return;
        }
        $counts = self::counts($comment->text);
        $contestComment->counts = 0;
        $contestComment->update(array('counts'));
        if ($counts) {
            $participant->score -= 1;
        }
    }

    public static function restored(Comment $comment, CommentatorsContestParticipant $participant)
    {
        $contestComment = self::getContestComment($comment, $participant);
        if ($contestComment === null) {
            return;
        }
        $counts = self::counts($comment->text);
        $contestComment->counts = $counts;
        if ($counts) {
            $participant->score += 1;
        }
    }

    protected static function getContestComment(Comment $comment, CommentatorsContestParticipant $participant)
    {
        return CommentatorsContestComment::model()->findByPk(array(
            'commentId' => $comment->id,
            'participantId' => $participant->id,
        ));
    }

    protected static function getParticipant(Comment $comment)
    {
        $contest = CommentatorsContest::model()->active()->find();
        return CommentatorsContestParticipant::model()->contest($contest->id)->user($comment->author_id)->find();
    }

    protected static function counts($text)
    {
        return mb_strlen(strip_tags($text), 'UTF-8') >= self::MIN_LENGTH;
    }
}