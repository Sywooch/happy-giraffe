<?php
namespace site\frontend\modules\posts\modules\forums\widgets\clubs;

use site\frontend\components\api\models\User;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

class ClubsWidget extends \CWidget
{
    public function run()
    {
        $sections = \CommunitySection::model()->with('clubs')->findAll();
        $clubs = \Community::model()->findAll();

        $sql = <<<SQL
SELECT * FROM (
SELECT pc.*, pt2.labelId
FROM post__contents pc
JOIN post__tags pt ON pt.contentId = pc.id
JOIN post__tags pt2 ON pt2.contentId = pc.id
WHERE pt.labelId IN (:a) AND pt2.labelId IN (:b) AND isRemoved = 0
GROUP BY pc.id
HAVING COUNT(pt.labelId) = 1
ORDER BY dtimePublication DESC) t
GROUP BY t.labelId;
SQL;

        $a = \Yii::app()->db->createCommand($sql);


        var_dump($a->queryAll(true, array(
            ':a' => Label::LABEL_FORUMS,
            ':b' => implode(',', Label::getIdsByLabels(array_map(function($club) {
                return $club->toLabel();
            }, $clubs))),
        ))); die;

        $users = User::model()->findAllByPk(array_map(function($post) {
            return $post->authorId;
        }, $posts));

        $this->render('view', compact('sections', 'posts', 'users'));
    }
}