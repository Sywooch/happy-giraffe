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
            <div class="ava <?php echo ($data->user->gender == 1)?'male':'female' ?> avatar">

            </div>
            <a class="username"><?php echo $data->user->first_name.' '.$data->user->last_name ?></a>
        </div>

        <div class="meta">
            <div class="time"><?php echo Yii::app()->dateFormatter->format('d MMMM y, H:m', strtotime($data->create_time)) ?></div>
            <div class="seen">Просмотров:&nbsp;<span><?php echo $data->views_amount ?></span></div>

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