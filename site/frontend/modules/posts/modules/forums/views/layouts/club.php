<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\controllers\ClubController
 */
?>

<?php $this->beginContent('//layouts/lite/main'); ?>

<div class="forum-page">
    <?php $this->renderPartial('/_club_top', ['club' => $this->club]); ?>
    <div class="b-main_cont b-main_cont-mobile">
        <div class="b-main-wrapper">
            <?=$content?>
            <aside class="b-main_col-sidebar visible-md">
                <div class="sidebar-widget__padding">
                    <div class="textalign-c">
                        <a class="btn btn-success btn-xl btn-question w-240 fancy-top" href="<?=$this->createUrl('/blog/default/form', [
                            'type' => CommunityContent::TYPE_POST,
                            'club_id' => $this->club->id,
                            'useAMD' => true,
                            'short' => true,
                        ])?>">Добавить тему</a>
                    </div>
                    <div class="questions-categories">
                        <?php $this->widget('\site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget', [
                            'labels' => [
                                \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                            ],
                        ]); ?>
                    </div>
                    <div class="margin-t30">
                        <?php $this->widget('site\frontend\modules\posts\modules\forums\widgets\hotPosts\HotPostsWidget', [
                            'labels' => [
                                \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                            ],
                            'allUrl' => $this->createUrl('/posts/forums/club/index', [
                                'club' => $this->club->slug,
                                'feedTab' => \site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget::TAB_HOT,
                            ]),
                        ]); ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>
