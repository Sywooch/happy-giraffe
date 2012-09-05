<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class CoWorkersPosts extends PostForCommentator
{
    protected $entities = array(
        'CommunityContent' => array(10),
        'CookRecipe' => array(2, 3),
    );
    protected $nextGroup = 'ZeroCommentsPosts';

    public function getPost()
    {
        Yii::import('site.frontend.modules.cook.models.*');

        $criteria = $this->getCriteria(false);
        $posts = $this->getPosts($criteria);

        $this->logState(count($posts));

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
        $criteria->select = 't.*, `comments`.`id` as comment_id';
        $criteria->condition = 't.created >= "' . date("Y-m-d H:i:s", strtotime('-48 hour')) . '" AND `full` IS NULL AND comments.id IS NULL';
        $criteria->with = array(
            'author' => array(
                'condition' => ($simple_users) ? 'author.group = 0' : 'author.group > 0',
                'together' => true,
            ),
        );
        $criteria->join = 'LEFT OUTER JOIN `comments` `comments` ON (`comments`.`entity_id`=`t`.`id` AND `comments`.`author_id` = '.$this->user_id.') ';

        return $criteria;
    }
}
