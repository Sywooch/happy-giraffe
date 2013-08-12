<?php
/**
 * @var User $user
 */
Yii::app()->clientScript->registerPackage('ko_profile');

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
                <a href="<?= $this->createUrl('/gallery/user/index', array('userId' => $user->id)) ?>" class="user-btns_i powertip">
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
<?php $this->widget('AwardsWidget', array('user' => $user)); ?>
<?php $this->widget('ClubsWidget', array('user' => $user)); ?>

</div>
<div class="col-23-middle">

<?php $this->widget('StatusWidget', array('user' => $user)); ?>

<?php $this->widget('AboutWidget', array('user' => $user)); ?>

<?php $this->widget('InterestsWidget', array('user' => $user)); ?>

<?php $this->widget('AlbumPhotoWidget', array('user' => $user)); ?>


<div class="col-23-middle">

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