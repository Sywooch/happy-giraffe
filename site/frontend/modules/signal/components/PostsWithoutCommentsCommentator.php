<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class PostsWithoutCommentsCommentator extends PostForCommentator
{
    const CACHE_ID = 'posts-without-comments';

    public function getPost()
    {
        Yii::import('site.seo.models.*');
        Yii::import('site.seo.modules.promotion.models.*');
        $this->way [] = 'PostsWithoutCommentsCommentator';

        $ids = $this->getPostIds();
        if (empty($ids))
            return $this->nextGroup();

        $criteria = new CDbCriteria;
        $criteria->compare('id', $ids);
        $criteria->order = 'rand()';
        $posts = CommunityContent::model()->findAll($criteria);

        $not_commented_yet = array();
        foreach ($posts as $post) {
            if (!$this->IsSkipped(get_class($post), $post->id)) {
                $entity = $post->isFromBlog ? 'BlogContent' : 'CommunityContent';
                if (!$this->recentlyCommented($entity, $post->id))
                    $not_commented_yet [] = $post;
            }
        }

        if (count($not_commented_yet) == 0) {
            return $this->nextGroup();
        } else {
            return array(get_class($not_commented_yet[0]), $not_commented_yet[0]->id);
        }
    }

    public function nextGroup()
    {
        $model = new UserPostForCommentator;
        $model->skipUrls = $this->skipUrls;
        $model->way [] = get_class($model);
        if (count($model->way) > 10){
            var_dump($model->way);
            Yii::app()->end();
        }
        return $model->getPost();
    }

    public function getPostIds()
    {
        $result = array();
        $posts = Yii::app()->cache->get(self::CACHE_ID);

        if (empty($posts))
            $posts = $this->getNewPosts();

        if (!empty($posts))
            foreach ($posts as $post) {
                $model = CommunityContent::model()->active()->findByPk($post);
                if ($model !== null && $model->commentsCount < CommentsLimit::getLimit('CommunityContent', $post, array(3, 6)))
                    $result [] = $post;
            }

        if (empty($result)) {
            $this->getNewPosts();
            return $this->getPostIds();
        }

        return $result;
    }

    public function getNewPosts()
    {
        $value = array();
        $criteria = new CDbCriteria(array(
            'condition' => 'comments.id IS NULL',
            'with' => array(
                'comments' => array(
                    'select' => 'id',
                    'together' => true,
                ),
                'rubric' => array(
                    'select' => 'id',
                    'condition' => 'user_id IS NULL',
                    'with' => array(
                        'community' => array(
                            'select' => 'id',
                        )
                    ),
                ),
            ),
            'limit' => 100,
            'order' => 'rand()'
        ));
        $posts = CommunityContent::model()->findAll($criteria);

        foreach ($posts as $post) {
            $criteria = new CDbCriteria;
            $criteria->compare('entity', $post->isFromBlog ? 'BlogContent' : 'CommunityContent');
            $criteria->compare('entity_id', $post->id);
            $page = Page::model()->with('phrases')->find($criteria);
            if ($page === null || empty($page->phrases))
                $value[] = $post->id;
        }

        Yii::app()->cache->set(self::CACHE_ID, $value);

        return $value;
    }
}
