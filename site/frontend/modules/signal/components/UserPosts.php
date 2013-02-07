<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class UserPosts extends PostForCommentator
{
    protected $entities = array(
        'CommunityContent' => array(24),
        'CookRecipe' => array(2, 3),
    );
    protected $nextGroup = 'FavouritesPosts';

    public function getPost()
    {
        Yii::import('site.frontend.modules.cook.models.*');
        $criteria = $this->getCriteria();
        $posts = $this->getPosts($criteria, false);

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
        $criteria->select = 't.*';
        $criteria->condition = 't.created >= "' . date("Y-m-d H:i:s", strtotime('-48 hour')) . '" AND `full` IS NULL';
        $criteria->with = array(
            'author' => array(
                'select'=>array('id'),
                'condition' => ($simple_users) ? 'author.group = 0' : 'author.group > 0',
                'together' => true,
                'with'=>array('priority')
            ),
        );
        $criteria->order = 'priority.priority desc';
        $criteria->limit = 20;

        return $criteria;
    }
}
