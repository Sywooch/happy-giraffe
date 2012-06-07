<?php
/* @var $this ProductController
 * @var $model Product
 */
?>
<?php Yii::app()->clientScript->registerScriptFile('/javascripts/cloud-zoom.1.0.2.min.js'); ?>
<?php
$this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
    'selector' => '#product-thumbs a',
    'entity' => get_class($model),
    'entity_id' => (int)$model->primaryKey
));

Yii::app()->clientScript->registerScript('product_init', "var slider1 = $('#product-thumbs').jcarousel();
    $('#product .img-thumbs .prev').jcarouselControl({target: '-=1',carousel: slider1});
    $('#product .img-thumbs .next').jcarouselControl({target: '+=1',carousel: slider1});
    var slider2 = $('#else-products-slider').jcarousel({vertical: true});
    $('.buy-else .prev').jcarouselControl({target: '-=1',carousel: slider2});
    $('.buy-else .next').jcarouselControl({target: '+=1',carousel: slider2});");
?>
<div id="product">
    <h1><?php echo $model->product_title; ?></h1>
    <div class="description clearfix">

        <div class="description-img">

            <div class="img-in">
                <?php if($model->main_image && $model->main_image->photo): ?>
                <?php echo CHtml::link(CHtml::image($model->main_image->photo->getPreviewUrl(300, 300, Image::WIDTH, true), $model->product_title), $model->main_image->photo->originalUrl, array(
                    'class' => 'cloud-zoom',
                    'id' => 'zoom1',
                    'rel' => 'adjustX: 40, adjustY:-4',
                )); ?>
                <?php endif; ?>
            </div>


            <div class="img-thumbs" class="jcarousel-container">
                <div id="product-thumbs" class="jcarousel">
                    <ul>
                        <?php foreach ($model->images as $i): ?>
                            <li>
                                <?php echo CHtml::link(CHtml::image($i->photo->getPreviewUrl(76, 79, Image::WIDTH), $model->product_title), $i->photo->originalUrl, array(
                                    'class' => 'cloud-zoom-gallery',
                                    'data-id' => $i->photo->id,
                                    'rel' => 'useZoom: "zoom1", smallImage: "' . $i->photo->getPreviewUrl(300, 300, Image::WIDTH, true) . '"',
                                )); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <a href="javascript:void(0);" class="prev"></a>
                <a href="javascript:void(0);" class="next"></a>

            </div>
            <?php
            if(!Yii::app()->user->isGuest)
            {
                $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                    'model' => $model,
                ));
                $fileAttach->button();
                $this->endWidget();
            }
            ?>
            <div class="color-list">
                <span>Цвет:</span>
                <ul>
                    <li><a href=""><img src="/images/product_color_01.png" /></a></li>
                    <li><a href=""><img src="/images/product_color_02.png" /></a></li>
                    <li><a href=""><img src="/images/product_color_03.png" /></a></li>
                    <li><a href=""><img src="/images/product_color_04.png" /></a></li>
                    <li><a href=""><img src="/images/product_color_05.png" /></a></li>
                    <li><a href=""><img src="/images/product_color_06.png" /></a></li>
                </ul>
            </div>

        </div>

        <div class="description-text">
            <?php if($model->brand): ?>
                <p class="producer">Производитель: <?php echo CHtml::image($model->brand->brand_image->getUrl(), $model->brand->brand_title); ?></p>
            <?php endif; ?>

            <div class="rating">
                <span class="s1"></span>
                <span class="s1"></span>
                <span class="s1"></span>
                <span class="s1"></span>
                <span class="s1"></span>
            </div>

            <p><?php echo nl2br($model->product_text); ?></p>

        </div>
    </div>

    <div class="price-box clearfix">

        <div class="col price">
            Стоимость товара:
            <?php if (intval($model->product_sell_price) || intval(Y::user()->getRate()*100)): ?>
            <span><strike><?php echo intval($model->product_price); ?></strike><span>руб.</span></span>
            <?php else: ?>
            <span><?php echo intval($model->product_price); ?><span>руб.</span></span>
            <?php endif; ?>
        </div>

        <div class="col discount">
            <i class="icon-sale-shock-big"></i>
            <span><?php echo intval($model->product_sell_price); ?><span>руб.</span></span>
            <div class="economy">Экономия: <b><?php echo intval($model->product_price - $model->product_sell_price); ?></b> руб.</div>
        </div>

        <div class="col to-cart">
            Количество: <div class="counter"><a class="dec"></a><input type="text" value="0" /><a class="inc"></a></div>
            <br/>
            <?php echo CHtml::link('<span><span>В корзину</span></span>', array(
                'shop/putIn',
                'id'=>$model->primaryKey,
                'count'=>1,
                ),array(
                'class'=>'btn btn-green-medium fancy',
            )); ?>
            <button class="btn btn-yellow-medium btn-wish-list"><span><span>В список желаний <i class="icon-wish-list"></i></span></span></button>
        </div>
    </div>

    <div class="bonuses-box clearfix">
        <div class="bonus">
            <img src="/images/product_bonus_01.png" />
            <div class="in">
                Бесплатная доставка <a href="">Условия доставки</a><br/>
                <small>(при заказе от 5 000 руб.)</small>
            </div>
        </div>
        <div class="bonus">
            <img src="/images/product_bonus_02.png" />
            <div class="in">
                Гарантированный подарок <a href="">Узнай какой</a>
            </div>
        </div>
    </div>

    <div class="tabs">
        <div class="steps">
            <ul>
                <li class="active"><a href="javascript:void(0);" onclick="setTab(this, 1);"><span>Тех. характеристика</span></a></li>
                <?php if ($model->videos): ?><li><a href="javascript:void(0);" onclick="setTab(this, 2);"><span>Видео о товаре</span></a></li><?php endif; ?>
<!--						<li><a href="javascript:void(0);" onclick="setTab(this, 3);"><span>Доп. информация</span></a></li>-->
            </ul>
        </div>
        <div class="tab-box tab-box-1" style="display:block;">
            <div class="tech">
                <ul>
                    <?php $attributes = $model->getAttributesText(); ?>
                    <li>
                        <ul>
                            <?php $i = 0; foreach ($attributes as $aname => $avalue): ?>
                                <?php if (++$i % 2 == 1): ?>
                                    <li><span class="a-right"><?php echo $avalue; ?></span><span><?php echo $aname; ?></span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <?php $i = 0; foreach ($attributes as $aname => $avalue): ?>
                                <?php if (++$i % 2 == 0): ?>
                                    <li><span class="a-right"><?php echo $avalue; ?></span><span><?php echo $aname; ?></span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
        <?php if ($model->videos): ?>
            <div class="tab-box tab-box-2">
                <div class="videos clearfix">
                    <ul>
                        <?php foreach ($model->videos as $v): ?>
                            <li>
                                <div class="title-box">
                                    <?php echo CHtml::link($v->title, $v->url, array(
                                        'target'=>'_blank',
                                    ));?>
                                </div>
                                <div class="img-box">
                                    <?php echo CHtml::link(CHtml::image($v->preview, $v->title), $v->url, array(
                                        'target'=>'_blank',
                                    )); ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="default-comments">
    <?php $this->widget('application.widgets.commentWidget.CommentWidget', array(
        'model' => $model,
        'title' => 'Отзывы о товаре',
        'button' => 'Добавить отзыв',
        'vote' => true,
        'actions' => false,
    )); ?>
    </div>
</div>