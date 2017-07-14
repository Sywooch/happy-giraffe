<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\controllers\ClubController $this
 */
?>

<?php $this->beginContent('//layouts/lite/main'); ?>

<div class="forum-page">
    <?php $this->renderPartial('_club_top', ['club' => $this->club, 'forum' => $this->forum]); ?>
    <div class="b-main_cont b-main_cont-mobile">
        <div class="b-main-wrapper">
            <?=$content?>
            <aside class="b-main_col-sidebar visible-md">
                <div class="sidebar-widget__padding">
                    <div class="textalign-c">
                        <?php if (Yii::app()->user->isGuest): ?>
                            <a class="btn green-btn btn-xl btn-question login-button" data-bind="follow: {}">Добавить тему</a>
                        <?php else: ?>
                            <a class="btn green-btn btn-xl btn-question is-need-loading" href="<?=$this->createUrl('/posts/forums/posts/AddForm', [
                                'club_id' => $this->club->id
                            ])?>">Добавить тему</a>
                        <?php endif; ?>
                    </div>
                    <div class="questions-categories">
                        <?php if ($this->beginCache('UsersTopWidget', array('duration' => 300))) { $this->widget('\site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget', [
                            'labels' => [
                                \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                            ],
                        ]); $this->endCache(); } ?>
                    </div>
                    <div class="margin-t30 b-widget-wrapper_border">
                        <?php if ($this->beginCache('HotPostsWidget', array('duration' => 300))) { $this->widget('site\frontend\modules\posts\modules\forums\widgets\hotPosts\HotPostsWidget', [
                            'labels' => [
                                \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                            ],
                        ]); $this->endCache(); } ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>
