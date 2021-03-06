<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class CoWorkersPosts extends PostForCommentator
{
    protected $entities = array(
        'CommunityContent' => 10,
        'CookRecipe' => 3,
    );
    protected $nextGroup = 'ZeroCommentsPosts';

    public function getPost()
    {
        Yii::import('site.frontend.modules.cook.models.*');

        $criteria = $this->getCriteria(false);
        $posts = $this->getPosts($criteria, true);

        $this->logPostsCount(count($posts));

        if (count($posts) == 0) {
            return $this->nextGroup();
        } else {
            return array(get_class($posts[0]), $posts[0]->id);
        }
    }

    /**
     * @param bool $simple_users
     * @return CDbCriteria
     */
    public function getCriteria($simple_users = true)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 't.created >= "' . date("Y-m-d H:i:s", strtotime('-48 hour')) . '" AND `full` IS NULL AND t.author_id != '.$this->commentator->user_id. ' AND t.removed = 0';
        $criteria->with = array(
            'author' => array(
                'select'=>array('id'),
                'condition' => ($simple_users) ? 'author.group = 0' : 'author.group > 0',
                'together' => true,
            ),
        );

        return $criteria;
    }
}
