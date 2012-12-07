<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class TrafficPosts extends PostForCommentator
{
    protected $nextGroup = 'CoWorkersPosts';
    protected $entities = array(
        'CommunityContent' => array(25),
    );

    public function getPost()
    {
        if (rand(0, 10) > 7)
            return $this->nextGroup();

        $criteria = $this->getCriteria();
        if ($criteria === null)
            return $this->nextGroup();

        $posts = $this->getPosts($criteria, true);
        $this->logState(count($posts));

        if (count($posts) == 0) {
            return $this->nextGroup();
        } else {
            return array(get_class($posts[0]), $posts[0]->id);
        }
    }

    /**
     * @return CDbCriteria
     */
    public function getCriteria()
    {
        $post_ids = $this->getPostIds();
        if (empty($post_ids))
            return null;

        $criteria = new CDbCriteria;
        $criteria->condition = '`t`.`full` IS NULL AND t.type_id < 3';
        $criteria->compare('`t`.`id`', $post_ids);

        return $criteria;
    }

    public function getPostIds()
    {
        $result = array();
        $date = strtotime('-1 month');

        if (date('Y', $date) != date('Y'))
            $phrases = Yii::app()->db_seo->createCommand()
                ->selectDistinct('search_phrase_id')
                ->from('pages_search_phrases_visits')
                ->where('week >= ' . date('W', $date) . ' AND year = ' . date('Y', $date) . ' OR year = ' . date('Y'))
                ->order('rand()')
                ->limit(100)
                ->queryColumn();
        else
            $phrases = Yii::app()->db_seo->createCommand()
                ->selectDistinct('search_phrase_id')
                ->from('pages_search_phrases_visits')
                ->where('week >= ' . date('W', $date) . ' AND year = ' . date('Y', $date))
                ->order('rand()')
                ->limit(100)
                ->queryColumn();

        if (empty($phrases))
            return array();

        $pageIds = Yii::app()->db_seo->createCommand()
            ->selectDistinct('page_id')
            ->from('pages_search_phrases')
            ->where('id IN (' . implode(',', $phrases) . ')')
            ->queryColumn();

        if (empty($pageIds))
            return array();

        $pages = Yii::app()->db_seo->createCommand()
            ->select(array('entity', 'entity_id'))
            ->from('pages')
            ->where('id IN (' . implode(',', $pageIds) . ')')
            ->queryAll();

        foreach ($pages as $row)
            if ($row['entity'] == 'CommunityContent' || $row['entity'] == 'BlogContent')
                $result [] = $row['entity_id'];

        return $result;
    }
}
