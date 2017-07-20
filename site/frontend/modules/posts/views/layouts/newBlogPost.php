<?php
$this->bodyClass .= ' page-blog';
$this->beginContent('//layouts/lite/main');
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <?php
        echo $content;
        ?>
        <aside class="b-main_col-sidebar visible-md">
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
