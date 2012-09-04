<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class TrafficPosts extends PostForCommentator
{
    const CACHE_ID = 'traffic-posts-for-comments';
    const LIMIT = 10;
    protected $nextGroup = 'CoWorkersPosts';

    public function getPost()
    {
        $this->way [] = get_class($this);
        $posts = $this->getPosts();

        if (empty($posts))
            return $this->nextGroup();

        if (count($posts) == 0) {
            return $this->nextGroup();
        } else {
            return array('CommunityContent', $posts[0]->id);
        }
    }

    public function getPosts()
    {
        $posts = Yii::app()->cache->get(self::CACHE_ID);
        if (empty($posts))
            $posts = $this->getNewPosts();

        $posts = $this->filterPosts($posts);

        if (empty($posts)) {
            $posts = $this->getNewPosts();
            $posts = $this->filterPosts($posts);
        }

        return $posts;
    }

    public function filterPosts($posts)
    {
        $result = array();

        foreach ($posts as $post) {
            $model = CommunityContent::model()->active()->findByPk($post);
            if (!$this->IsSkipped('CommunityContent', $model->id)) {
                $entity = $model->isFromBlog ? 'BlogContent' : 'CommunityContent';
                if (!$this->recentlyCommented($entity, $model->id))
                    if ($model !== null && $model->commentsCount < CommentsLimit::getLimit('CommunityContent', $model->id, self::LIMIT))
                        $result [] = $model;
            }
        }

        return $result;
    }

    public function getNewPosts()
    {
        $value = array();
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

        foreach ($pages as $row) {
            if ($row['entity'] == 'CommunityContent' || $row['entity'] == 'BlogContent') {
                $model = CActiveRecord::model($row['entity'])->active()->findByPk($row['entity_id']);
                if ($model !== null && $model->commentsCount < CommentsLimit::getLimit('CommunityContent', $model->id, self::LIMIT))
                    $value [] = $row['entity_id'];

                if (count($value) > 10)
                    break;
            }
        }

        Yii::app()->cache->set(self::CACHE_ID, $value);

        return $value;
    }
}
