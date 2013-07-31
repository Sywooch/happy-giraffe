<?php
/**
 * @var User $user
 */
Yii::app()->clientScript->registerScriptFile('/javascripts/ko_user_profile.js');
?><div class="section-lilac">
    <div class="section-lilac_hold">
        <div class="section-lilac_left">
            <h1 class="section-lilac_name"><?=$user->getFullName() ?></h1>
            <div class="margin-b5 clearfix">
                <?php if ($user->birthday):?>
                    <?=$user->getNormalizedAge()?>, <?=$user->birthdayString?>
                <?php endif ?>
            </div>
            <div class="location clearfix">
                <?php
                if (!empty($user->address->country_id))
                    echo $user->address->getFlag(true, 'span');
                if (!empty($user->address->city_id) || !empty($user->address->region_id))
                    echo '<span class="location-tx">'.$user->address->getUserFriendlyLocation().'</span>';
                ?>
            </div>
            <div class="user-btns clearfix">
                <a href="" class="user-btns_i powertip">
                    		<span class="user-btns_ico-hold user-btns_ico-hold__friend-add">
                    			<span class="user-btns_ico"></span>
                    		</span>
                    <span class="user-btns_tx"></span>
                </a>
                <a href="<?=$this->createUrl('/messaging/default/index', array('interlocutorId' => $user->id)) ?>" class="user-btns_i powertip">
                    		<span class="user-btns_ico-hold user-btns_ico-hold__dialog">
                    			<span class="user-btns_ico"></span>
                    		</span>
                    <span class="user-btns_tx"></span>
                </a>
                <div class="user-btns_separator"></div>

                <a href="<?= $this->createUrl('/blog/default/index', array('user_id' => $user->id)) ?>" class="user-btns_i powertip">
                    		<span class="user-btns_ico-hold user-btns_ico-hold__blog">
                    			<span class="user-btns_ico"></span>
                    		</span>
                    <span class="user-btns_tx"><?=$user->blogPostsCount.' <br> '.Str::GenerateNoun(array('запись', 'записи', 'записей'), $user->blogPostsCount) ?></span>
                </a>
                <a href="<?= $this->createUrl('/albums/user', array('user_id' => $user->id)) ?>" class="user-btns_i powertip">
                    		<span class="user-btns_ico-hold user-btns_ico-hold__photo">
                    			<span class="user-btns_ico"></span>
                    		</span>
                    <span class="user-btns_tx"><?=$user->getPhotosCount() ?> <br> фото</span>
                </a>
            </div>
        </div>
        <div class="section-lilac_center">
            <div class="b-ava-large">
                <div class="ava large">
                    <img src="/images/example/ava-large.jpg" alt="">
                </div>
                <?php if ($user->online): ?>
                    <span class="b-ava-large_online">На сайте</span>
                <?php else: ?>
                    <span class="b-ava-large_lastvisit">Была на сайте <br> <?= HDate::GetFormattedTime($user->login_date); ?></span>
                <?php endif; ?>
            </div>
            <div class="section-lilac_center-reg">с Веселым Жирафом <?=$user->withUs() ?></div>
        </div>
        <div class="section-lilac_right">
            <div class="b-famyli">
                <div class="b-famyli_top b-famyli_top__white"></div>
                <ul class="b-famyli_ul">
                    <li class="b-famyli_li">
                        <div class="b-famyli_img-hold">
                            <!-- Размеры изображений 55*55пк -->
                            <img src="/images/example/w41-h49-1.jpg" alt="" class="b-famyli_img">
                        </div>
                        <div class="b-famyli_tx">
                            <span>Жена</span> <br>
                            <span>Елена</span>
                        </div>
                    </li>
                    <li class="b-famyli_li">
                        <div class="b-famyli_img-hold">
                            <img src="/images/example/w60-h40.jpg" alt="" class="b-famyli_img">
                        </div>
                        <div class="b-famyli_tx">
                            <span>Сын</span> <br>
                            <span>Александр</span> <br>
                            <span>10 лет</span>
                        </div>
                    </li>
                    <li class="b-famyli_li">
                        <div class="b-famyli_img-hold">
                            <img src="/images/example/w64-h61-1.jpg" alt="" class="b-famyli_img">
                        </div>
                        <div class="b-famyli_tx">
                            <span>Дочь</span> <br>
                            <span>Снежана</span> <br>
                            <span>2,5 года</span>
                        </div>
                    </li>
                    <li class="b-famyli_li">
                        <div class="b-famyli_img-hold">
                            <div class="ico-child ico-child__girl-small"></div>
                        </div>
                        <div class="b-famyli_tx">
                            <span>Дочь</span> <br>
                            <span>Снежана</span> <br>
                            <span>2,5 года</span>
                        </div>
                    </li>
                    <li class="b-famyli_li">
                        <div class="b-famyli_img-hold">
                            <div class="ico-child ico-child__boy-small"></div>
                        </div>
                        <div class="b-famyli_tx">
                            <span>Дочь</span> <br>
                            <span>Снежана</span> <br>
                            <span>2,5 года</span>
                        </div>
                    </li>
                    <li class="b-famyli_li">
                        <div class="b-famyli_img-hold">
                            <a href="" class="b-famyli_more">еще 3</a>
                        </div>
                        <div class="b-famyli_tx">
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="content-cols clearfix">
<div class="col-1">

