<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class MainPagePostForCommentator extends PostForCommentator
{
    protected $nextGroup = 'SocialPostForCommentator';

    public function getPost()
    {
        $this->way [] = get_class($this);
        $posts = $this->getPosts();

        if (count($posts) == 0)
            return $this->nextGroup();
        else
            return array('CommunityContent', $posts[0]->id);
    }

    public function getPosts()
    {
        $result = array();
        $criteria = $this->getSimpleCriteria();
        $ids = array_merge(Favourites::getIdList(Favourites::BLOCK_INTERESTING)
            + Favourites::getIdList(Favourites::BLOCK_BLOGS));

        if (empty($ids))
            return array();

        $criteria->compare('id', $ids);
        $posts = CommunityContent::model()->active()->findAll($criteria);
        $posts = $this->filterPosts($posts);

        if (count($posts) == 0) {
            //check if all posts count is 0
            $criteria = new CDbCriteria;
            $criteria->condition = $this->maxTimeCondition();
            $criteria->compare('id', $ids);
            $posts = $this->filterPosts(CommunityContent::model()->findAll($criteria));
            if (count($posts) == 0)
                return array();
            else
                return $this->getPosts();
        }

        return $result;
    }

    public function filterPosts($posts)
    {
        $result = array();

        foreach ($posts as $post)
            if (!$this->IsSkipped('CommunityContent', $post->id))
                if ($post->commentsCount < CommentsLimit::getLimit('CommunityContent', $post->id, 40)) {
                    $entity = $post->isFromBlog ? 'BlogContent' : 'CommunityContent';
                    if (!$this->recentlyCommented($entity, $post->id))
                        $result [] = $post;
                }

        return $result;
    }
}
