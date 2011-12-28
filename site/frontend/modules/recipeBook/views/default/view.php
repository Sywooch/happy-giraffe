<?php $this->renderPartial('_left_col',array(
    'cat_diseases' => $cat_diseases,
    'active_disease'=>$active_disease
)); ?>

<div class="right-inner">
    <?php $this->renderPartial('_view',array('data'=>$model)); ?>

    <div class="like-block">
        <div class="block">
            <div class="rate">12867</div>
            рейтинг
        </div>
        <big>Рецепт полезен?</big>
        <div class="your_opinion">
            <ul>
                <li class="agree_u"><a href="#">Да</a><span>138 (13%)</span></li>
                <li class="disagree_u"><a href="#">Нет</a><span>138 (13%)</span></li>
            </ul>
        </div><!-- .your_opinion -->
        <div class="clear"></div>
    </div>

    <?php if (!empty($more_recipes)):?>
            <div class="more">
                <big class="title">
                    Еще рецепты - <ins class="clr_bl"><?php echo $model->disease->name ?></ins>
                    <a href="<?php echo $this->createUrl('/recipeBook/default/disease', array('url'=>$model->disease->slug))
                        ?>" class="btn btn-blue-small"><span><span>Показать все</span></span></a>
                </big>
                <?php foreach ($more_recipes as $recipe): ?>
                <div class="block">
                    <b><a href="<?php echo $this->createUrl('/recipeBook/default/view', array('id'=>$recipe->id))
                        ?>"><?php echo $recipe->name ?></a></b>
                    <div class="more_ing">
                        <span>Ингредиенты:</span>
                        <ul>
                            <?php foreach ($recipe->ingredients as $ingredient): ?>
                            <li><a href="#"><?php echo $ingredient->name ?></a> <?php echo 'x '.$ingredient->amount ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php echo $recipe->text ?>
                </div>
                <?php endforeach; ?>
                <div class="clear"></div>
            </div>
    <?php endif ?>

    <div class="comments">
        <div class="c-header">
            <div class="left-s">
                <span>Отзывы</span>
                <span class="col">55</span>
            </div>
            <div class="right-s">
                <a class="btn btn-orange" href=""><span><span>Добавить отзыв</span></span></a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="item even_c">
            <div class="user">
                <div class="ava avatar male"></div>
                <a class="username">Максим</a>
            </div>
            <div class="text">
                <span class="r_us">Рецепт полезен</span>
                <p>Определенные критерии предъявляются к жесткости матраца: не рекомендуется выбиратьслишком жесткий илислишком мягкий матрац. </p>
                <div class="data">
                    08 сентября 2011, 19:30
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <div class="item">
            <div class="user">
                <div class="user">
                    <div class="ava avatar female"></div>
                    <a class="username">Наталья</a>
                </div>
            </div>
            <div class="text">
                <span class="r_unus">Рецепт не полезен</span>
                <p>Подскажите, когда появится расцветка 2011 года?</p>
                <div class="data">
                    Вчера, 13:25
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="item even_c"">
        <div class="user">
            <div class="user">
                <div class="ava avatar"></div>
                <a class="username">Алексей</a>
            </div>
        </div>
        <div class="text">
            <p>Определенные критерии предъявляются к жесткости матраца: не рекомендуется выбиратьслишком жесткий илислишком мягкий матрац. </p>
            <div class="data">
                08 сентября 2011, 19:30
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="item">
        <div class="user">
            <div class="user">
                <div class="ava avatar male">
                    <a href=""><img src="/images/ava.png"></a>
                </div>
                <a class="username">Светлана</a>
            </div>
        </div>
        <div class="text">
            <p>Коляска просто супер!!!</p>
            <div class="data">
                08 сентября 2011, 19:30
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="item even_c"">
    <div class="clearfix">
        <div class="user">
            <div class="ava avatar male">
                <a href=""><img src="/images/ava.png"></a>
            </div>
            <a class="username">Светлана</a>
        </div>
        <div class="text">
            <p>Определенные критерии предъявляются к жесткости матраца: не рекомендуется выбиратьслишком жесткий илислишком мягкий матрац. </p>
            <div class="data">
                08 сентября 2011, 19:30
            </div>
        </div>
    </div>

</div>

</div>
<div class="add_comment_newest">
    <ul class="quest_fun">
        <li><span>Считаете ли Вы полезным этот рецепт?</span></li>
        <li class="agree_u"><a href="#">Да</a></li>
        <li class="disagree_u"><a href="#">Нет</a></li>
    </ul>
    <textarea>Отзыв о рецепте</textarea>
    <div class="button_panel">
        <button class="btn btn-gray-medium"><span><span>Отмена</span></span></button>
        <button class="btn btn-green-medium"><span><span>Добавить</span></span></button>
    </div>
</div><!-- .add_comment_newest -->

</div>
