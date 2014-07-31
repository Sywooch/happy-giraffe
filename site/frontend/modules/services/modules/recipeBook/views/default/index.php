<?php
/**
 * @var RecipeBookDiseaseCategory[] $categories
 * @var CActiveDataProvider $dp
 * @var string|null $slug
 */
?>

<div class="b-main_row b-main_row__green clearfix">
    <div class="b-main_cont">
        <div class="tx-content">
            <p>Эти народные рецепты по крупинкам собирались нашими пользователями с разных источников. Недееемся вы найдете в них полезную информацию для любой болезни.</p>
        </div>
        <ul class="col-link">
            <?php foreach ($categories as $category): ?>
                <li class="col-link_li"><a href="<?=$category->getUrl()?>" class="col-link_a"><?=$category->title?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <div class="b-main_col-article">
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dp,
                'itemView' => '_recipe',
                'viewData' => array(
                    'showDisease' => $slug === null,
                ),

                'template' => "{items}\n{pager}",
                'itemsTagName' => 'ul',
                'itemsCssClass' => 'traditional-recipes_ul',
                'htmlOptions' => array(
                    'class' => 'traditional-recipes',
                ),
            ));
            ?>
        </div>
    </div>
</div>