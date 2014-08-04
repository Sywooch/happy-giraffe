<?php
/**
 * @var CActiveDataProvider $dp
 * @var array $links
 */
Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <div class="b-main_col-article">
            <h1 class="heading-link-xxl"><?=$title?></h1>
        </div>
    </div>
</div>
<div class="b-main_row b-main_row__green clearfix">
    <div class="b-main_cont">
        <div class="tx-content">
            <p>Эти народные рецепты по крупинкам собирались нашими пользователями с разных источников. Недееемся вы найдете в них полезную информацию для любой болезни.</p>
        </div>
        <?php if (! empty($links)): ?>
        <ul class="col-link">
            <?php foreach ($links as $title => $url): ?>
                <li class="col-link_li"><a href="<?=$url?>" class="col-link_a"><?=$title?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</div>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <div class="b-main_col-article">
            <?php
            $this->widget('LiteListView', array(
                'dataProvider' => $dp,
                'itemView' => '_recipe',
                'viewData' => array(
                    'showDisease' => Yii::app()->controller->action->id != 'disease',
                ),
            ));
            ?>
        </div>
    </div>
</div>