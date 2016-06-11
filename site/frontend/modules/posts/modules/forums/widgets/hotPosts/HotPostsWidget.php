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
        $posts = $this->getPosts();
        if (! empty($posts)) {
            $this->render('index', compact('posts'));
        }
    }

    protected function getPosts()
    {
        $model = Content::model()
            ->orderHotRate()
            ->with(['commentsCount', 'commentatorsCount'])
            ->apiWith('user')
        ;
        if (false && ! empty($this->labels)) {
            $model->byLabels($this->labels);
        }
        return $model->findAll(['limit' => $this->limit]);
    }
}