<?php

$this->widget('site\frontend\modules\som\modules\activity\widgets\ActivityWidget', array(
    'pageVar'  => 'page',
    'view'     => 'site.frontend.modules.posts.modules.blogs.widgets.feed.views._comments',
    'pageSize' => $perPage,
    'criteria' => $criteria,
));

?>