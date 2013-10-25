<?php
/**
 * Author: choo
 * Date: 15.05.2012
 */
class LiveWidget extends CWidget
{
    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 5;
        $criteria->with = array(
            'rubric' => array(
                'with' => array(
                    'community' => array(
                        'select' => 'id, title, position',
                    )
                ),
            ),
            'type' => array(
                'select' => array('slug')
            ),
            'post' => array(
                'select' => array('text', 'content_id', 'photo_id')
            ),
            'author' => array(
                'select' => array('id', 'first_name', 'last_name', 'avatar_id', 'online', 'blocked', 'deleted')
            ),
            'video',
        );

        $criteria->order = 'created DESC';
        $criteria->select = array('t.id', 't.title', 't.type_id', 't.rubric_id', 't.author_id', 't.created');
        $criteria->condition = 'type_id != 4 AND (community_id IS NULL OR community_id != :news)';
        $criteria->params = array(':news' => Community::COMMUNITY_NEWS);

        $live = CommunityContent::model()->findAll($criteria);

        $this->render('LiveWidget', compact('live'));
    }
}