<?php $this->widget('UserFriendsWidget', array('user' => $user)); ?>

<div class="user-awards">
    <div class="clearfix">
        <span class="ico-cup-small"></span> &nbsp;
        <span class="heading-small">Мои награды</span>
        <a href="" class="padding-l20">Смотреть все</a>
    </div>
    <ul class="user-awards_ul clearfix">
        <li class="user-awards_li">
            <a href="" class="user-awards_a">
                <img src="/images/scores/awards/award-9-46.png" alt="" class="user-awards_img">
                <span class="user-awards_overlay"></span>
            </a>
        </li>
        <li class="user-awards_li">
            <a href="" class="user-awards_a">
                <img src="/images/scores/awards/award-21-46.png" alt="" class="user-awards_img">
                <span class="user-awards_overlay"></span>
            </a>
        </li>
        <li class="user-awards_li">
            <a href="" class="user-awards_a">
                <img src="/images/scores/awards/award-7-46.png" alt="" class="user-awards_img">
                <span class="user-awards_overlay"></span>
            </a>
        </li>
        <li class="user-awards_li">
            <a href="" class="user-awards_a">
                <img src="/images/scores/awards/award-3-46.png" alt="" class="user-awards_img">
                <span class="user-awards_overlay"></span>
            </a>
        </li>
        <li class="user-awards_li">
            <a href="" class="user-awards_a">
                <img src="/images/scores/awards/award-25-46.png" alt="" class="user-awards_img">
                <span class="user-awards_overlay"></span>
            </a>
        </li>
        <li class="user-awards_li">
            <a href="" class="user-awards_a">
                <img src="/images/scores/awards/award-6-46.png" alt="" class="user-awards_img">
                <span class="user-awards_overlay"></span>
            </a>
        </li>
        <li class="user-awards_li">
            <a href="" class="user-awards_a">
                <img src="/images/scores/awards/award-23-46.png" alt="" class="user-awards_img">
                <span class="user-awards_overlay"></span>
            </a>
        </li>
        <li class="user-awards_li">
            <a href="" class="user-awards_a">
                <img src="/images/scores/awards/award-26-46.png" alt="" class="user-awards_img">
                <span class="user-awards_overlay"></span>
            </a>
        </li>
        <li class="user-awards_li">
            <a href="" class="user-awards_a">
                <img src="/images/scores/awards/award-29-46.png" alt="" class="user-awards_img">
                <span class="user-awards_overlay"></span>
            </a>
        </li>
        <li class="user-awards_li">
            <a href="" class="user-awards_a">
                <img src="/images/scores/awards/award-5-46.png" alt="" class="user-awards_img">
                <span class="user-awards_overlay"></span>
            </a>
            <script>
                $(function() {
                    $('.user-awards_li').bind({
                        mouseover: function(){

                            $(this).find('.user-awards_popup').stop(true, true).fadeIn(200);
                        },
                        mouseout: function(){
                            $(this).find('.user-awards_popup').stop(true, true).delay(200).fadeOut(200);

                        }

                    });
                });
            </script>
            <div class="user-awards_popup user-awards_popup__2">
                <div class="user-awards_popup-tale"></div>
                <div class="user-awards_popup-img">
                    <img src="/images/scores/awards/award-5-84.png" alt="">
                </div>
                <div class="user-awards_popup-desc">
                    <div class="clearfix">«Орден мастерицы»</div>
                    <div class="font-smallest">Получен 8 янв 2013</div>
                    <div class="user-awards_popup-count">+ 1500 баллов</div>
                    <a href="" class="user-awards_popup-more">Как получить трофеи</a>
                </div>
            </div>
        </li>
        <li class="user-awards_li">
            <a href="" class="user-awards_a">
                <img src="/images/scores/awards/award-4-46.png" alt="" class="user-awards_img">
                <span class="user-awards_overlay"></span>
            </a>
            <div class="user-awards_popup user-awards_popup__3">
                <div class="user-awards_popup-tale"></div>
                <div class="user-awards_popup-img">
                    <img src="/images/scores/awards/award-5-84.png" alt="">
                </div>
                <div class="user-awards_popup-desc">
                    <div class="clearfix">«Орден мастерицы»</div>
                    <div class="font-smallest">Получен 8 янв 2013</div>
                    <div class="user-awards_popup-count">+ 1500 баллов</div>
                    <a href="" class="user-awards_popup-more">Как получить трофеи</a>
                </div>
            </div>
        </li>
    </ul>
