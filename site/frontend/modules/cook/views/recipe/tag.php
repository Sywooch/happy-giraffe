<?php
/* @var $this Controller
 * @var $model CookRecipeTag
 */
if (!empty($_GET['type']) || !empty($_GET['SimpleRecipe_page']))
    $hide_text = true;
else
    $hide_text = false;

if ($hide_text)
    Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

?><div class="cook-title-cat">
    <h1 class="cook-title-cat-h1">
        <span class="cook-title-cat-h1-text"><?= $model->title; ?></span>
    </h1>
    <?php if (!$hide_text):?>
        <p><?=$model->description ?></p>
    <?php endif ?>
</div>
<?php $this->widget('zii.widgets.CListView', array(
    'ajaxUpdate' => false,
    'dataProvider' => $dp,
    'itemView' => '_recipe',
    'summaryText' => 'Показано: {start}-{end} из {count}',
    'pager' => array(
        'class' => 'AlbumLinkPager',
    ),
    'template' => '{items}
            <div class="pagination pagination-center clearfix">
                {pager}
            </div>
        ',
)) ?>
<?php if (!$hide_text):?>
    <div class="giraffe-story">
        <div class="giraffe-story-frame">
            <div class="giraffe-story-title"><?=$model->text_title ?></div>
            <div class="giraffe-story-holder clearfix">
                <div class="giraffe-story-img">
                    <img src="/images/giraffe-story-logo.png" alt="">
                </div>
                <div class="giraffe-story-text">
                    <?=$model->text ?>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>