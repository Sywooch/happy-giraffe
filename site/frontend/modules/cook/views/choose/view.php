<div id="product-choose">

    <div class="title">

        <h2>Как выбрать продукты?</h2>

    </div>

    <div class="clearfix">

        <div class="product-choose-in">

            <h1>Как выбрать <?=$model->title_accusative;?></h1>

            <div class="product-choose-img">

                <img src="<?=isset($model->photo) ? $model->photo->getPreviewUrl(350, 350, Image::WIDTH) : '' ?>"/>

            </div>

            <div class="wysiwyg-content clearfix">

                <?=$model->desc;?>
                <br/>

                <h2>Как выглядит <?=$model->title_quality;?></h2>

                <?=$model->desc_quality;?>

                <h2>Как выглядит <?=$model->title_defective;?></h2>

                <?=$model->desc_defective;?>

                <h2>Как проверить <?=$model->title_check;?></h2>

                <?=$model->desc_check;?>

            </div>

            <?php
            $this->widget('application.widgets.commentWidget.CommentWidget', array('model' => $model,));
            ?>


        </div>

        <div class="product-choose-categories">
            <?php $this->renderPartial('_categories', array('category_slug' => $model->category->slug)); ?>
        </div>

    </div>

</div>