</div>

<?php $this->widget('UserCommunitiesWidget', array('user' => $user)); ?>

</div>
<div class="col-23-middle">

<div class="b-user-status">
    <div class=" clearfix">
        <div class="meta-gray">
            <a href="" class="meta-gray_comment">
                <span class="ico-comment ico-comment__gray"></span>
                <span class="meta-gray_tx">35</span>
            </a>
            <div class="meta-gray_view">
                <span class="ico-view ico-view__gray"></span>
                <span class="meta-gray_tx">305</span>
            </div>
        </div>
        <div class="float-l">
            <span class="font-smallest color-gray">Сегодня 13:25</span>
        </div>
    </div>
    <div class="b-user-status_hold clearfix">
        <a href="" class="b-user-status_hold-a">	Говори себе с утра: Счастье, нам вставать пора!!! Так со Счастьем и вставай, от себя не отпускай!!!</a>

        <div class="textalign-r clearfix">
            <div class="b-user-mood">
                <div class="b-user-mood_hold">
                    <div class="b-user-mood_tx">Мое настроение -</div>
                </div>
                <div class="b-user-mood_img">
                    <img src="/images/widget/mood/6.png">
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->widget('AboutWidget', array('user' => $user)); ?>

<?php $this->widget('InterestsWidget', array('user' => $user)); ?>

<!-- Фото -->
<div class="photo-preview-row clearfix">
    <h3 class="heading-small margin-b10">Мои фото</h3>
    <div class="photo-preview-row_hold2">
        <div class="photo-grid clearfix">
            <div class="photo-grid_row clearfix">
                <!-- Ловить клик на photo-grid_i для показа увеличенного фото -->
                <div class="photo-grid_i">
                    <img class="photo-grid_img" src="/images/example/photo-grid-7.jpg" alt="">
                    <div class="photo-grid_overlay">
                        <span class="photo-grid_zoom powertip"></span>
                    </div>
                </div>
                <div class="photo-grid_i">
                    <img class="photo-grid_img" src="/images/example/photo-grid-8.jpg" alt="">
                    <div class="photo-grid_overlay">
                        <span class="photo-grid_zoom powertip"></span>
                    </div>
                </div>
                <div class="photo-grid_i">
                    <img class="photo-grid_img" src="/images/example/photo-grid-9.jpg" alt="">
                    <div class="photo-grid_overlay">
                        <span class="photo-grid_zoom powertip"></span>
                    </div>
                </div>
                <div class="photo-grid_i">
                    <img class="photo-grid_img" src="/images/example/photo-grid-10.jpg" alt="">
                    <div class="photo-grid_overlay">
                        <span class="photo-grid_zoom powertip"></span>
                    </div>
                </div>
                <div class="photo-grid_i">
                    <img class="photo-grid_img" src="/images/example/photo-grid-11.jpg" alt="">
                    <div class="photo-grid_overlay">
                        <span class="photo-grid_zoom powertip"></span>
                    </div>
                </div>
                <div class="photo-grid_i">
                    <img class="photo-grid_img" src="/images/example/photo-grid-12.jpg" alt="">
                    <div class="photo-grid_overlay">
                        <span class="photo-grid_zoom powertip"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="photo-preview-row_last">
            <div class="font-small color-gray margin-b5">смотреть <br> все фото</div>
            <a href="" class="photo-preview-row_a">58 054</a>
        </div>
    </div>
