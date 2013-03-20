<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 *
 * Компонент ищет пост для комментирования
 *
 */
class PostForCommentator
{
    protected $entities = array();
    protected $nextGroup = 'UserPosts';
    protected $comments_limit = 15;
    protected $error = '';
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
        Yii::import('site.common.models.mongo.*');

        $model = new PostForCommentator;
        $model->commentator = $commentator;
        return $model->nextPost();
    }

    public function nextPost()
    {
        $model = new FavouritesPosts();
        $model->commentator = $this->commentator;

        return $model->getPost();
    }

    /**
     * Получить посты для типа, используется потомками
     *
     * @return array|bool
     */
    protected function getPost()
    {
        $criteria = $this->getCriteria();
        if ($criteria === null)
            return $this->nextGroup();

        $posts = $this->getPosts($criteria, true);
        $this->logPostsCount(count($posts));

        if (count($posts) == 0) {
            return $this->nextGroup();
        } else {
            return array(get_class($posts[0]), $posts[0]->id);
        }
    }

    /**
     * Возвращает пост для комментирования по переданному criteria
     * Проводит проверки
     * 1. Комментатор еще не комментировал этот пост
     * 2. Автор поста не входит в блок-лист комментатора (когда-либо удалял комментарии комментатора)
     * 3. Лимит комментариев не достигнут
     *
     * @param CDbCriteria $criteria
     * @param bool $one_post возвратить один пост или все найденные
     * @return CActiveRecord[]
     */
    public function getPosts($criteria, $one_post = false)
    {
        $result = array();

        foreach ($this->entities as $entity => $limit) {
            $posts = CActiveRecord::model($entity)->resetScope()->findAll($criteria);
            $this->logState(count($posts));

            foreach ($posts as $post) {
                //check ignore users
                if (!empty($this->commentator->ignoreUsers) && in_array($post->author_id, $this->commentator->ignoreUsers))
                    continue;

                //Комментатор еще не комментировал этот пост
                if ($this->alreadyCommented($post))
                    continue;

                if ($post->commentsCount < $this->getCommentsLimit($post)) {
                    if ($one_post)
                        return array($post);
                    $result [] = $post;
                } else {
                    $post->full = 1;
                    $post->update(array('full'));
                }
            }
        }
        shuffle($result);
        return $result;
    }

    /**
     * Проверяет комментировался ли пост
     *
     * @param HActiveRecord $post
     * @return bool
     */
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

    /**
     * Проверяет не находится ли пост в списке пропущенных комментатором
     *
     * @param $entity
     * @param $entity_id
     * @return bool
     */
    public function IsSkipped($entity, $entity_id)
    {
        foreach ($this->commentator->skipUrls as $skipped) {
            if ($skipped[0] == $entity && $skipped[1] == $entity_id)
                return true;
        }

        return false;
    }

    /**
     * Перейти к следующему типу поиска поста, если в текущем ничего не найдено
     *
     * @return bool
     */
    public function nextGroup()
    {
        $model = new $this->nextGroup;
        $model->commentator = $this->commentator;
        return $model->getPost();
    }

    /**
     * Возвращает лимит комментариев для данного поста
     *
     * @param CActiveRecord $post
     * @return int
     */
    protected function getCommentsLimit($post)
    {
        return $this->comments_limit;
    }

    /**
     * Логирование кол-ва найденных постов
     *
     * @param $posts_count
     */
    public function logPostsCount($posts_count)
    {
        $this->log("posts_count: " . $posts_count);
    }

    /**
     * Логирование событий
     *
     * @param $state
     */
    public function log($state)
    {
        $fh = fopen($dir = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'commentators_log.txt', 'a');
        fwrite($fh, 'user_id: ' . $this->commentator->user_id . ", message: " . $state . "\n");
    }
}