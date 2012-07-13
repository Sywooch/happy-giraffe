<?php
$categories = CookDecorationCategory::model()->findAll();

/*$this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
    'selector' => '.img > a',
    'entity' => 'Album',
    'entity_id' => $model->id,
));*/

$entity_id = ($id) ? $category->id : null;
$this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
    'selector' => '.img > a',
    'entity' => 'CookDecorationCategory',
    'entity_id' => $entity_id,
));

Yii::app()->clientScript->registerScript('photo_gallery_entity_id', 'var photo_gallery_entity_id = "' . $entity_id . '";');


$cs = Yii::app()->clientScript;

$js =
    <<<EOD
    $(function(){

    var container = $('#decorlv');

    container.imagesLoaded( function(){
        container.masonry({
            itemSelector : 'li',
            columnWidth: 240
        });
    });

});
EOD;

$cs
    ->registerScriptFile('/javascripts/jquery.masonry.min.js')
    ->registerScript('albumView', $js);

?>

<div id="dishes">

<div class="title">

    <h2>Оформление <span>блюд</span></h2>

</div>

<div class="dishes-cats clearfix">

    <ul>
        <li>
            <span class="valign"></span>
            <a href="<?=CHtml::normalizeUrl(array('index'))?>" class="cook-cat <?php if (!$id) {
                echo 'active';
            }?>">
                <i class="icon-cook-cat icon-dish-0"></i>
                <span>Все</span>
            </a>
        </li>
        <?php
        foreach ($categories as $c) {
            $active = ($id == $c->id) ? 'active' : '';
            ?>
            <li>
                <span class="valign"></span>
                <a href="<?=CHtml::normalizeUrl(array('index', 'id' => $c->id));?>" class="cook-cat <?=$active;?>">
                    <i class="icon-cook-cat icon-dish-<?=$c->id;?> active"></i>
                    <span><?=$c->title;?></span>
                </a>
            </li>
            <?php
        }
        ?>
    </ul>

</div>

<div class="dishes-list">

<div class="block-title">

    <?php if (!Yii::app()->user->isGuest) { ?>
    <div class="add-photo">
        Нашли интересное оформление или<br/>хотите похвастаться своим творением?<br/>
        <?php
        $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
            'model' => new CookDecoration(),
            'first_button_class' => 'btn-green',
            'first_button_title' => 'Добавьте фото',
        ));
        $fileAttach->button();
        $this->endWidget();
        ?>
    </div>
    <?php } ?>

    <?='<h1>' . (($id) ? 'Как можно оформить ' . $category->title_h1 : 'Тысяча лучших оформлений блюд') . '</h1>';?>

</div>

<div class="gallery-photos-new cols-4 clearfix">


<?php


$this->widget('zii.widgets.CListView', array(
    'id' => 'decorlv',
    'dataProvider' => $dataProvider,
    'ajaxUpdate' => false,
    'itemView' => '_decoration',
    'emptyText' => 'В этой рубрике еще нет фотографий',
    'summaryText' => '',
    'template' => '{items}',
    'enablePagination' => false,
    'pager' => array(
        'class' => 'AlbumLinkPager',
    ),

    //'tagName' => 'ul',
    'itemsTagName' => 'ul'

));
?>

<!--
<ul>



<li>
    <div class="img">
        <a href="">
            <img src="/images/example/gallery_album_img_01.jpg"/>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="user clearfix">
        <div class="user-info clearfix">
            <a class="ava female small"></a>

            <div class="details">
                <span class="icon-status status-online"></span>
                <a href="" class="username">Александр Богоявленский</a>
            </div>
        </div>
    </div>
    <div class="item-title">Разнообразие десертов сицилийского стиля</div>
</li>
<li>
    <div class="img">
        <a href="">
            <img src="/images/example/gallery_album_img_02.jpg"/>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="user clearfix">
        <div class="user-info clearfix">
            <a class="ava female small"></a>

            <div class="details">
                <span class="icon-status status-online"></span>
                <a href="" class="username">Александр Богоявленский</a>
            </div>
        </div>
    </div>
    <div class="item-title">Разнообразие десертов сицилийского стиля</div>
</li>
<li>
    <div class="img">
        <a href="">
            <img src="/images/example/gallery_album_img_03.jpg"/>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="user clearfix">
        <div class="user-info clearfix">
            <a class="ava female small"></a>

            <div class="details">
                <span class="icon-status status-online"></span>
                <a href="" class="username">Александр Богоявленский</a>
            </div>
        </div>
    </div>
    <div class="item-title">Разнообразие десертов сицилийского стиля</div>