</div>

<!-- Статьи -->
<div class="col-gray">

<div class="clearfix margin-20">
    <!-- Отписаться btn-lightgray  -->
    <a href="" class="btn-green btn-medium float-r">Подписаться</a>
    <h3 class="heading-small float-l margin-t5">Моя активность</h3>
</div>

<div class="b-article clearfix">
    <div class="float-l">
        <div class="like-control like-control__small-indent clearfix">
            <a href="" class="ava male">
                <span class="icon-status status-online"></span>
                <img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
            </a>
        </div>
        <div class="like-control clearfix">
            <a href="" class="like-control_ico like-control_ico__like">865</a>
            <a href="" class="like-control_ico like-control_ico__repost">5</a>
            <a href="" class="like-control_ico like-control_ico__favorites active">123865</a>
        </div>
    </div>
    <div class="b-article_cont clearfix">
        <div class="b-article_cont-tale"></div>
        <div class="b-article_header clearfix">
            <div class="meta-gray">
                <a href="" class="meta-gray_comment">
                    <span class="ico-comment ico-comment__gray"></span>
                    <span class="meta-gray_tx">35</span>
                </a>
                <div class="meta-gray_view">
                    <span class="ico-view ico-view__gray"></span>
                    <span class="meta-gray_tx">305</span>
                </div>
            </div>
            <div class="float-l">
                <a href="" class="b-article_author">Ангелина Богоявленская</a>
                <span class="font-smallest color-gray">Сегодня 13:25</span>
            </div>
        </div>
        <h2 class="b-article_t">
            <a href="" class="b-article_t-a">Самое лучшее утро - просыпаюсь, а ты рядом</a>
        </h2>
        <div class="b-article_in clearfix">
            <div class="wysiwyg-content clearfix">
                <p>	Недавно посмотрел фильм "Убить Дракона" снятый в 1988 году с Абдуловым в главной роли. По мотивам пьесы Евгения Шварца «Дракон».</p>
                <div class="b-article_in-img">
                    <img title="Убить Дракона. Фантасмагория или сказка для взрослых. фото 1" src="http://img.happy-giraffe.ru/thumbs/700x700/16534/3733dd340b221ac3052b5cef11288870.jpg" class="content-img" alt="Убить Дракона. Фантасмагория или сказка для взрослых. фото 1" width="800">
                </div>
            </div>
        </div>
        <div class="textalign-r">
            <a href="" class="b-article_more">Смотреть далее</a>
        </div>

        <div class="comments-gray">
            <div class="comments-gray_t">
                <a href="" class="comments-gray_t-a">
                    <span class="comments-gray_t-a-tx">Все комментарии (28)</span>
                </a>
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
                            <p>	Мне безумно жалко всех женщин, но особенно Тину Кароль, я просто представить себе не могу <a href="">как она все это переживет</a> как она все это переживет(</p>
                            <p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
                        </div>
                    </div>
                    <div class="comments-gray_control comments-gray_control__self">
                        <div class="comments-gray_control-hold">
                            <div class="clearfix">
                                <a href="" class="message-ico message-ico__edit powertip"></a>
                            </div>
                            <div class="clearfix">
                                <a href="" class="message-ico message-ico__del powertip"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="comments-gray_i">
                    <a href="" class="comments-gray_like like-hg-small powertip">7918</a>
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
                                <a href="" class="comments-gray_quote-ico powertip"></a>
                            </div>
                            <div class="clearfix">
                                <a href="" class="message-ico message-ico__del powertip"></a>
                            </div>
                        </div>
                        <div class="clearfix">
                            <a href="" class="message-ico message-ico__warning powertip"></a>
                        </div>
                    </div>
                </div>

                <div class="comments-gray_i">
                    <a href="" class="comments-gray_like like-hg-small powertip">78</a>
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
                                <a href="" class="comments-gray_quote-ico powertip"></a>
                            </div>
                        </div>
                        <div class="clearfix">
                            <a href="" class="message-ico message-ico__warning powertip"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="comments-gray_add active clearfix">

                <div class="comments-gray_ava">
                    <a href="" class="ava small female"></a>
                </div>
                <div class="comments-gray_frame">
                    <!-- input hidden -->
                    <input type="text" name="" id="" class="comments-gray_add-itx itx-gray display-n" placeholder="Ваш комментарий">
                    <textarea name="" class="wysiwyg-redactor"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="b-article b-article__user-status clearfix">
    <div class="float-l">
        <div class="like-control like-control__small-indent clearfix">
            <a href="" class="ava male">
                <span class="icon-status status-online"></span>
                <img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
            </a>
        </div>
        <div class="like-control clearfix">
            <a href="" class="like-control_ico like-control_ico__like">865</a>
            <a href="" class="like-control_ico like-control_ico__repost">5</a>
            <a href="" class="like-control_ico like-control_ico__favorites active">123865</a>
        </div>
    </div>
    <div class="b-article_cont clearfix">
        <div class="b-article_cont-tale"></div>
        <div class="b-article_header clearfix">
            <div class="meta-gray">
                <a href="" class="meta-gray_comment">
                    <span class="ico-comment ico-comment__gray"></span>
                    <span class="meta-gray_tx">35</span>
                </a>
                <div class="meta-gray_view">
                    <span class="ico-view ico-view__gray"></span>
                    <span class="meta-gray_tx">305</span>
                </div>
            </div>
            <div class="float-l">
                <a href="" class="b-article_author">Ангелина Богоявленская</a>
                <span class="font-smallest color-gray">Сегодня 13:25</span>
            </div>
        </div>
        <div class="b-article_in clearfix">
            <div class="b-article_user-status clearfix">
                <a href="" class="b-article_user-status-a">	Говори себе с утра: Счастье, нам вставать пора!!! Так со Счастьем и вставай, от себя не отпускай!!!</a>

                <div class="textalign-r clearfix">
                    <div class="b-user-mood">
                        <div class="b-user-mood_hold">
                            <div class="b-user-mood_tx">Мое настроение -</div>
                        </div>
                        <div class="b-user-mood_img">
                            <img src="/images/widget/mood/6.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="comments-gray">
            <div class="comments-gray_add clearfix">

                <div class="comments-gray_ava">
                    <a href="" class="ava small female"></a>
                </div>
                <div class="comments-gray_frame">
                    <input type="text" name="" id="" class="comments-gray_add-itx itx-gray" placeholder="Ваш комментарий">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="yiipagination">
    <div class="pager">
        <ul class="yiiPager" id="yw1">
            <li class="page"><a href="">1</a></li>
            <li class="page"><a href="">2</a></li>
            <li class="page selected"><a href="">3</a></li>
            <li class="page"><a href="">4</a></li>
            <li class="page"><a href="">5</a></li>
            <li class="page"><a href="">6</a></li>
            <li class="page"><a href="">7</a></li>
            <li class="page"><a href="">8</a></li>
            <li class="page"><a href="">9</a></li>
            <li class="page"><a href="">10</a></li>
        </ul>
    </div>
</div>
</div>
</div>
</div>