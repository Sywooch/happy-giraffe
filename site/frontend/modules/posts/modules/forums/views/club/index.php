<?php
/**
 * @var site\frontend\modules\posts\modules\forums\controllers\DefaultController $this
 * @var string $feedTab
 * @var null|Community $feedForum
 */
$this->pageTitle = $this->club->title;
if (count($this->actionParams) > 1) { // если переданы параметры помимо обязательного $club
    $this->metaNoindex = true;
}
?>

<?php $this->widget('site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget', [
    'club' => $this->club,
    'forum' => $feedForum,
    'tab' => $feedTab,
]); ?>