<?php
/**
 * @var RecipeBookRecipe $recipe
 */
$commentsWidget = $this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => $recipe));
?>

<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <!--/////-->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <!-- b-article-->
            <article class="b-article clearfix">
                <div class="b-article_cont clearfix">
                    <div class="b-article_header clearfix">
                        <div class="icons-meta"><a href="" class="icons-meta_comment"><span class="icons-meta_tx"><?=$commentsWidget->count?></span></a>
                            <div class="icons-meta_view"><span class="icons-meta_tx"><?=PageView::model()->viewsByPath($recipe->getUrl())?></span></div>
                        </div>
                        <div class="float-l">
                            <?php $this->widget('Avatar', array('user' => $recipe->author)); ?>
                            <div class="b-article_author"><a href="<?=$recipe->author->getUrl()?>" class="a-light"><?=$recipe->author->getFullName()?></a></div>
                            <?=HHtml::timeTag($recipe, array(
                                'class' => 'tx-date',
                            ))?>
                        </div>
                    </div>
                    <h1 class="b-article_t"><?=$recipe->title?></h1>
                    <div class="b-article_in clearfix">
                        <div class="wysiwyg-content clearfix">
                            <?=$recipe->purified->text?>
                        </div>
                        <div class="ingredients">
                            <h3 class="ingredients_t">Ингредиенты:</h3>
                            <ul class="ingredients_ul">
                                <?php foreach ($recipe->ingredients as $i): ?>
                                    <li class="ingredients_i"><?=$i->ingredient->title?> - <?=$i->display_value?> <?=$i->noun?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="b-tags">
                            <a href="<?=$recipe->disease->category->getUrl()?>" class="b-tags_tag"><?=$recipe->disease->category->title?></a>
                            <a href="<?=$recipe->disease->getUrl()?>" class="b-tags_tag"><?=$recipe->disease->title?></a>
                        </div>
                    </div>
                    <div class="textalign-c visible-md-block">
                        <div class="like-control like-control__line">
                            <div class="like-control_hold"><a href="" title="Нравится" class="like-control_i like-control_i__like powertip">
                                    <div class="like-control_t">Мне нравится!</div>
                                    <div class="ico-action-hg ico-action-hg__like"></div>
                                    <div class="like-control_tx">865</div></a></div>
                            <div class="like-control_hold"><a href="" title="В избранное" class="like-control_i like-control_i__idea powertip">
                                    <div class="like-control_t">В закладки</div>
                                    <div class="ico-action-hg ico-action-hg__favorite"></div>
                                    <div class="like-control_tx">863455</div></a></div>
                        </div>
                    </div>
                    <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $recipe, 'lite' => true)); ?>
                </div>
            </article>
            <!-- /b-article-->

            <?php if ($recipe->getPrev() !== null || $recipe->getNext() !== null): ?>
                <table ellpadding="0" cellspacing="0" class="article-nearby clearfix">
                    <tr>
                        <?php if ($recipe->getPrev() !== null): ?>
                            <td><a href="<?=$recipe->getPrev()->getUrl()?>" class="article-nearby_a article-nearby_a__l"><span class="article-nearby_tx"><?=$recipe->getPrev()->title?></span></a></td>
                        <?php endif; ?>
                        <?php if ($recipe->getNext() !== null): ?>
                            <td><a href="<?=$recipe->getNext()->getUrl()?>" class="article-nearby_a article-nearby_a__r"><span class="article-nearby_tx"><?=$recipe->getNext()->title?></span></a></td>
                        <?php endif; ?>
                    </tr>
                </table>
            <?php endif; ?>
            <div class="adv-yandex"><a href="" target="_blank"><img src="/lite/images/example/yandex-w600.jpg" alt=""></a></div>
            <!-- comments-->
            <section class="comments comments__buble">
            <div class="comments-menu">
                <ul data-tabs="tabs" class="comments-menu_ul">
                    <li class="comments-menu_li active"><a href="#commentsList" data-toggle="tab" class="comments-menu_a comments-menu_a__comments">Комментарии 68 </a></li>
                    <li class="comments-menu_li"><a href="#likesList" data-toggle="tab" class="comments-menu_a comments-menu_a__likes">Нравится 865</a></li>
                    <li class="comments-menu_li"><a href="#favoritesList" data-toggle="tab" class="comments-menu_a comments-menu_a__favorites">Закладки 865</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <?php //$commentsWidget->run(); ?>
                <div id="likesList" class="comments_hold tab-pane">
                    <div class="list-subsribe-users">
                        <ul class="list-subsribe-users_ul">
                            <li class="list-subsribe-users_li">
                                <!-- ava--><a href="" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                                <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-secondary btn-sl">Читаю</a>
                            </li>
                            <li class="list-subsribe-users_li">
                                <!-- ava--><a href="" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                                <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-success btn-sl"><span class="ico-plus"></span>Подписаться</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="favoritesList" class="comments_hold tab-pane">
                    <div class="list-subsribe-users">
                        <ul class="list-subsribe-users_ul">
                            <li class="list-subsribe-users_li">
                                <!-- ava--><a href="" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                                <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-success btn-sl"><span class="ico-plus"></span>Подписаться</a>
                            </li>
                            <li class="list-subsribe-users_li">
                                <!-- ava--><a href="" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                                <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-secondary btn-sl">Читаю</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            </section>
            <!-- /comments-->
        </div>
        <!-- /Основная колонка-->
    </div>
</div>