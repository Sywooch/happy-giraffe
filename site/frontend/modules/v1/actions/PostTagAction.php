<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\posts\models\Tag;

class PostTagAction extends RoutedAction
{
    public function run()
    {
        $this->route('getPostTag', 'getPostTag', 'getPostTag', 'getPostTag');
    }

    public function getPostTag() {
        $this->controller->get(Tag::model());
    }
}