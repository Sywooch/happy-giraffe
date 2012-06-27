<?php
/* @var $this Controller
 * @var $model RecipeBookDiseaseCategory
 */
?>

<h1><?=$model->title ?></h1>

<div class="disease-img">
    <img src="<?=isset($model->photo) ? $model->photo->getPreviewUrl(500, 500, Image::WIDTH) : '' ?>"/>
</div>

<div class="wysiwyg-content">

    <p><em><?=$model->description;?></em></p>

</div>

<div class="wysiwyg-content clear">

    <?=$model->description_center;?>

</div>

<div class="disease-abc clearfix">

    <div class="block-title"><?=$model->title_all ?></div>

    <?php
    $qnty = count($model->diseases);
    $per_column = ceil($qnty / 3);
    $i = 1;
    ?>
    <ul>
        <li>
            <ul>
                <?php
                foreach ($model->diseases as $diseases) {
                    ?>

                    <li><a href="<?=$this->createUrl('view', array('id' => $diseases->slug));?>"><?=$diseases->title;?></a></li>

                    <?php
                    if (($i % $per_column) == 0)
                        echo "</ul></li><li><ul>";
                    $i++;
                }
                ?>
            </ul>
        </li>
    </ul>

</div>

<div class="wysiwyg-content">
    <?=$model->description_extra;?>
</div>

