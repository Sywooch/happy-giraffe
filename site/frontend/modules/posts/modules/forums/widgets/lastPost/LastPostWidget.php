<?php

namespace site\frontend\modules\posts\modules\forums\widgets\lastPost;
use site\frontend\components\api\models\User;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

/**
 * @author Никита
 * @date 27/10/15
 */

class LastPostWidget extends \CWidget
{
    public $limit = 3;

    public function run()
    {
        $posts = $this->getPosts();
        if (! empty($posts)) {
            $this->render('view', compact('posts'));
        }
    }

    protected function getPosts()
    {
        return Content::model()->orderDesc()->byLabels([Label::LABEL_FORUMS])->with('commentsCount', 'commentatorsCount')->apiWith('user')->findAll(['limit' => $this->limit]);
    }
}