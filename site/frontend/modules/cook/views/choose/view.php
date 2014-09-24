<?php
$this->pageTitle = 'Как выбрать ' . $model->title_accusative;

$this->breadcrumbs = array(
    'Кулинария' => array('/cook/default/index'),
    'Как выбрать продукты?' => array('/cook/choose/index'),
    $model->category->title => $model->category->url,
    $model->title,
);
?>
<div id="product-choose">

    <div class="title">

        <h2>Как выбрать продукты?</h2>

    </div>

    <div class="clearfix">

        <div class="product-choose-in">

            <h1>Как выбрать <?= $model->title_accusative; ?></h1>

            <div class="product-choose-img">

                <img src="<?= isset($model->photo) ? $model->photo->getPreviewUrl(350, 350, Image::WIDTH) : '' ?>"/>

            </div>

            <div class="wysiwyg-content clearfix">

                <?= $model->desc; ?>
                <br/>

                <?php
                mb_internal_encoding("UTF-8");
                $kak_viglyadat = (mb_substr($model->title_quality, -2, 2) == 'ки') ? 'Как выглядят' : 'Как выглядит';
                ?>

                <h2><?= $kak_viglyadat ?> <?= $model->title_quality; ?></h2>

                <?= $model->desc_quality; ?>

                <h2><?= $kak_viglyadat ?> <?= $model->title_defective; ?></h2>

                <?= $model->desc_defective; ?>

                <h2>Как проверить <?= $model->title_check; ?></h2>

                <?= $model->desc_check; ?>

            </div>

            <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $model, 'full' => true)); ?>

        </div>

        <div class="product-choose-categories">
            <?php $this->renderPartial('_categories', array('category_slug' => $model->category->slug)); ?>
        </div>

    </div>

</div>