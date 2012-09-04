<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class UserPostForCommentator extends PostForCommentator
{
    protected $entities = array(
        'CommunityContent' => array(50),
        'CookRecipe' => array(8, 12),
    );
    protected $nextGroup = 'MainPagePostForCommentator';

    public function getPost()
    {
        $this->way [] = get_class($this);

        $criteria = $this->getCriteria();
        $posts = $this->getPosts($criteria);

        if (count($posts) == 0) {

            if ($this->isCategoryEmpty())
                return $this->nextGroup();
            else
                return $this->getPost();
        } else {

            return array(get_class($posts[0]), $posts[0]->id);
        }
    }
}
