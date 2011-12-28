<?php
/* @var $this Controller
 * @var $data RecipeBookRecipe
 */
?>
<div class="entry entry-full">

    <div class="entry-header">
        <a href="<?php echo $this->createUrl('/recipeBook/default/view', array('id'=>$data->id))
            ?>"><h1><?php echo $data->name ?></h1></a>
        <div class="user">
            <div class="ava female 	avatar">

            </div>
            <a class="username">Светлана</a>
        </div>

        <div class="meta">
            <div class="time">3 сентября 2011, 08:25</div>
            <div class="seen">Просмотров:&nbsp;<span>265</span></div>

        </div>
        <div class="clear"></div>
    </div>

    <div class="entry-content">
        <div class="rec_in">
            <div>
                <span>Ингредиенты:</span>
                <ul>
                    <?php foreach ($data->ingredients as $ingredient): ?>
                        <li><a href="#"><?php echo $ingredient->name ?></a> <?php echo 'x '.$ingredient->amount ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div><!-- .rec_in -->
        <?php echo $data->text ?>
        <div class="clear"></div>
    </div>

    <div class="entry-footer">
        <div class="source">Источник:&nbsp;
            <?php if ($data->source_type == 'internet'):?>
            <img src="<?php echo $data->internet_favicon ?>">&nbsp;
            <a href="<?php echo $data->internet_link ?>" class="link"><?php echo $data->internet_title ?></a>&nbsp;
            <?php endif ?>
            <?php if ($data->source_type == 'me'):?>
            личный опыт
            <?php endif ?>
            <?php if ($data->source_type == 'book'):?>
            <?php echo $data->book_author.' &laquo;'.$data->book_name.'&raquo;' ?>
            <?php endif ?>
        </div>
        <span class="comm">Отзывов: <span>2</span></span>
        <div class="spam">
            <a href=""><span>Нарушение!</span></a>
        </div>
        <div class="clear"></div>
        <div class="art_lk_recipes">
            <ul class="quest_fun">
                <li><span>Считаете ли Вы полезным этот рецепт?</span></li>
                <li class="agree_u"><a href="#">Да</a></li>
                <li class="disagree_u"><a href="#">Нет</a></li>
            </ul>
        </div><!-- .art_lk_recipes -->
    </div>
</div>