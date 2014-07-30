<?php
/**
 * @var RecipeBookDiseaseCategory[] $categories
 */
?>

<div class="b-main_row b-main_row__green clearfix">
    <div class="b-main_cont">
        <div class="tx-content">
            <p>Эти народные рецепты по крупинкам собирались нашими пользователями с разных источников. Недееемся вы найдете в них полезную информацию для любой болезни.</p>
        </div>
        <ul class="col-link">
            <?php foreach ($categories as $category): ?>
                <li class="col-link_li"><a href="" class="col-link_a"><?=$category->title?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>