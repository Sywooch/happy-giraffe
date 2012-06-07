<?php
$categories = CookDecorationCategory::model()->findAll();
?>
<div id="dishes">

    <div class="title">

        <h2>Оформление <span>блюд</span></h2>

    </div>

    <div class="dishes-cats clearfix">
        <ul>
            <li>
                <span class="valign"></span>
                <a href="<?=CHtml::normalizeUrl(array('index'))?>" class="cook-cat">
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

            <div class="add-photo">
                Нашли интересное оформление или<br/>хотите похвастаться своим творением<br/>
                <!--<a href="#photoPick" class="btn btn-green fancy"><span><span>Добавить фото</span></span></a>-->
                <?php
                $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                    'model' => new CookDecoration(),
                ));
                $fileAttach->button();
                $this->endWidget();
                ?>
            </div>
            <?='<h1>Как можно оформить ' . (($id) ? $category->title_h1 : 'блюда') . '</h1>';?>


        </div>

        <ul>
            <?php


            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'ajaxUpdate' => false,
                'itemView' => '_decoration', // refers to the partial view named '_post'
                'emptyText' => 'В этой рубрике еще нет фотографий',
                'summaryText' => '',
                'pager' => array(
                    'class' => 'AlbumLinkPager',
                ),
                'template' => '<div class="clearfix">{items}</div>
                    <div class="pagination pagination-center clearfix">
                        {pager}
                    </div>',
            ));
            ?>
        </ul>

    </div>

</div>