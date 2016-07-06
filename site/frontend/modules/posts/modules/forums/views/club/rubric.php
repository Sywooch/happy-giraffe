<?php
/**
 * @var site\frontend\modules\posts\modules\forums\controllers\ClubController $this
 * @var CommunityRubric $rubric
 * @var CActiveDataProvider $dp
 */
$this->pageTitle = $rubric->title;
$this->metaNoindex = true;
?>

<div class="tabs visible-md clearfix">
    <div class="b-filter-wrapper b-filter-wrapper_pos">
        <span class="b-filter-wrapper__link"><?=$rubric->title?></span>
        <a href="<?=$this->createUrl('/posts/forums/club/index', ['club' => $this->club->slug])?>" class="b-filter-wrapper__close">×</a></div>
</div>

<?php
$this->widget('LiteListView', array(
    'dataProvider' => $dp,
    'itemView' => '/_post',
    'htmlOptions' => [
        'class' => 'b-main_col-article',
    ],
));
?>
