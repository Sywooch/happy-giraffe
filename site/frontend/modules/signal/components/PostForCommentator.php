<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class PostForCommentator
{
    protected $entities = array();
    protected $way = array();
    protected $nextGroup = 'UserPosts';
    protected $error = '';
    public $times = array(10, 8, 8, 8);
    /**
     * @var CommentatorWork
     */
    protected $commentator;

    /**
     * @param CommentatorWork $commentator
     * @return array|bool
     */
    public static function getNextPost($commentator)
    {
        $model = new PostForCommentator;
        $model->commentator = $commentator;
        return $model->nextPost();
    }

    public function nextPost()
    {
        $model = new UserPosts();
        $model->commentator = $this->commentator;
        $post = $model->getPost();

        if (!empty($model->error))
            $this->log($model->error);

        if (is_array($post))
            $this->log($post[0].' '.$post[1]);
        else
            $this->log('post is not array');

        $this->error = $model->error;
        return $post;
    }

    /**
     * @param CDbCriteria $criteria
     * @param bool $one_post
     * @return CActiveRecord[]
     */
    public function getPosts($criteria, $one_post = false)
    {
        $result = array();

        foreach ($this->entities as $entity => $limits) {
            $posts = CActiveRecord::model($entity)->resetScope()->findAll($criteria);

            $this->logState(count($posts));

            foreach ($posts as $post) {
                //check ignore users
                if (!empty($this->commentator->ignoreUsers) && in_array($post->author_id, $this->commentator->ignoreUsers))
                    continue;

                //check already comment
                if ($this->alreadyCommented($post))
                    continue;

                list($count_limit, $post_time) = CommentsLimit::getLimit($entity, $post->id, $limits, $this->times);

                if (isset($post_time[$post->commentsCount])) {
                    $post_time = $post_time[$post->commentsCount];
                    $post_created_spent_minutes = round((time() - strtotime($post->created)) / 60);

                    if ($post->commentsCount < $count_limit) {
                        if ($post_time < $post_created_spent_minutes && !$this->IsSkipped($entity, $post->id)){
                            if ($one_post)
                                return array($post);
                            $result [] = $post;
                        }

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

    public function alreadyCommented($post)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->commentator->user_id);
        $criteria->compare('entity_id', $post->id);
        if (get_class($post) == 'CommunityContent')
            $criteria->compare('entity', array('CommunityContent', 'BlogContent'));
        else
            $criteria->compare('entity', get_class($post));
        $model = Comment::model()->resetScope()->find($criteria);

        return $model !== null;
    }

    public function IsSkipped($entity, $entity_id)
    {
        foreach ($this->commentator->skipUrls as $skipped) {
            if ($skipped[0] == $entity && $skipped[1] == $entity_id)
                return true;
        }

        return false;
    }

    public function nextGroup()
    {
        $model = new $this->nextGroup;
        $model->commentator = $this->commentator;
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
        fwrite($fh, get_class($this) . ', user_id: ' . $this->commentator->user_id . " posts_count: " . $posts_count . "\n");
    }

    public function log($state)
    {
        $fh = fopen($dir = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'commentators_log.txt', 'a');
        fwrite($fh, 'user_id: ' . $this->commentator->user_id . ", message: " . $state . "\n");
    }
}