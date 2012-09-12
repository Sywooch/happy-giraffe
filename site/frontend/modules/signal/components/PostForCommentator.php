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
    protected $nextGroup = 'UserPosts';
    protected $error = '';
    protected $user_id;
    public $times = array(3, 3, 2, 2);

    public static function getNextPost($user_id, $skipUrls)
    {
        $model = new PostForCommentator;
        return $model->nextPost($user_id, $skipUrls);
    }

    public function nextPost($user_id, $skipUrls)
    {
        $model = new UserPosts();
        $model->skipUrls = $skipUrls;
        $model->user_id = $user_id;
        $post = $model->getPost();
        $this->error = $model->error;
        return $post;
    }

    /**
     * @param CDbCriteria $criteria
     * @return CActiveRecord[]
     */
    public function getPosts($criteria)
    {
        $result = array();

        foreach ($this->entities as $entity => $limits) {
            $posts = CActiveRecord::model($entity)->findAll($criteria);
            foreach ($posts as $post) {
                list($count_limit, $post_time) = CommentsLimit::getLimit($entity, $post->id, $limits, $this->times);

                if (isset($post_time[$post->commentsCount])) {
                    $post_time = $post_time[$post->commentsCount];
                    $post_created_spent_minutes = round((time() - strtotime($post->created)) / 60);

                    if ($post->commentsCount < $count_limit) {
                        if ($post_time < $post_created_spent_minutes && !$this->IsSkipped($entity, $post->id))
                            $result [] = $post;

                    } else {
                        $post->full = 1;
                        $post->update(array('full'));
                    }
                } else {
                    $post->full = 1;
                    $post->update(array('full'));
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
        $model->user_id = $this->user_id;
        $model->way [] = get_class($model);
        if (count($model->way) > 10) {
            $this->error = 'Не найдены тема для комментирования, обратитесь к разработчику';
            return false;
        }
        return $model->getPost();
    }

    public function logState($posts_count)
    {
        $this->way [] = get_class($this);

        $fh = fopen($dir = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'commentators_log.txt', 'a');
        fwrite($fh, get_class($this) . ', user_id: ' . $this->user_id . " posts_count: " . $posts_count . "\n");
    }
}