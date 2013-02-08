<?php
/**
 * Author: alexk984
 * Date: 30.08.12
 */
class FavouritesPosts extends PostForCommentator
{
    protected $nextGroup = 'TrafficPosts';
    protected $entities = array(
        'CommunityContent' => array(30),
    );

    public function getPost()
    {
        Yii::import('site.common.models.mongo.*');

        $criteria = $this->getCriteria();
        if ($criteria === null)
            return $this->nextGroup();

        $posts = $this->getPosts($criteria, false);
        $this->logState(count($posts));

        if (count($posts) == 0) {
            return $this->nextGroup();
        } else {
            return array(get_class($posts[0]), $posts[0]->id);
        }
    }

    /**
     * @return CDbCriteria
     */
    public function getCriteria()
    {
        $ids = array_merge(
            Favourites::getIdList(Favourites::BLOCK_INTERESTING, 30)
                + Favourites::getIdList(Favourites::BLOCK_BLOGS, 30)
                + Favourites::getIdList(Favourites::BLOCK_SOCIAL_NETWORKS, 30)
        );
        if (empty($ids))
            return null;

        $criteria = new CDbCriteria;
        $criteria->condition = 't.created >= "' . date("Y-m-d H:i:s", strtotime('-48 hour')) . '" AND `full` IS NULL';
        $criteria->compare('t.id', $ids);

        return $criteria;
    }
}
