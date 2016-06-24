<?php

namespace site\frontend\modules\posts\modules\forums\widgets\clubs;

use site\frontend\components\api\models\User;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

class ClubsWidget extends \CWidget
{

    public function run()
    {
        $sections = \CommunitySection::model()->sorted()->with('clubs')->findAll();
        $clubs = \CommunityClub::model()->findAll();
        $clubLabels = $this->getLabels($clubs);
        $result = $this->getPosts($clubLabels);

        $posts = array();
        foreach ($result as $row)
        {
            $post = Content::model()->populateRecord($row);
            $labelId = $row['labelId'];


            foreach ($clubs as $club)
            {
                if ($club->toLabel() == $clubLabels[$labelId]->text)
                {
                    $posts[$club->id] = $post;
                    break;
                }
            }
        }

        $users = User::model()->findAllByPk(array_map(function($post)
                {
                    return $post->authorId;
                }, $posts));

        $this->render('view', compact('sections', 'posts', 'users'));
    }

    protected function getLabels($clubs)
    {
        $criteria = new \CDbCriteria();
        $criteria->index = 'id';
        $criteria->addInCondition('text', array_map(function($club)
                {
                    return $club->toLabel();
                }, $clubs));
        return Label::model()->findAll($criteria);
    }

    protected function getPosts($labels)
    {
        $labelForum = Label::getIdByLabel(Label::LABEL_FORUMS);
        $return = array();
        foreach ($labels AS $label)
        {
            $sql = "SELECT * 
FROM post__contents AS pc 
	JOIN (SELECT pt.contentId
	FROM post__tags AS pt
	WHERE pt.labelId in (:labelForum, :labelId)
	GROUP BY pt.contentId
	HAVING COUNT(pt.contentId) = 2
	ORDER BY pt.contentId desc
	LIMIT 20) AS tmp ON (pc.id=tmp.contentId)
LEFT JOIN post__tags AS pt ON (pt.contentId = pc.id)
WHERE  pc.isRemoved = 0 and pt.labelId=:labelId 
GROUP BY pt.contentId
ORDER BY pc.id desc
LIMIT 1";
            $itm = \Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':labelForum' => $labelForum,
                ':labelId' => $label->id
            ));
            if (isset($itm[0]))
            {
                $return[] = $itm[0];
            }
        }
        return $return;
    }

}
