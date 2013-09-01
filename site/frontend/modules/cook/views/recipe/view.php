<div class="b-article clearfix">
    <div class="float-l">
        <div class="like-control like-control__small-indent clearfix">
            <a href="" class="ava male">
                <span class="icon-status status-online"></span>
                <img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
            </a>
        </div>
        <div class="js-like-control">
            <div class="like-control like-control__pinned clearfix">
                <a href="" class="like-control_ico like-control_ico__like">865</a>
                <a href="" class="like-control_ico like-control_ico__repost">5</a>
                <a href="" class="like-control_ico like-control_ico__cook ">123865</a>
            </div>
        </div>
    </div>
    <!-- hrecipe -->
    <div class="b-article_cont hrecipe clearfix">
        <div class="b-article_cont-tale"></div>
        <div class="b-article_header clearfix">
            <div class="meta-gray">
                <a href="<?= $recipe->getUrl(true) ?>" class="meta-gray_comment">
                    <span class="ico-comment ico-comment__gray"></span>
                    <span class="meta-gray_tx"><?=$recipe->commentsCount ?></span>
                </a>
                <div class="meta-gray_view">
                    <span class="ico-view ico-view__gray"></span>
                    <span class="meta-gray_tx"><?=PageView::model()->viewsByPath($recipe->getUrl())?></span>
                </div>
            </div>
            <div class="float-l">
                <a href="<?=$recipe->author->getUrl() ?>" class="b-article_author"><?=$recipe->author->getFullName() ?></a>
                <span class="font-smallest color-gray"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $recipe->created)?></span>
            </div>
        </div>
        <!-- Название блюда должно иметь класс fn  для микроформатов -->
        <h1 class="b-article_t fn">
            Торт «Зебра»
        </h1>
        <div class="b-article_in clearfix">
            <div class="wysiwyg-content clearfix">
                <!--<p>У меня есть уже один рецепт "Зебры".А этим рецептом поделилась со мной моя читательница...Я обещала попробовать сделать, и вот... я сделала! Эта "Зебра" у меня  получилась  воздушнее, мягче, рассыпчатей... По вкусу напомнила кекс... Остается мягкой и вкусной даже на следующий день! </p>-->
                <?php if ($recipe->mainPhoto !== null): ?>
                    <div class="b-article_in-img">
                        <?=CHtml::image($recipe->mainPhoto->getPreviewUrl(580, null, Image::WIDTH), $recipe->mainPhoto->title, array('class' => 'content-img'))?>
                    </div>
                <?php else: ?>
                    <br>
                <?php endif; ?>

                <!-- Всталвять или после изображения или после <br> или пустого <p> -->
                <div class="recipe-desc clearfix">
                    <?php if ($recipe->cuisine): ?>
                        <div class="location clearfix">
                            <?php if (!empty($recipe->cuisine->country_id)):?>
                                <span class="flag-big flag-big-<?=$recipe->cuisine->country->iso_code ?>"></span>
                            <?php endif; ?>
                            <span class="location_tx"><?=$recipe->cuisine->title?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($recipe->preparation_duration || $recipe->cooking_duration): ?>
                        <div class="recipe-desc_holder">
                            <?php if ($recipe->preparation_duration): ?>
                                <div class="recipe-desc_i">
                                    <div class="recipe-desc_ico recipe-desc_ico__time-1 powertip" title="Время подготовки"></div>
                                    <?=$recipe->preparation_duration_h?> : <?=$recipe->preparation_duration_m?>
                                </div>
                            <?php endif; ?>
                            <?php if ($recipe->cooking_duration): ?>
                                <div class="recipe-desc_i">
                                    <div class="recipe-desc_ico recipe-desc_ico__time-2 powertip" title="Время приготовления"></div>
                                    <?=$recipe->cooking_duration_h?> : <?=$recipe->cooking_duration_m?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($recipe->servings): ?>
                        <div class="recipe-desc_i">
                            <div class="recipe-desc_ico recipe-desc_ico__yield powertip" title="Количество порций"></div>
                            на <span class="yeild"><?=$recipe->servings?> <?=Str::GenerateNoun(array('персона', 'персоны', 'персон'), $recipe->servings)?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="clearfix">
                    <div class="nutrition float-r">
                        <!-- Клик на ссылку меняет отображение nutrition_hold display:none; display:block; -->
                        <a href="" class="nutrition_t a-pseudo">Калорийность блюда - 588 ккал</a>

                        <div class="nutrition_hold display-b">
                            <div class="nutrition_portion">
                                <a class="nutrition_portion-a" href="">На 100 г</a>
                                <a class="nutrition_portion-a active" href="">На порцию</a>
                            </div>
                            <ul class="nutrition_ul">
                                <li class="nutrition_li">
                                    <div class="nutrition_icon nutrition_icon__calories">
                                        <i>К</i>
                                    </div>
                                    <div class="nutrition_tx">
                                        Калории -
                                        <span class="calories">11589,2</span>
                                        <span class="nutrition_measure">ккал.</span>
                                    </div>
                                </li>
                                <li class="nutrition_li">
                                    <div class="nutrition_icon nutrition_icon__protein">
                                        <i>Б</i>
                                    </div>
                                    <div class="nutrition_tx">
                                        Белки -
                                        <span class="protein">18</span>
                                        <span class="nutrition_measure">г.</span>
                                    </div>
                                </li>
                                <li class="nutrition_li">
                                    <div class="nutrition_icon nutrition_icon__fat">
                                        <i>Ж</i>
                                    </div>
                                    <div class="nutrition_tx">
                                        Жиры -
                                        <span class="fat">10</span>
                                        <span class="nutrition_measure">г.</span>
                                    </div>
                                </li>
                                <li class="nutrition_li">
                                    <div class="nutrition_icon nutrition_icon__carbohydrates">
                                        <i>У</i>
                                    </div>
                                    <div class="nutrition_tx">
                                        Углеводы -
                                        <span class="carbohydrates">70</span>
                                        <span class="nutrition_measure">г.</span>
                                    </div>
                                </li>

                            </ul>

                        </div>


                    </div>

                    <h2 class="wysiwyg-content_t-sub">Ингредиенты</h2>
                    <ul class="ingredients">
                        <li class="ingredient">
                            <span class="name">Скумбрия</span>
                            - <span class="amount">
                            1&nbsp;штука</span>
                        </li>
                            <li class="ingredient">
                            <span class="name">Лимон</span>
                            - <span class="amount">
                            1&nbsp;штука</span>
                        </li>
                            <li class="ingredient">
                            <span class="name">Лук репчатый</span>
                            - <span class="amount">
                            1&nbsp;штука</span>
                        </li>
                            <li class="ingredient">
                            <span class="name">Прованские травы</span>
                            - <span class="amount">
                            25&nbsp;граммов</span>
                        </li>
                    </ul>
                </div>


                <h2 class="wysiwyg-content_t-sub">Приготовление</h2>
                <p>	Недавно посмотрел фильм "Убить Дракона" снятый в 1988 году с Абдуловым в главной роли. По мотивам пьесы Евгения Шварца «Дракон».</p>
                <ol>
                    <li>Практически нет девушки, которая не переживала бы за отношения героев "Сумерек" как в на экранах, так и в жизни. Но, к сожалению, даже несмотря на то, что недавно герои "Сумерек" радовали всех тем, что у них невероятный роман  и в рельной жизни, а не только лишь на экране, все же <a href="">Роберт Паттинсон</a>  и Кристен Стюарт расстались и пока реши</li>
                    <li><p>Но, к сожалению, даже несмотря на то, что недавно герои "Сумерек" радовали всех тем, </p>
                    <div class="b-article_in-img">
                        <img title="Ночные гости - кто они фото 1" src="http://img.happy-giraffe.ru/thumbs/700x700/56/edad8d334a0b4a086a50332a2d8fd0fe.JPG" class="content-img" alt="Ночные гости - кто они фото 1">
                    </div>
                    <p>что у них невероятный роман  и в рельной жизни, а не только лишь на экране, все же <a href="">Роберт Паттинсон</a>  и Кристен Стюарт расстались и пока реши</p></li>
                    <li> <a href="">Роберт Паттинсон</a>  и Кристен Стюарт расстались и пока реши</li>
                    <li>Практически нет девушки, которая не переживала бы за отношения героев "Сумерек" как в на экранах, так и в жизни. Но, к сожалению, даже несмотря на то, что недавно герои "Сумерек" радовали всех тем, что у них невероятный роман  и в рельной жизни, а не только лишь на экране, все же <a href="">Роберт Паттинсон</a>  и Кристен Стюарт расстались и пока реши</li>
                </ol>
                <p>Практически нет девушки, которая не переживала бы за отношения героев "Сумерек" как в на экранах, так и в жизни. Но, к сожалению, даже несмотря на то, что недавно герои "Сумерек" радовали всех тем, что у них невероятный роман  и в рельной жизни, а не только лишь на экране, все же <a href="">Роберт Паттинсон</a>  и Кристен Стюарт расстались и пока решили взять паузу в своих отношениях.</p>

                <h2>H2 Где можно поменять название трека</h2>
                <p>	Недавно посмотрел фильм "Убить Дракона" снятый в 1988 году с Абдуловым в главной роли. По мотивам пьесы Евгения Шварца «Дракон».</p>
                <div class="b-article_in-img">
                    <img title="Ночные гости - кто они фото 1" src="http://img.happy-giraffe.ru/thumbs/700x700/56/edad8d334a0b4a086a50332a2d8fd0fe.JPG" class="content-img" alt="Ночные гости - кто они фото 1">
                </div>
                <ul>
                    <li>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </li>
                    <li>я не нашел, где можно поменять название трека.</li>
                    <li>Меняя название трека в <strong>Меняя название трека</strong> альбоме он автоматически производит поиск <a href="">Меняя название трека </a>по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. <b>Меняя название трека</b>  в альбоме он автоматически </li>
                </ul>
                <p>и подцепляет естественно студийные версии песен вместо нужных. и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически  и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
            </div>
            <div class="clearfix">
                <div class="cook-diabets">
                    <!--
                    Диаграмма для диабетиков имеет 4 состояния на сколько не подходит
                    val0 (по умолчанию даже без класса)
                    val33
                    val66
                    val100
                    -->
                    <div class="cook-diabets-chart val33">
                        <span class="text">20.5</span>
                    </div>
                    <div class="cook-diabets-desc">Подходит для диабетиков</div>
                </div>

                <div class="cook-article-tags">
                    <div class="cook-article-tags-title">Теги</div>
                    <ul class="cook-article-tags-list">
                        <li><a href="">Рыбные блюда</a></li>
                        <li><a href="">Рыбные блюда</a></li>
                        <li><a href="">Рыбные </a></li>
                        <li><a href="">Рыбные 234234 блюда</a></li>
                        <li><a href="">Рыбные блюда</a></li>
                        <li><a href="">Рыбные блюда</a></li>
                        <li><a href="">Рыбные блюда</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="custom-likes-b">
            <div class="custom-likes-b_slogan">Поделитесь с друзьями!</div>
            <a href="" class="custom-like">
                <span class="custom-like_icon odnoklassniki"></span>
                <span class="custom-like_value">0</span>
            </a>
            <a href="" class="custom-like">
                <span class="custom-like_icon vkontakte"></span>
                <span class="custom-like_value">1900</span>
            </a>

            <a href="" class="custom-like">
                <span class="custom-like_icon facebook"></span>
                <span class="custom-like_value">150</span>
            </a>

            <a href="" class="custom-like">
                <span class="custom-like_icon twitter"></span>
                <span class="custom-like_value">10</span>
            </a>
        </div>
        <div class="nav-article clearfix">
            <div class="nav-article_left">
                <a href="" class="nav-article_arrow nav-article_arrow__left"></a>
                <a href="" class="nav-article_a">Очень красивые пропорции у нашего ведущего</a>
            </div>
            <div class="nav-article_right">
                <a href="" class="nav-article_arrow nav-article_arrow__right"></a>
                <a href="" class="nav-article_a">Очень красивые пропорции Очень красивые пропорции у нашего ведущего у нашего ведущего</a>
            </div>
        </div>

        <div class="cook-more clearfix">
            <div class="cook-more_top">
                Еще вкусненькое
            </div>
            <ul class="cook-more_ul clearfix">
                <li class="cook-more_li">
                    <div class="cook-more_author clearfix">
                        <a class="ava female small"></a>
                        <div class="clearfix">
                            <a class="textdec-onhover" href="">Дарья</a>
                            <div class="color-gray font-smallest">Сегодня, 13:25</div>
                        </div>
                    </div>
                    <div class="cook-more_cnt">
                        <a href="">
                        <!-- img max-width 120px -->
                        <img width="120" height="105" src="/images/cook_more_img_01.jpg">
                        </a>
                    </div>
                    <div class="cook-more_t"><a href="">Ригатони макароны с соусом из помидор говядины</a></div>
                </li>
                <li class="cook-more_li">
                    <div class="cook-more_author clearfix">
                        <a class="ava female small"></a>
                        <div class="clearfix">
                            <a class="textdec-onhover" href="">Дарья</a>
                            <div class="color-gray font-smallest">Сегодня, 13:25</div>
                        </div>
                    </div>
                    <div class="cook-more_cnt">
                        <a href=""><img width="120" height="105" src="/images/cook_more_img_01.jpg"></a>
                    </div>
                    <div class="cook-more_t"><a href="">Ригатони</a></div>
                </li>
                <li class="cook-more_li">
                    <div class="cook-more_author clearfix">
                        <a class="ava female small"></a>
                        <div class="clearfix">
                            <a class="textdec-onhover" href="">Леопольда</a>
                            <div class="color-gray font-smallest">Сегодня, 13:25</div>
                        </div>
                    </div>
                    <div class="cook-more_cnt">
                        <a href=""><img width="120" height="105" src="/images/cook_more_img_01.jpg"></a>
                    </div>
                    <div class="cook-more_t"><a href="">Ригатони помидор говядины</a></div>
                </li>
                <li class="cook-more_li">
                    <div class="cook-more_author clearfix">
                        <a class="ava female small"></a>
                        <div class="clearfix">
                            <a class="textdec-onhover" href="">Дарья</a>
                            <div class="color-gray font-smallest">Сегодня, 13:25</div>
                        </div>
                    </div>
                    <div class="cook-more_cnt">
                        <a href=""><img width="120" height="105" src="/images/cook_more_img_01.jpg"></a>
                    </div>
                    <div class="cook-more_t"><a href="">Ригатони макароны с соусом из помидор говядины</a></div>
                </li>

            </ul>
        </div>

        <div class="comments-gray">
            <div class="comments-gray_t">
                <span class="comments-gray_t-a-tx">Все комментарии (28)</span>
                <a href="" class="btn-green">Добавить</a>
            </div>
            <div class="comments-gray_hold">
                <div class="comments-gray_i comments-gray_i__self">
                    <div class="comments-gray_ava">
                        <a href="" class="ava small male"></a>
                    </div>
                    <div class="comments-gray_frame">
                        <div class="comments-gray_header clearfix">
                            <a href="" class="comments-gray_author">Ангелина Богоявленская </a>
                            <span class="font-smallest color-gray">Сегодня 13:25</span>
                        </div>
                        <div class="comments-gray_cont wysiwyg-content">
                            <p><span class="a-imitation">Вася Пупкин,</span> 	Мне безумно жалко всех женщин, но особенно Тину Кароль, я просто представить себе не могу <a href="">как она все это переживет</a> как она все это переживет(</p>
                            <p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
                        </div>
                    </div>
                    <div class="comments-gray_control comments-gray_control__self">
                        <div class="comments-gray_control-hold">
                            <div class="clearfix">
                                <a href="" class="message-ico message-ico__edit powertip" title="Редактировать"></a>
                            </div>
                            <div class="clearfix">
                                <a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="comments-gray_i">
                    <a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
                    <div class="comments-gray_ava">
                        <a href="" class="ava small female"></a>
                    </div>
                    <div class="comments-gray_frame">
                        <div class="comments-gray_header clearfix">
                            <a href="" class="comments-gray_author">Анг Богоявлен </a>
                            <span class="font-smallest color-gray">Сегодня 14:25</span>
                        </div>
                        <div class="comments-gray_cont wysiwyg-content">
                            <p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
                        </div>
                    </div>

                    <div class="comments-gray_control comments-gray_control__one">
                        <div class="comments-gray_control-hold">
                            <div class="clearfix">
                                <a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="comments-gray_i">
                    <a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">7918</a>
                    <div class="comments-gray_ava">
                        <a href="" class="ava small female"></a>
                    </div>
                    <div class="comments-gray_frame">
                        <div class="comments-gray_header clearfix">
                            <a href="" class="comments-gray_author">Анг Богоявлен </a>
                            <span class="font-smallest color-gray">Сегодня 14:25</span>
                        </div>
                        <div class="comments-gray_cont wysiwyg-content">
                            <p>я не нашел, где можно поменять название трека. </p>
                        </div>
                    </div>

                    <div class="comments-gray_control">
                        <div class="comments-gray_control-hold">
                            <div class="clearfix">
                                <a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
                            </div>
                            <div class="clearfix">
                                <a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
                            </div>
                        </div>
                        <div class="clearfix">
                            <a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
                        </div>
                    </div>
                </div>

                <div class="comments-gray_i comments-gray_i__recovery">
                    <div class="comments-gray_ava">
                        <a href="" class="ava small female"></a>
                    </div>
                    <div class="comments-gray_frame">
                        <div class="comments-gray_header clearfix">
                            <a href="" class="comments-gray_author">Анг Богоявлен </a>
                            <span class="font-smallest color-gray">Сегодня 14:25</span>
                        </div>
                        <div class="comments-gray_cont wysiwyg-content">
                            <p>Комментарий успешно удален.<a href="" class="comments-gray_a-recovery">Восстановить?</a> </p>
                        </div>
                    </div>
                </div>

                <div class="comments-gray_i">
                    <a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
                    <div class="comments-gray_ava">
                        <a href="" class="ava small female"></a>
                    </div>
                    <div class="comments-gray_frame">
                        <div class="comments-gray_header clearfix">
                            <a href="" class="comments-gray_author">Анг Богоявлен </a>
                            <span class="font-smallest color-gray">Сегодня 14:25</span>
                        </div>
                        <div class="comments-gray_cont wysiwyg-content">
                            <p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту </p>
                            <p>
                                <a href="" class="comments-gray_cont-img-w">
                                    <!--    max-width: 170px;  max-height: 110px; -->
                                    <img src="/images/example/w170-h110.jpg" alt="">
                                </a>
                                <a href="" class="comments-gray_cont-img-w">
                                    <img src="/images/example/w220-h309-1.jpg" alt="">
                                </a>
                                <a href="" class="comments-gray_cont-img-w">
                                    <img src="/images/example/w200-h133-1.jpg" alt="">
                                </a>
                            </p>
                            <p>и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
                        </div>
                    </div>

                    <div class="comments-gray_control">
                        <div class="comments-gray_control-hold">
                            <div class="clearfix">
                                <a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
                            </div>
                        </div>
                        <div class="clearfix">
                            <a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="comments-gray_add active clearfix">

                <div class="comments-gray_ava">
                    <a class="ava small female" href=""></a>
                </div>

                <div class="comments-gray_frame clearfix">
                    <!-- input hidden -->
                    <input type="text" placeholder="Ваш комментарий" class="comments-gray_add-itx itx-gray display-n" id="" name="">

                    <div class="redactor_box"><ul class="redactor_toolbar" id="redactor_toolbar_0"><li><a class="redactor_btn redactor_btn_bold" title="Bold" href="javascript:;" tabindex="-1"></a></li><li><a class="redactor_btn redactor_btn_italic" title="Italic" href="javascript:;" tabindex="-1"></a></li><li><a class="redactor_btn redactor_btn_underline" title="Underline" href="javascript:;" tabindex="-1"></a></li><li class="redactor_separator"></li><li><a class="redactor_btn redactor_btn_image" title="Insert Image" href="javascript:;" tabindex="-1"></a></li><li><a class="redactor_btn redactor_btn_video" title="Insert Video" href="javascript:;" tabindex="-1"></a></li><li><a class="redactor_btn redactor_btn_smile" title="smile" href="javascript:;" tabindex="-1"></a></li></ul>
                    <div contenteditable="true" class="redactor_wysiwyg-redactor redactor_editor" dir="ltr">
                         <p><span class="a-imitation">Вася Пупкин,</span> стальной текст сообщения</p>
                    </div>
                    <textarea class="wysiwyg-redactor" name="" dir="ltr" style="display: none;"></textarea></div>
                    <div class="">
                        <div class="redactor-control clearfix">
                            <div class="redactor-control_quote">
                                <span class="comments-gray_quote-ico active"></span>
                                <span class="redactor-control_quote-tx">Вася Пупкин</span>
                                <a href="" class="ico-close3 powertip" title="Отменить ответ"></a>
                            </div>
                            <div class="float-r">
                                <div class="redactor-control_key">
                                    <input type="checkbox" name="" id="redactor-control_key-checkbox" class="redactor-control_key-checkbox">
                                    <label for="redactor-control_key-checkbox" class="redactor-control_key-label">Enter - отправить</label>
                                </div>
                                <button class="btn-green">Отправить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>