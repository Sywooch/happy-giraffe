<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class PostForCommentator
{
    protected $entities = array();
    protected $skipUrls = array();
    protected $way = array();

    public static function getNextPost($skipUrls)
    {
        $model = new PostForCommentator;
        return $model->nextPost($skipUrls);
    }

    public function nextPost($skipUrls)
    {
        $rand = rand(0, 99);
        if ($rand < 50) {
            $model = new UserPostForCommentator;
        } elseif ($rand < 65) {
            $model = new MainPagePostForCommentator;
        } elseif ($rand < 80) {
            $model = new SocialPostForCommentator;
        } elseif ($rand < 90) {
            $model = new TrafficPostForCommentator;
        } else
            $model = new CoWorkersPostCommentator;
        $model->skipUrls = $skipUrls;
        $post =  $model->getPost();
        return $post;
    }

    protected function getCriteria($users = true)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = $this->generateTimeCondition();
        $criteria->with = array(
            'author' => array(
                'condition' => $users ? 'author.group = 0' : 'author.group > 0',
                'together' => true,
            )
        );
        $criteria->order = 'rand()';

        return $criteria;
    }

    protected function getSimpleCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = $this->generateSimpleTimeCondition();
        $criteria->order = 'rand()';

        return $criteria;
    }

    protected function generateTimeCondition()
    {
        $rand = rand(0, 99);
        if ($rand < 30)
            return 'created >= "' . date("Y-m-d H:i:s", strtotime('-1 hour')) . '"';
        elseif ($rand < 50)
            return 'created >= "' . date("Y-m-d H:i:s", strtotime('-3 hour')) . '" AND created < "' . date("Y-m-d H:i:s", strtotime('-1 hour')) . '"';
        elseif ($rand < 70)
            return 'created >= "' . date("Y-m-d H:i:s", strtotime('-6 hour')) . '" AND created < "' . date("Y-m-d H:i:s", strtotime('-3 hour')) . '"';
        elseif ($rand < 90)
            return 'created >= "' . date("Y-m-d H:i:s", strtotime('-18 hour')) . '" AND created < "' . date("Y-m-d H:i:s", strtotime('-6 hour')) . '"';
        else
            return 'created >= "' . date("Y-m-d H:i:s", strtotime('-144 hour')) . '" AND created < "' . date("Y-m-d H:i:s", strtotime('-18 hour')) . '"';
    }

    protected function generateSimpleTimeCondition()
    {
        $rand = rand(0, 99);
        if ($rand < 90)
            return 'created >= "' . date("Y-m-d ") . ' 00:00:00"';
        else
            return 'created >= "' . date("Y-m-d H:i:s", strtotime('-144 hour')) . '" AND created < "' . date("Y-m-d H:i:s") . ' 00:00:00"';
    }

    protected function maxTimeCondition()
    {
        return 'created >= "' . date("Y-m-d H:i:s", strtotime('-144 hour')) . '"';
    }

    /**
     * @static С предыдущего комментария должно пройти минимум 3 комментария
     * @param $entity
     * @param $entity_id
     * @return bool
     */
    public function recentlyCommented($entity, $entity_id)
    {
        $comments = Yii::app()->db->createCommand()
            ->select('*')
            ->from('comments')
            ->where('entity = :entity AND entity_id = :entity_id', array(
            'entity' => $entity,
            'entity_id' => $entity_id,
        ))
            ->order('created desc')
            ->limit(3)
            ->queryAll();

        foreach ($comments as $comment) {
            if ($comment['author_id'] == Yii::app()->user->id)
                return true;
        }

        return false;
    }

    public function isCategoryEmpty($users = true)
    {
        $criteria = $this->getCriteria($users);
        $criteria->condition = $this->maxTimeCondition();

        $posts = $this->getPosts($criteria);

        if (count($posts) == 0)
            return true;

        return false;
    }

    public function getPosts($criteria)
    {
        $result = array();

        foreach ($this->entities as $entity => $limits) {
            $posts = CActiveRecord::model($entity)->findAll($criteria);
            foreach ($posts as $post)
                if ($post->commentsCount < CommentsLimit::getLimit($entity, $post->id, $limits)) {
                    if (!$this->IsSkipped($entity, $post->id)) {
                        if ($entity == 'CommunityContent')
                            $_entity = $post->isFromBlog ? 'BlogContent' : 'CommunityContent';
                        else
                            $_entity = $entity;

                        if (!self::recentlyCommented($_entity, $post->id))
                            $result [] = $post;
                    }
                }
        }

        shuffle($result);

        return $result;
    }

    public function IsSkipped($entity, $entity_id)
    {
        foreach ($this->skipUrls as $skipped){
            if ($skipped[0] == $entity && $skipped[1] == $entity_id)
                return true;
        }

        return false;
    }
}