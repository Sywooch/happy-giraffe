<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class ZeroCommentsPosts extends PostForCommentator
{
    protected $entities = array(
        'CommunityContent' => array(2, 3),
    );
    protected $nextGroup = 'TrafficPosts';

    public function getPost()
    {
        Yii::import('site.frontend.modules.cook.models.*');

        $criteria = $this->getCriteria();
        $posts = $this->getPosts($criteria);

        $this->logPostsCount(count($posts));

        if (count($posts) == 0) {
            return $this->nextGroup();
        } else {
            return array(get_class($posts[0]), $posts[0]->id);
        }
    }

    public function getPosts($criteria)
    {
        $result = array();

        foreach ($this->entities as $entity => $limits) {
            $posts = CActiveRecord::model($entity)->findAll($criteria);
            foreach ($posts as $post) {
                list($count_limit, $post_time) = CommentsLimit::getLimit($entity, $post->id, $limits, $this->times);

                if ($post->commentsCount < $count_limit) {
                    if (!$this->IsSkipped($entity, $post->id))
                        $result [] = $post;
                }
            }
        }

        shuffle($result);
        return $result;
    }

    /**
     * @return CDbCriteria
     */
    public function getCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, `comments`.`id` as comment_id';
        $criteria->condition = 't.type_id < 3 AND t.created < "2012-08-20 00:00:00" AND `full` IS NULL AND comments.id IS NULL  AND t.removed = 0';
        $criteria->join = 'LEFT OUTER JOIN `comments` `comments` ON (`comments`.`entity_id`=`t`.`id` AND `comments`.`author_id` = '.$this->commentator->user_id.') ';
        $criteria->limit = 100;

        return $criteria;
    }
}
