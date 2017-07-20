<?php

$this->bodyClass .= ' page-community';
$this->beginContent('//layouts/lite/community');

?>

<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <?php
        echo $content;
        ?>
        <aside class="b-main_col-sidebar visible-md">
            <?php if ($this->club): ?>
                <div class="clearfix margin-b20 textalign-c">
                    <?php if (Yii::app()->user->isGuest): ?>
                        <a class="btn green-btn btn-xl login-button" data-bind="follow: {}">Добавить тему</a>
                    <?php else: ?>
                        <a class="btn green-btn btn-xl fancy-top is-need-loading" href="<?=$this->createUrl('/blog/default/form', [
                            'type' => CommunityContent::TYPE_POST,
                            'club_id' => $this->club->id,
                            'useAMD' => true,
                            'short' => true,
                        ])?>">Добавить тему</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($this instanceof site\frontend\modules\posts\controllers\PostController && $this->post->templateObject->getAttr('hideRubrics', false)): ?>
                <div class="side-block onair-min">
                    <div class="side-block_tx">Прямой эфир</div>

                    <?php
                    $this->widget('site\frontend\modules\som\modules\activity\widgets\ActivityWidget', array(
                        'pageVar' => 'page',
                        'view' => 'onair-min',
                        'pageSize' => 5,
                    ));
                    ?>
                </div>

            <?php else: ?>
                <?php if (!($this instanceof site\frontend\modules\posts\controllers\PostController) || (!$this->post->templateObject->getAttr('hideRubrics', false))): ?>
                    <?php
                    // Скрываем блок если отсутствуют клубы
                    if($this->club):?>
                        <div class="side-block rubrics">
                            <div class="side-block_tx">Рубрики клуба</div>
                            <ul>
                                <?php foreach ($this->forum->rubrics as $rubric): ?>
                                    <?php if ($rubric->parent_id === null and $rubric->contentsCount > 0): ?>
                                        <li class="rubrics_li"><a class="rubrics_a" href="<?= $rubric->getUrl() ?>"><?= $rubric->title ?></a>
                                            <div class="rubrics_count"><span class="rubrics_count_tx"><?= \site\frontend\modules\community\helpers\StatsHelper::getRubricCount($rubric->id) ?></span></div>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($this->beginCache('HotPostsWidget', array('duration' => 300))): ?>

                    <div class="side-block">

                    	<?php

                        $this->widget('site\frontend\modules\posts\modules\forums\widgets\hotPosts\HotPostsWidget', [
                            'labels' => [
                                \site\frontend\modules\posts\models\Label::LABEL_FORUMS,
                            ],
                        ]);

                        ?>

                    </div>

                <?php

                $this->endCache();

                endif;

                ?>

            <?php endif; ?>
        </aside>
    </div>
</div>

<?php if (Yii::app()->vm->getVersion() == VersionManager::VERSION_DESKTOP): ?>
    <div class="homepage">
        <div class="homepage_row">
            <div class="homepage-posts">
                <div class="homepage_title">еще рекомендуем</div>
                <div class="homepage-posts_col-hold">

                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php
$this->endContent();
