<ul class="breadcrumbs-big clearfix">
    <li class="breadcrumbs-big_i">
        <a href="" class="breadcrumbs-big_a">Мой Жираф</a>
    </li>
    <li class="breadcrumbs-big_i">Мои подписки </li>
</ul>
<div class="col-gray padding-20 clearfix">
<div class="clearfix">
    <span class="i-highlight i-highlight__big font-big">Мои клубы</span>
</div>
<!--
Такой же список клубов как при регистрации, только без
<span class="club-list_img-overlay"></span>
  -->
<?php $this->widget('ClubsWidget', array('user' => Yii::app()->user->getModel(), 'size' => 'Big')); ?>

<div class="clearfix">
    <span class="i-highlight i-highlight__big font-big">Мои подписки на блоги</span>
</div>

<div class="blog-preview">
    <div class="blog-preview_ava-hold">
        <a href="" class="ava female">
            <span class="icon-status status-online"></span>
            <img src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" alt="">
        </a>
    </div>
    <div class="blog-preview_desc">
        <a href="" class="blog-preview_author textdec-onhover">Александр Богоявленский</a>
        <h2 class="blog-preview_t"><a href="">Блог о красивой любви</a></h2>
        <div class="readers2 readers2__blog-preview">
            <div class="clearfix">
                <div class="readers2_count">Все подписчики (129)</div>
            </div>
            <ul class="readers2_ul clearfix">
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li margin-l10 clearfix">
                    <a class="" href="">
                        и еще 158
                    </a>
                </li>
            </ul>
        </div>
        <a href="" class="btn-gray-light btn-medium">Отписаться</a>
    </div>
    <div class="blog-preview_articles">


        <div class="b-article-prev clearfix">
            <div class="float-l">
                <div class="like-control like-control__smallest clearfix">
                    <a href="" class="like-control_ico like-control_ico__like">865</a>
                    <a href="" class="like-control_ico like-control_ico__favorites active">1465</a>
                </div>
            </div>
            <div class="b-article-prev_cont clearfix">
                <div class="clearfix">
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
                <div class="b-article-prev_t clearfix">
                    <div class="b-article-prev_t-img">
                        <img alt="" src="/images/example/w60-h40.jpg">
                    </div>
                    <a href="" class="b-article-prev_t-a">Самое лучшее утро - просыпаюсь, а ты рядом</a>
                </div>
                <div class="b-article-prev_tx clearfix">
                    <p>	Недавно посмотрел фильм "Убить Дракона" снятый в 1988 году с Абдуловым...</p>
                </div>
            </div>
        </div>

        <div class="b-article-prev clearfix">
            <div class="float-l">
                <div class="like-control like-control__smallest clearfix">
                    <a href="" class="like-control_ico like-control_ico__like active">5</a>
                    <a href="" class="like-control_ico like-control_ico__favorites">15</a>
                </div>
            </div>
            <div class="b-article-prev_cont clearfix">
                <div class="clearfix">
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
                <div class="b-article-prev_t clearfix">
                    <div class="b-article-prev_t-img">
                        <img alt="" src="/images/example/w60-h40.jpg">
                    </div>
                    <a href="" class="b-article-prev_t-a">Самое </a>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="blog-preview">
    <div class="blog-preview_ava-hold">
        <a href="" class="ava female">
            <span class="icon-status status-online"></span>
        </a>
    </div>
    <div class="blog-preview_desc">
        <a href="" class="blog-preview_author textdec-onhover">Алекс Явленский</a>
        <h2 class="blog-preview_t"><a href="">Блог</a></h2>
        <div class="readers2 readers2__blog-preview">
            <div class="clearfix">
                <div class="readers2_count">Все подписчики (12449)</div>
            </div>
            <ul class="readers2_ul clearfix">
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li margin-l10 clearfix">
                    <a class="" href="">
                        и еще 158
                    </a>
                </li>
            </ul>
        </div>
        <a href="" class="btn-gray-light btn-medium">Отписаться</a>
    </div>
    <div class="blog-preview_articles">


        <div class="b-article-prev clearfix">
            <div class="float-l">
                <div class="like-control like-control__smallest clearfix">
                    <a href="" class="like-control_ico like-control_ico__like">865</a>
                    <a href="" class="like-control_ico like-control_ico__favorites active">1465</a>
                </div>
            </div>
            <div class="b-article-prev_cont clearfix">
                <div class="clearfix">
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
                <div class="b-article-prev_t clearfix">
                    <a href="" class="b-article-prev_t-a">Самое лучшее утро - просыпаюсь, а ты рядом</a>
                </div>
                <div class="b-article-prev_tx clearfix">
                    <p>	Недавно посмотрел фильм "Убить Дракона" снятый в 1988 году с Абдуловым...</p>

                </div>
            </div>
        </div>

        <div class="b-article-prev clearfix">
            <div class="float-l">
                <div class="like-control like-control__smallest clearfix">
                    <a href="" class="like-control_ico like-control_ico__like active">5</a>
                    <a href="" class="like-control_ico like-control_ico__favorites">15</a>
                </div>
            </div>
            <div class="b-article-prev_cont clearfix">
                <div class="clearfix">
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
                <div class="b-article-prev_t clearfix">
                    <a href="" class="b-article-prev_t-a">Самое лучшее утро </a>
                </div>
            </div>
        </div>

    </div>
</div>
</div>