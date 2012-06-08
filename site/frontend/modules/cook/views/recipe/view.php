<?php
    /**
     * @var CookRecipe $recipe
     */
?>

<div id="crumbs"><a href="">Главная</a> > <a href="">Сервисы</a> > <span>Приправы и специи</span></div>

<div id="cook-recipe">

    <div class="clearfix">

        <div class="add-recipe">

            Поделиться вкусненьким!<br/>
            <a href="" class="btn btn-green"><span><span>Добавить рецепт</span></span></a>

        </div>

        <div class="search">

            <div class="title">
                <i class="icon"></i>
                <span>Поиск рецептов</span>
                <a href="">По ингредиентам</a>
                <a href="">По калорийности</a>
                <a href="">Расширеный поиск</a>
            </div>

            <form>
                <input type="text" placeholder="Введите ключевое слово в названии рецепта" />
                <button class="btn btn-purple-medium"><span><span>Найти</span></span></button>
            </form>

        </div>

    </div>

    <div class="clearfix">

        <div class="main">

            <div class="main-in">

                <div class="hrecipe">

                    <h1 class="fn"><?=$recipe->title?></h1>

                    <div class="user clearfix">
                        <div class="user-info clearfix">
                            <a class="ava female small"></a>
                            <div class="details">
                                <span class="icon-status status-online"></span>
                                <a href="" class="username">Дарья</a>
                                <div class="date">3 сен 2012, 08:25</div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix">

                        <div class="recipe-description">

                            <ul>
                                <li>Кухня <span class="nationality"><!--<div class="flag flag-ua"></div> --><span class="cuisine-type"><?=$recipe->cuisine->title?></span></span>
                                </li>
                                <li>Время подготовки <span class="time-1"><i class="icon"></i><span class=""><?=$recipe->preparation_duration_h?> : <?=$recipe->preparation_duration_m?></span></span></li>
                                <li>Время приготовления <span class="time-2"><i class="icon"></i><span class=""><?=$recipe->cooking_duration_h?> : <?=$recipe->cooking_duration_m?></span></span></li>
                                <li>Кол-во порций <span class="yield-count"><i class="icon"></i><span class="yield"><?=$recipe->servings?> <?=HDate::GenerateNoun(array('персона', 'персоны', 'персон'), $recipe->servings)?></span></span></li>
                            </ul>

                            <div class="actions">

                                <div class="action">
                                    <a href="" class="print"><i class="icon"></i>Распечатать</a>
                                </div>

                                <div class="action">
                                    <a href="" class="add-to-cookbook"><i class="icon"></i>Добавить в кулинарную книгу</a>
                                </div>

                                <div class="action share">
                                    <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                                    Поделиться
                                    <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,gplus"></div>
                                </div>


                            </div>

                        </div>

                        <div class="recipe-photo">

                            <div class="big">
                                <img class="photo" src="/images/cook_recipe_img_01.jpg" />
                            </div>

                            <div class="thumbs clearfix">

                                <ul>
                                    <li><a href=""><img src="/images/cook_recipe_img_02.jpg" /></li>
                                    <li><a href=""><img src="/images/cook_recipe_img_03.jpg" /></li>
                                    <li><a href="" class="add"><i class="icon"></i></a></li>
                                </ul>

                            </div>

                        </div>

                    </div>

                    <div class="clearfix">

                        <div class="nutrition">

                            <div class="block-title">Калорийность блюда <span>(100 г.)</span></div>

                            <ul>
                                <li class="n-calories">
                                    <div class="icon">
                                        <i>К</i>
                                        Калории
                                    </div>
                                    <span class="calories">240</span> <span class="gray">ккал.</span>
                                </li>
                                <li class="n-protein">
                                    <div class="icon">
                                        <i>Б</i>
                                        Белки
                                    </div>
                                    <span class="protein">18</span> <span class="gray">г.</span>
                                </li>
                                <li class="n-fat">
                                    <div class="icon">
                                        <i>Ж</i>
                                        Жиры
                                    </div>
                                    <span class="fat">10</span> <span class="gray">г.</span>
                                </li>
                                <li class="n-carbohydrates">
                                    <div class="icon">
                                        <i>У</i>
                                        Углеводы
                                    </div>
                                    <span class="carbohydrates">70</span> <span class="gray">г.</span>
                                </li>

                            </ul>

                        </div>

                        <h2>Ингредиенты</h2>

                        <ul class="ingredients">
                            <?php foreach ($recipe->ingredients as $i): ?>
                                <li class="ingredient">
                                    <span class="name"><?=$i->ingredient->title?></span>
                                    <span class="value"><?=round($i->value, 2)?></span>
                                    <span class="type"><?=HDate::GenerateNoun(array($i->unit->title, $i->unit->title2, $i->unit->title3), $i->value)?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <h2>Приготовление</h2>

                        <p>Мои родители и я пошел в поход на Верхний полуостров штата Мичиган летом после моего старшего года средней школы. Это один из тех поездок, которые всегда будут оставаться со мной. Я был одним из тех больших основные переходные периоды в жизни (хотя, как всегда, я не узнал его в то время) и поездка с родителями в красивой части страны было только, что мне нужно, чтобы чувствовать себя в безопасности , безопасный и готовы отправиться в следующую главу моей жизни.</p>

                        <ul class="instructions">
                            <li class="instruction" >Курицу нарезать на кусочки, выложить в форму для запекания,
                                посолить, поперчить, добавить специи по вкусу.</li>
                            <li class="instruction" >Курицу залить пивом, поставить в духовку.</li>
                            <li class="instruction" >Жарить при температуре 180 градусов в течение 40-45 минут.</li>
                        </ul>

                    </div>
                </div>

                <div class="cook-more clearfix">
                    <div class="block-title">
                        Еще вкусненькое
                    </div>
                    <ul>
                        <li>
                            <div class="user clearfix">
                                <div class="user-info clearfix">
                                    <a class="ava female small"></a>
                                    <div class="details">
                                        <span class="icon-status status-online"></span>
                                        <a href="" class="username">Дарья</a>
                                    </div>
                                </div>
                            </div>
                            <div class="date">3 сен 2012, 08:25</div>
                            <div class="item-title"><a href="">Ригатони макароны с соусом из помидор говядины</a></div>
                            <div class="content">
                                <img src="/images/cook_more_img_01.jpg">
                            </div>
                        </li>
                        <li>
                            <div class="user clearfix">
                                <div class="user-info clearfix">
                                    <a class="ava female small"></a>
                                    <div class="details">
                                        <span class="icon-status status-online"></span>
                                        <a href="" class="username">Денис Ижецкий</a>
                                    </div>
                                </div>
                            </div>
                            <div class="date">3 сен 2012, 08:25</div>
                            <div class="item-title"><a href="">Ригатони макароны с соусом из помидор говядины</a></div>
                            <div class="content">
                                <img src="/images/cook_more_img_01.jpg">
                            </div>
                        </li>
                        <li>
                            <div class="user clearfix">
                                <div class="user-info clearfix">
                                    <a class="ava female small"></a>
                                    <div class="details">
                                        <span class="icon-status status-online"></span>
                                        <a href="" class="username">Денис</a>
                                    </div>
                                </div>
                            </div>
                            <div class="date">3 сен 2012, 08:25</div>
                            <div class="item-title"><a href="">Ригатони макароны с соусом из помидор говядины</a></div>
                            <div class="content">
                                <img src="/images/cook_more_img_01.jpg">
                            </div>
                        </li>

                    </ul>
                </div>

                <div class="default-comments">

                    <div class="comments-meta clearfix">
                        <a href="" class="btn btn-orange a-right"><span><span>Добавить комментарий</span></span></a>
                        <div class="title">Комментарии</div>
                        <div class="count">55</div>
                    </div>

                    <ul>
                        <li class="author-comment">
                            <div class="comment-in clearfix">
                                <div class="header clearfix">
                                    <div class="user-info clearfix">
                                        <div class="ava female"></div>
                                        <div class="details">
                                            <span class="icon-status status-online"></span>
                                            <a href="" class="username">Дарья</a>
                                            <div class="user-fast-buttons clearfix">
                                                <a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
                                                <a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="meta">
                                        <span class="num">1</span>
                                        <span class="date">Сегодня, 20:45</span>
                                    </div>
                                    <div class="content-in">
                                        <div class="wysiwyg-content">
                                            <h2>Как выбрать детскую коляску</h2>

                                            <p>Как правило, кроватку новорожденному приобретают незадолго до его появления на свет. При этом многие молодые <b>родители</b> обращают внимание главным <u>образом</u> на ее <strike>внешний</strike> вид. Но, прельстившись яркими красками, многие платят баснословные суммы, даже не поинтересовавшись, из чего сделано это покорившее вас чудо.</p>

                                            <p><img src="/images/example/12.jpg" width="300" class="content-img" /><i>Атопический дерматит у детей до года локализуется в основном на щечках и ягодицах, реже на теле и конечностях, на коже головы возможно появление корочек. Когда малышу исполнится год, то места высыпаний меняются – теперь поражаются локтевые сгибы (внутри и снаружи), подколенные впадины, шея. После трех лет высыпания начинают поражать также и кисти рук.</i></p>

                                            <h3>Как выбрать детскую коляску</h3>

                                            <ul>
                                                <li>Приходишь в детский магазин - глаза разбегаются: столько всего, что порой забываешь, зачем пришел. <a href="">Немало и разновидностей детских кроваток</a>: тут и люльки для младенцев</li>
                                                <li>И кроватки-"домики" - с навесом в виде крыши, и кровати в стиле "евростандарт" - выкрашенные в белый цвет, и даже претендующие на готический стиль, </li>
                                                <li>Есть и продукция попроще. Не покупайте ничего под влиянием первых эмоций. </li>
                                            </ul>

                                            <h3>Как выбрать детскую коляску</h3>

                                            <ol>
                                                <li>Приходишь в детский магазин - глаза разбегаются: столько всего, что порой забываешь, зачем пришел. <a href="">Немало и разновидностей детских кроваток</a>: тут и люльки для младенцев</li>
                                                <li>И кроватки-"домики" - с навесом в виде крыши, и кровати в стиле "евростандарт" - выкрашенные в белый цвет, и даже претендующие на готический стиль, </li>
                                                <li>Есть и продукция попроще. Не покупайте ничего под влиянием первых эмоций. </li>
                                            </ol>
                                        </div>
                                    </div>
                                    <div class="actions">
                                        <a href="" class="claim">Нарушение!</a>
                                        <div class="admin-actions">
                                            <a href="" class="edit"><i class="icon"></i></a>
                                            <a href="#deleteComment" class="remove fancy"><i class="icon"></i></a>
                                        </div>
                                        <a href="">Ответить</a>
                                        &nbsp;
                                        <a href="" class="quote-link">С цитатой</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="comment-in clearfix">
                                <div class="header clearfix">
                                    <div class="user-info clearfix">
                                        <div class="ava female"></div>
                                        <div class="details">
                                            <span class="icon-status status-online"></span>
                                            <a href="" class="username">Дарья</a>
                                            <div class="user-fast-buttons clearfix">
                                                <a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
                                                <a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="meta">
                                        <span class="num">2</span>
                                        <span class="date">Сегодня, 20:45</span>
                                    </div>
                                    <div class="content-in">
                                        <p>Коляска просто супер!!! Очень удобная и функциональная. Ни разу не пожалели, что купили именно эту коляску. Это маленький вездеход :)</p>
                                    </div>
                                    <div class="actions">
                                        <a href="" class="claim">Нарушение!</a>
                                        <div class="admin-actions">
                                            <a href="" class="edit"><i class="icon"></i></a>
                                            <a href="#deleteComment" class="remove fancy"><i class="icon"></i></a>
                                        </div>
                                        <a href="">Ответить</a>
                                        &nbsp;
                                        <a href="" class="quote-link">С цитатой</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="comment-in clearfix">
                                <div class="header clearfix">
                                    <div class="user-info clearfix">
                                        <div class="ava female"></div>
                                        <div class="details">
                                            <span class="icon-status status-online"></span>
                                            <a href="" class="username">Дарья</a>
                                            <div class="user-fast-buttons clearfix">
                                                <span class="friend">друг</span>
                                                <a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="meta">
                                        <span class="num">3</span>
                                        <span class="date">Сегодня, 20:45</span>
                                        <div class="answer">
                                            Ответ для
                                            <div class="user-info clearfix">
                                                <a onclick="return false;" class="ava female small" href="#">
                                                    <img src="http://www.happy-giraffe.ru/upload/avatars/small/120316-10264-ya.jpg" alt="">
                                                </a>
                                            </div>
                                            на <span class="num"><a href="#">2</a></span>
                                        </div>
                                    </div>
                                    <div class="content-in">
                                        <div class="quote">
                                            <p>Коляска просто супер!!! Очень удобная и функциональная. Ни разу не пожалели, что купили именно эту коляску. Это маленький вездеход :)</p>
                                        </div>
                                        <p>Коляска просто супер!!! Очень удобная и функциональная. Ни разу не пожалели, что купили именно эту коляску. Это маленький вездеход :)</p>
                                    </div>
                                    <div class="actions">
                                        <a href="" class="claim">Нарушение!</a>
                                        <div class="admin-actions">
                                            <a href="" class="edit"><i class="icon"></i></a>
                                            <a href="#deleteComment" class="remove fancy"><i class="icon"></i></a>
                                        </div>
                                        <a href="">Ответить</a>
                                        &nbsp;
                                        <a href="" class="quote-link">С цитатой</a>
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>

                </div>


            </div>

        </div>

        <div class="side-left">

            <div class="recipe-categories">

                <ul>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-0"></i>
                            <span>Все рецепты</span>

                        </a>
                        <span class="count">12 582</span>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-1"></i>
                            <span>Первые блюда</span>
                        </a>
                        <span class="count">582</span>
                    </li>
                    <li class="active">
                        <a href="" class="cook-cat active">
                            <i class="icon-cook-cat icon-recipe-2"></i>
                            <span>Вторые блюда</span>
                        </a>
                        <span class="count">1 125</span>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-3"></i>
                            <span>Салаты</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-4"></i>
                            <span>Закуски<br/>и&nbsp;бутерброды</span>

                        </a>
                        <span class="count">125 1525 152</span>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-5"></i>
                            <span>Сладкая выпечка</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-6"></i>
                            <span>Несладкая выпечка</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-7"></i>
                            <span>Торты<br/>и&nbsp;пирожные</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-8"></i>
                            <span>Десерты</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-9"></i>
                            <span>Напитки</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-10"></i>
                            <span>Соусы и&nbsp;кремы</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-11"></i>
                            <span>Консервация</span>
                        </a>
                    </li>
                </ul>

            </div>

        </div>

    </div>

</div>