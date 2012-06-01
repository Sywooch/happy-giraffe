<?php
/**
 * @var $model CookSpices
 */
?><div id="spices">

<div class="title">

    <h2>Приправы <span>и специи</span></h2>

</div>

<div class="clearfix">

<div class="spices-in">

    <h1><?=$model->title ?></h1>

    <div class="cat-img"><img src="<?=isset($model->photo)?$model->photo->getOriginalUrl():'' ?>"/></div>

    <div class="wysiwyg-content">

        <?=$model->content ?>

    </div>

    <div class="clearfix">

        <div class="perfect-to">

            <div class="block-title">Отлично<br/>подходит</div>

            <ul>
                <?php foreach ($model->categories as $category): ?>
                    <li>
                        <a href="<?=$this->createUrl('category', array('id'=>$category->id)) ?>" class="cook-cat">
                            <i class="icon-cook-cat icon-spice-<?=$category->id ?>"></i>
                            <span><?=$category->title ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>

        <div class="chef-advice">

            <div class="block-title">Советы от шеф-повара</div>

            <ul>
                <?php $i = 1;foreach ($model->hints as $hint): ?>
                    <li>
                        <div class="num"><?=$i ?></div>
                        <p><?=$hint->content ?></p>
                        <?php $i++ ?>
                    </li>
                <?php endforeach; ?>

            </ul>

        </div>

    </div>

    <div class="cook-more clearfix">

    </div>

</div>

    <div class="spices-categories">
        <?php $this->renderPartial('_categories', array('model' => $category)); ?>
    </div>

</div>

</div>