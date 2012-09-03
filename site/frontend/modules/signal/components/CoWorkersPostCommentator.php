<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class CoWorkersPostCommentator extends PostForCommentator
{
    protected $entities = array(
        'CommunityContent' => array(15),
        'CookRecipe' => array(2, 3),
    );

    public function getPost()
    {
        $this->way [] = 'CoWorkersPostCommentator';

        $criteria = $this->getCriteria(false);
        $posts = $this->getPosts($criteria);

        if (count($posts) == 0) {

            if ($this->isCategoryEmpty(false))
                return $this->nextGroup();
            else
                return $this->getPost();
        } else {
            return array(get_class($posts[0]), $posts[0]->id);
        }
    }

    public function nextGroup()
    {
        $model = new TrafficPostForCommentator;
        $model->skipUrls = $this->skipUrls;
        $model->way [] = get_class($model);
        if (count($model->way) > 10){
            var_dump($model->way);
            Yii::app()->end();
        }
        return $model->getPost();
    }
}
