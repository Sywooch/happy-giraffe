<?php
/**
 * @author Никита
 * @date 10/03/15
 */

namespace site\frontend\modules\comments\modules\contest\widgets;


use site\frontend\modules\posts\models\Content;

class PostsWidget extends \CWidget
{
    const LIMIT = 20;

    public $models;

    public function init()
    {
        $favourites = \Favourites::model()->block(\Favourites::BLOCK_COMMENTATORS_CONTEST)->orderDesc()->findAll();
        $ids = array_map(function($f) {
            return $f->entity_id;
        }, $favourites);

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('t.originEntityId', $ids);
        $criteria->addCondition('c.id IS NULL');
        $criteria->order = 'FIELD(t.originEntityId, ' . implode(', ', $ids) . ');';
        $criteria->join .= ' LEFT OUTER JOIN comments c ON c.removed = 0 AND c.entity IN ("BlogContent", "CommunityContent") AND t.originEntityId = c.entity_id AND c.author_id = :author_id';
        $criteria->params[':author_id'] = \Yii::app()->user->id;
        $this->models = Content::model()->findAll($criteria);
    }

    public function run()
    {
        foreach ($this->models as $model) {
            $this->render('site.frontend.modules.posts.views.list._view', array('data' => $model));
        }
    }
}