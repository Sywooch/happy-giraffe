<?php
$categories = CookDecorationCategory::model()->findAll();

$entity_id = ($id) ? $category->id : null;
$this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
    'selector' => '.img > a',
    'entity' => 'CookDecorationCategory',
    'entity_id' => $entity_id,
));

Yii::app()->clientScript->registerScript('photo_gallery_entity_id', 'var photo_gallery_entity_id = "' . $entity_id . '";');

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
                'itemsTagName' => 'ul'

            ));
            ?>


        </div>

        <?php
        $this->widget('PhotosAjaxMasonry', array(
                'dataProvider' => $dataProvider,
                'controller' => $this,

                /* настройки аналогичные photoViewWidget
                нужно для навешивания галереи после аякс подгрузки */
                'gallerySelector' => '.img > a',
                'galleryEntity' => 'CookDecorationCategory',
                'galleryEntity_id' => $entity_id,
                'galleySinglePhoto' => false,

                /* настройки для jquery плагина masonry (выравнивание элементов по высоте) */
                'masonryContainerSelector' => '#decorlv ul.items',
                'masonryItemSelector' => 'li',
                'masonryColumnWidth' => 240
            )
        );
        ?>

    </div>

</div>