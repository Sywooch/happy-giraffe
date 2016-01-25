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
        $clubs = \CommunityClub::model()->findAll();

        $criteria = new \CDbCriteria();
        $criteria->index = 'id';
        $criteria->addInCondition('text', array_map(function($club) {
            return $club->toLabel();
        }, $clubs));
        $labels = Label::model()->findAll($criteria);

        $labelsIds = array_map(function($label) {
            return $label->id;
        }, $labels);
        $in = implode(',', $labelsIds);




        $sql = "SELECT * FROM (
SELECT pc.*, pt2.labelId
FROM post__contents pc
JOIN post__tags pt ON pt.contentId = pc.id
JOIN post__tags pt2 ON pt2.contentId = pc.id
WHERE pt.labelId IN (:labelForum) AND pt2.labelId IN (" . $in . ") AND isRemoved = 0
GROUP BY pc.id
HAVING COUNT(pt.labelId) = 1
ORDER BY dtimePublication DESC) t
JOIN post__labels pl ON t.labelId = pl.id
GROUP BY t.labelId;";

        $posts = array();

        $result = \Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':labelForum' => Label::LABEL_FORUMS,
        ));




        foreach ($result as $row) {
            $post = Content::model()->populateRecord($row);
            $labelId = $row['labelId'];


            foreach ($clubs as $club) {
                if ($club->toLabel() == $labels[$labelId]->text) {
                    $posts[$club->id] = $post;
                    break;
                }
            }
        }



        $users = User::model()->findAllByPk(array_map(function($post) {
            return $post->authorId;
        }, $posts));

        $this->render('view', compact('sections', 'posts', 'users'));
    }
}