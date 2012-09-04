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
    protected $nextGroup = 'UserPostForCommentator';
    protected $error = '';

    public static function getNextPost($skipUrls)
    {
        $model = new PostForCommentator;
        return $model->nextPost($skipUrls);
    }

    public function nextPost($skipUrls)
    {
        $model = new UserPosts;
        $model->skipUrls = $skipUrls;
        $post = $model->getPost();
        $this->error = $model->error;
        return $post;
    }

    protected function getCriteria($users = true)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'created >= "' . date("Y-m-d H:i:s", strtotime('-144 hour')) . '"';
        $criteria->with = array(
            'author' => array(
                'condition' => $users ? 'author.group = 0' : 'author.group > 0',
                'together' => true,
            )
        );
        $criteria->order = 'rand()';

        return $criteria;
    }

    public function getPosts($criteria)
    {
        $result = array();

        foreach ($this->entities as $entity => $limits) {
            $posts = CActiveRecord::model($entity)->findAll($criteria);
            foreach ($posts as $post)
                if ($post->commentsCount < CommentsLimit::getLimit($entity, $post->id, $limits)) {
                    if (!$this->IsSkipped($entity, $post->id)) {
                        $result [] = $post;
                    }
                }
        }

        shuffle($result);

        return $result;
    }

    public function IsSkipped($entity, $entity_id)
    {
        foreach ($this->skipUrls as $skipped) {
            if ($skipped[0] == $entity && $skipped[1] == $entity_id)
                return true;
        }

        return false;
    }

    public function nextGroup()
    {
        $model = new $this->nextGroup;
        $model->skipUrls = $this->skipUrls;
        $model->way [] = get_class($model);
        if (count($model->way) > 10) {
            $this->error = 'Не найдены тема для комментирования, обратитесь к разработчику';
            return false;
        }
        return $model->getPost();
    }
}