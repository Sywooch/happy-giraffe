<?php
/**
 * @author Никита
 * @date 07/06/16
 */

namespace site\frontend\modules\posts\modules\forums\widgets\hotPosts;


use site\frontend\modules\posts\models\Content;

class HotPostsWidget extends \CWidget
{
    public $limit = 5;
    public $labels = [];
    
    public function run()
    {
        $this->render('index', ['posts' => $this->getPosts()]);
    }

    protected function getPosts()
    {
        $criteria = new \CDbCriteria();
        $criteria->limit = $this->limit;
        return Content::model()
//            ->byLabels($this->labels)
            ->orderHotRate()
            ->with(['commentsCount', 'commentatorsCount'])
            ->findAll($criteria);
    }
}