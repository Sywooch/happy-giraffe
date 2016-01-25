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

        $sql = <<<SQL
SELECT * FROM (
SELECT pc.*, pt2.labelId
FROM post__contents pc
JOIN post__tags pt ON pt.contentId = pc.id
JOIN post__tags pt2 ON pt2.contentId = pc.id
WHERE pt.labelId IN (18319) AND pt2.labelId IN (102, 107)
GROUP BY pc.id
HAVING COUNT(pt.labelId) = 1
ORDER BY dtimePublication DESC) t
GROUP BY t.labelId;
SQL;

        $criteria = clone Content::model()->byLabels(array(Label::LABEL_FORUMS))->orderDesc()->getDbCriteria();
        $criteria->select = 't.*, pt2.labelId';
        $criteria->join .= "JOIN post__tags pt ON pt.contentId = t.id JOIN post__tags pt2 ON pt2.contentId = t.id";
        $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(Content::model()->tableName(), $criteria);

        //$command->text = "SELECT * FROM (" . $command->text . ") t GROUP BY t.labelId";

        var_dump($command->queryAll()); die;

        $users = User::model()->findAllByPk(array_map(function($post) {
            return $post->authorId;
        }, $posts));

        $this->render('view', compact('sections', 'posts', 'users'));
    }
}