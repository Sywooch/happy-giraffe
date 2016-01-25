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
        $clubLabels = $this->getLabels($clubs);
        $result = $this->getPosts($clubLabels);

        $posts = array();
        foreach ($result as $row) {
            $post = Content::model()->populateRecord($row);
            $labelId = $row['labelId'];


            foreach ($clubs as $club) {
                if ($club->toLabel() == $clubLabels[$labelId]->text) {
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

    protected function getLabels($clubs)
    {
        $criteria = new \CDbCriteria();
        $criteria->index = 'id';
        $criteria->addInCondition('text', array_map(function($club) {
            return $club->toLabel();
        }, $clubs));
        return Label::model()->findAll($criteria);
    }

    protected function getPosts($labels)
    {
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

        return \Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':labelForum' => Label::LABEL_FORUMS,
        ));
    }
}