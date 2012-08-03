<?php
/**
 * @var $models CommunityContent[]
 */
?>
<div class="box homepage-most">

    <div class="title">Самое-самое <span>интересное</span></div>

    <ul>
        <?php foreach ($models as $model): ?>
        <li>
                <?php
                echo CHtml::link($model->title, $model->url);

                $image = $model->getContentImage();
                if ($image)
                    echo CHtml::link(CHtml::image($image, $model->title), $model->url);
                else
                    echo  $model->getContentText(250);
                ?>
        </li>
        <?php endforeach; ?>
    </ul>

</div>