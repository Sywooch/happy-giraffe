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
        <?php if ($model->id == CookRecipeTag::TAG_VALENTINE):?>
            <span class="cook-cat active"><i class="ico-valentine-heart"></i></span>
        <?php endif ?>
        <span class="cook-title-cat-h1-text"><?= $model->title; ?></span>
    </h1>
    <?php if (!$hide_text):?>
        <p><?=strip_tags($model->description) ?></p>
    <?php endif ?>
</div>
<?php

if (!$hide_text)
    $story = '<div class="giraffe-story">
            <div class="giraffe-story-frame">
                <div class="giraffe-story-holder clearfix">
                <div class="giraffe-story-title"><span>'.$model->text_title.'</span></div>
                    <div class="giraffe-story-img">
                        <img src="/images/giraffe-story-logo.png" alt="">
                    </div>
                    <div class="giraffe-story-text">
                        '.$model->text.'
                    </div>
                </div>
            </div>
        </div>';
else
    $story = '';

$this->widget('LiteListView', array(
        'dataProvider' => $dp,
        'itemView' => '_recipe',
        'tagName' => 'div',
        'htmlOptions' => array(
            'class' => 'b-main_col-article'
        ),
        'itemsTagName' => 'div',
        'template' => '{items}'.$story.'<div class="yiipagination yiipagination__center">{pager}</div>',
        'pager' => array(
            'class' => 'LitePager',
            'maxButtonCount' => 10,
            'prevPageLabel' => '&nbsp;',
            'nextPageLabel' => '&nbsp;',
            'showPrevNext' => true,
        ),
    ));