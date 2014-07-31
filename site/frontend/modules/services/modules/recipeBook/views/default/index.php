<?php
/**
 * @var RecipeBookDiseaseCategory[] $categories
 * @var CActiveDataProvider $dp
 * @var int|null $disease
 * @var string|null $slug
 */
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <div class="b-main_col-article">
            <h1 class="heading-link-xxl">Народные рецепты</h1>
        </div>
    </div>
</div>
<div class="b-main_row b-main_row__green clearfix">
    <div class="b-main_cont">
        <div class="tx-content">
            <p>Эти народные рецепты по крупинкам собирались нашими пользователями с разных источников. Недееемся вы найдете в них полезную информацию для любой болезни.</p>
        </div>
        <?php if ($slug === null): ?>
        <ul class="col-link">
            <?php foreach ($categories as $category): ?>
                <li class="col-link_li"><a href="<?=$category->getUrl()?>" class="col-link_a"><?=$category->title?></a></li>
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
                    'showDisease' => $diseaseId === null,
                ),
            ));
            ?>
        </div>
    </div>
</div>