<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\posts\models\Content;

class PostContentAction extends RoutedAction
{
    public function run()
    {
        $this->route('getPostsContent', 'getPostsContent', 'getPostsContent', 'getPostsContent');
    }

    public function getPostsContent() {
        $this->controller->get(Content::model());
    }
}