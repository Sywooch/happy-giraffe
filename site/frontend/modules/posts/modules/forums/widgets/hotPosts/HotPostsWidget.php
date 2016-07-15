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

    protected $interval;

    public function init()
    {
        $this->interval = 3 * 24 * 60 * 60;
        parent::init();
    }

    public function run()
    {
        $posts = $this->getPosts();
        if (! empty($posts)) {
            $this->render('index', compact('posts'));
        }
    }

    protected function getPosts()
    {
        /** @var Content $model */
        $model = Content::model()
            ->orderHotRate()
            ->with(['commentsCount', 'commentatorsCount'])
            ->apiWith('user')
        ;
        if (! empty($this->labels)) {
            $model->byLabels($this->labels);
        }
        return $model->findAll([
            'limit' => $this->limit,
            'join' => 'JOIN post__tags pt ON pt.contentId = ' . $model->tableAlias . '.id JOIN post__labels pl ON pl.id = pt.labelId AND pl.text LIKE "Клуб:%"',
            'group' => 'pl.id',
            'condition' => 'dtimePublication > :dtimeThreshold',
            'params' => [
                'dtimeThreshold' => time() - $this->interval,
            ],
        ]);
    }
}