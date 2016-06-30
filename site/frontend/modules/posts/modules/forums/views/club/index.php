<?php
/**
 * @var site\frontend\modules\posts\modules\forums\controllers\DefaultController $this
 * @var string $feedTab
 * @var null|Community $feedForum
 */
$this->pageTitle = $this->club->title;
?>

<?php $this->widget('site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget', [
    'club' => $this->club,
    'forum' => $feedForum,
    'tab' => $feedTab,
]); ?>