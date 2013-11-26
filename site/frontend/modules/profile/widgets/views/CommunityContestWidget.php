<div class="b-article-conversion b-article-conversion__contest b-article-conversion__<?=$work->contest->cssClass?> clearfix">
    <div class="textalign-c">
        <?php Yii::app()->controller->renderPartial('application.modules.blog.views.default._b_article', array('model' => $work->content, 'showLikes' => false)); ?>
        <div class="b-article-conversion_crosshead">
            <div class="b-article-conversion_crosshead-top">
                <img src="/images/contest/club/<?=$work->contest->cssClass?>/small.png" alt="">
                <a href="<?=$work->contest->url?>" class="b-article-conversion_crosshead-name"><?=$work->contest->title?></a>
            </div>
            <div class="b-article-conversion_crosshead-t">Наш домашний <br> питомец участвует <br> в конкурсе!</div>
            <div class="b-article-conversion_crosshead-desc">Проголосуйте за нас. <br>Нажмите на кнопки!</div>
            <div class="like-block fast-like-block">

                <div class="box-1">

                    <?php
                    Yii::app()->eauth->renderWidget(array(
                        'action' => '/ajax/socialVote',
                        'params' => array(
                            'entity' => get_class($work),
                            'entity_id' => $work->id,
                            'model' => $work,
                        ),
                        'mode' => 'vote',
                    ));
                    ?>

                </div>

            </div>

        </div>
    </div>
</div>