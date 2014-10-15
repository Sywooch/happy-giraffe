<?php
$this->pageTitle = 'Как выбрать  ' . $model->title_accusative;

$this->breadcrumbs = array(
    'Кулинария' => array('/cook/default/index'),
    'Как выбрать продукты?' => array('/cook/choose/index'),
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

            <div class="clearfix">

                <div class="product-choose-img">
                    <img src="<?= isset($model->photo) ? $model->photo->getPreviewUrl(273, 259, Image::WIDTH) : '' ?>"/>
                </div>

                <div class="wysiwyg-content" class="clearfix">
                    <i><?= $model->description; ?></i>
                </div>

            </div>

            <div class="wysiwyg-content" class="clearfix">
                <?= $model->description_center; ?>
            </div>

            <div class="product-choose-cat-list">

                <ul>
                    <?php
                    foreach ($model->chooses as $product)
                    {
                        $url = $this->createUrl('view', array('id' => $product->slug));
                        $src = isset($product->photo) ? $product->photo->getPreviewUrl(120, 130, Image::HEIGHT) : '';
                        echo '<li><a href="' . $url . '"><img src="' . $src . '"/>Как выбрать ' . $product->title_accusative . '</a></li>';
                    }
                    ?>
                </ul>

            </div>


            <div class="wysiwyg-content">
                <?= $model->description_extra; ?>
            </div>

        </div>

        <div class="product-choose-categories">
            <?php $this->renderPartial('_categories', array('category_slug' => $_GET['id'])); ?>
        </div>

    </div>

</div>