</li>
<li>
    <div class="img">
        <a href="">
            <img src="/images/example/gallery_album_img_04.jpg"/>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="user clearfix">
        <div class="user-info clearfix">
            <a class="ava female small"></a>

            <div class="details">
                <span class="icon-status status-online"></span>
                <a href="" class="username">Александр Богоявленский</a>
            </div>
        </div>
    </div>
    <div class="item-title">Разнообразие десертов сицилийского стиля</div>
</li>
<li>
    <div class="img">
        <a href="">
            <img src="/images/example/gallery_album_img_05.jpg"/>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="user clearfix">
        <div class="user-info clearfix">
            <a class="ava female small"></a>

            <div class="details">
                <span class="icon-status status-online"></span>
                <a href="" class="username">Александр Богоявленский</a>
            </div>
        </div>
    </div>
    <div class="item-title">Разнообразие десертов сицилийского стиля</div>
</li>
<li>
    <div class="img">
        <a href="">
            <img src="/images/example/gallery_album_img_06.jpg"/>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="user clearfix">
        <div class="user-info clearfix">
            <a class="ava female small"></a>

            <div class="details">
                <span class="icon-status status-online"></span>
                <a href="" class="username">Александр Богоявленский</a>
            </div>
        </div>
    </div>
    <div class="item-title">Разнообразие десертов сицилийского стиля</div>
</li>
<li>
    <div class="img">
        <a href="">
            <img src="/images/example/gallery_album_img_07.jpg"/>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="user clearfix">
        <div class="user-info clearfix">
            <a class="ava female small"></a>

            <div class="details">
                <span class="icon-status status-online"></span>
                <a href="" class="username">Александр Богоявленский</a>
            </div>
        </div>
    </div>
    <div class="item-title">Разнообразие десертов сицилийского стиля</div>
</li>
<li>
    <div class="img">
        <a href="">
            <img src="/images/example/gallery_album_img_08.jpg"/>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="user clearfix">
        <div class="user-info clearfix">
            <a class="ava female small"></a>

            <div class="details">
                <span class="icon-status status-online"></span>
                <a href="" class="username">Александр Богоявленский</a>
            </div>
        </div>
    </div>
    <div class="item-title">Разнообразие десертов сицилийского стиля</div>
</li>
<li>
    <div class="img">
        <a href="">
            <img src="/images/example/gallery_album_img_09.jpg"/>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="user clearfix">
        <div class="user-info clearfix">
            <a class="ava female small"></a>

            <div class="details">
                <span class="icon-status status-online"></span>
                <a href="" class="username">Александр Богоявленский</a>
            </div>
        </div>
    </div>
    <div class="item-title">Разнообразие десертов сицилийского стиля</div>
</li>
<li>
    <div class="img">
        <a href="">
            <img src="/images/example/gallery_album_img_10.jpg"/>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="user clearfix">
        <div class="user-info clearfix">
            <a class="ava female small"></a>

            <div class="details">
                <span class="icon-status status-online"></span>
                <a href="" class="username">Александр Богоявленский</a>
            </div>
        </div>
    </div>
    <div class="item-title">Разнообразие десертов сицилийского стиля</div>
</li>
<li>
    <div class="img">
        <a href="">
            <img src="/images/example/gallery_album_img_11.jpg"/>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="user clearfix">
        <div class="user-info clearfix">
            <a class="ava female small"></a>

            <div class="details">
                <span class="icon-status status-online"></span>
                <a href="" class="username">Александр Богоявленский</a>
            </div>
        </div>
    </div>
    <div class="item-title">Разнообразие десертов сицилийского стиля</div>
</li>
<li>
    <div class="img">
        <a href="">
            <img src="/images/example/gallery_album_img_12.jpg"/>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="user clearfix">
        <div class="user-info clearfix">
            <a class="ava female small"></a>

            <div class="details">
                <span class="icon-status status-online"></span>
                <a href="" class="username">Александр Богоявленский</a>
            </div>
        </div>
    </div>
    <div class="item-title">Разнообразие десертов сицилийского стиля</div>
</li>

</ul>
-->
</div>

<a href="" class="more-btn">Показать еще фотографии</a>

</div>

</div>