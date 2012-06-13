<div id="product-choose">

    <div class="title">

        <h2>Как выбрать продукты?</h2>

    </div>

    <div class="clearfix">

        <div class="product-choose-in">

            <h1>Как выбрать <?=$model->title_accusative;?></h1>

            <div class="clearfix">

                <div class="product-choose-img">

                    <img src="<?=isset($model->photo) ? $model->photo->getPreviewUrl(273, 259, Image::WIDTH) : '' ?>"/>

                </div>

                <div class="wysiwyg-content" class="clearfix">


                    <?=$model->description_extra;?>


                </div>
            </div>

            <div class="product-choose-cat-list">

                <ul>
                    <?php
                    foreach($model->chooses as $product){

                    }
                    ?>
                    <li>
                        <a href="">
                            <img src="/images/product_choose_cat_img_01.jpg"/>
                            Как выбрать шампанское
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="/images/product_choose_cat_img_02.jpg"/>
                            Как выбрать вино
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="/images/product_choose_cat_img_03.jpg"/>
                            Как выбрать водку
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="/images/product_choose_cat_img_01.jpg"/>
                            Как выбрать шампанское
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="/images/product_choose_cat_img_02.jpg"/>
                            Как выбрать вино
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="/images/product_choose_cat_img_03.jpg"/>
                            Как выбрать водку
                        </a>
                    </li>

                </ul>

            </div>


            <div class="wysiwyg-content">
                <?=$model->description_extra;?>
            </div>


        </div>

        <div class="product-choose-categories">
            <?php $this->renderPartial('_categories'); ?>
        </div>

    </div>

</div>