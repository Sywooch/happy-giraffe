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

    public function getPost()
    {
        $this->way [] = 'UserPostForCommentator';

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

    public function nextGroup()
    {
        $model = new MainPagePostForCommentator;
        $model->skipUrls = $this->skipUrls;
        $model->way [] = get_class($model);
        if (count($model->way) > 10){
            var_dump($model->way);
            Yii::app()->end();
        }
        return $model->getPost();
    }
}
