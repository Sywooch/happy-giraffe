<?php $this->beginContent('//layouts/common'); ?>

    <div id="header-new" class="<?php if (Yii::app()->user->isGuest): ?>guest <?php endif; ?>clearfix">

        <div class="header-in">
            <div class="clearfix">

                <?php if (! Yii::app()->user->isGuest): ?>
                    <div class="search-box clearfix">
                        <form action="<?php echo $this->createUrl('/search'); ?>">
                            <div class="input">
                                <input type="text" name="text" />
                            </div>
                            <button class="btn btn-green-medium"><span><span>Поиск</span></span></button>
                        </form>
                    </div>
                <?php endif; ?>

                <div class="logo-box">
                    <?=HHtml::link('', '/', array('class'=>'logo', 'title'=>'Веселый Жираф - сайт для всей семьи'), true)?>
                    <span>САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span>
                </div>

                <div class="banner-box">
                    <?php if (! Yii::app()->user->isGuest): ?>
                        <?php $contest_id = 5; ?>
                        <a href="<?=$this->createUrl('/contest/default/view', array('id' => $contest_id)) ?>"><img src="/images/contest/banner-w300-<?=$contest_id?>.jpg" /></a>
                    <?php else: ?>
                        <?=CHtml::link(CHtml::image('/images/banner_06.png'), '#register', array('class'=>'fancy', 'data-theme'=>'white-square'))?>
                    <?php endif; ?>
                </div>

            </div>

            <div class="nav">
                <ul class="width-2 clearfix">
                    <?php if (false): ?>
                        <li class="morning">
                            <a href="<?=$this->createUrl('/morning/index') ?>"><i class="text"></i></a>
                        </li>
                    <?php endif; ?>
                    <li class="kids navdrp">
                        <a href="javascript:void(0);" onclick="navDrpOpen(this);"><i class="text"></i></a>

                        <?php $this->beginWidget('application.widgets.SeoContentWidget'); ?>
                        <div class="drp">
                            <div class="in">

                                <ul class="cols cols-5">
                                    <li class="col">

                                        <div class="col-in bg-img-11">
                                            <div class="title">Беременность и роды</div>
                                            <ul>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 1))?>">Планирование</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 2))?>">Беременность</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 3))?>">Подготовка и роды</a></li>
                                            </ul>
                                        </div>

                                    </li>
                                    <li class="col">

                                        <div class="col-in bg-img-12">
                                            <div class="title">Дети до года</div>
                                            <ul>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 4))?>">Здоровье</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 5))?>">Питание малыша</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 6))?>">Развитие ребенка</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 7))?>">Режим и уход</a></li>
                                            </ul>
                                        </div>

                                    </li>
                                    <li class="col">

                                        <div class="col-in bg-img-13">
                                            <div class="title">Дети старше года</div>
                                            <ul>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 8))?>">Здоровье и питание</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 9))?>">Ясли и няни</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 10))?>">Раннее развитие и обучение</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 11))?>">Психология и воспитание</a></li>
                                            </ul>
                                        </div>

                                    </li>
                                    <li class="col">

                                        <div class="col-in bg-img-14">
                                            <div class="title">Дошкольники</div>
                                            <ul>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 12))?>">Детский сад</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 13))?>">Готовимся к школе</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 14))?>">Игры и развлечения</a></li>
                                            </ul>
                                        </div>

                                    </li>
                                    <li class="col">

                                        <div class="col-in bg-img-15">
                                            <div class="title">Школьники</div>
                                            <ul>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 15))?>">Здоровье и питание</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 16))?>">Учимся в школе</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 17))?>">Спорт и досуг</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 18))?>">Подростковая психология</a></li>
                                            </ul>
                                        </div>

                                    </li>

                                </ul>

                            </div>
                        </div>
                        <?php $this->endWidget();?>

                    </li>
                    <li class="manwoman navdrp">
                        <a href="javascript:void(0);" onclick="navDrpOpen(this);"><i class="text"></i></a>

                        <?php $this->beginWidget('application.widgets.SeoContentWidget'); ?>
                        <div class="drp">
                            <div class="in">

                                <ul class="cols cols-2">
                                    <li class="col wedding">
                                        <a class="big-link bg-img-21" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 32))?>">
                                            <span class="title">Свадьба</span>
                                            <span class="text">Всё об этом важном событии – от планов и составления списка гостей до проведения торжества.</span>
                                        </a>
                                    </li>
                                    <li class="col relationships">
                                        <div class="col-in bg-img-22">
                                            <div class="title">Отношения</div>
                                            <ul>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 31, 'rubric_id'=>239))?>">Отношения мужчины и женщины</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 31, 'rubric_id'=>242))?>">Непонимание в семье</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 31, 'rubric_id'=>243))?>">Ревность и измена</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 31, 'rubric_id'=>246))?>">Развод</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 31, 'rubric_id'=>248))?>">Психология мужчин</a></li>
                                                <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 31, 'rubric_id'=>249))?>">Психология женщин</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <?php $this->endWidget();?>

                    </li>
                    <li class="beauty navdrp">
                        <a href="javascript:void(0);" onclick="navDrpOpen(this);"><i class="text"></i></a>

                        <?php $this->beginWidget('application.widgets.SeoContentWidget'); ?>
                        <div class="drp">
                            <div class="in">

                                <ul class="cols cols-3">
                                    <li class="col">
                                        <a class="big-link bg-img-31" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 29))?>">
                                            <span class="title">Красота</span>
                                            <span class="text">Как сохранить красоту и продлить молодость - проверенные рецепты, советы экспертов и новые технологии.</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a class="big-link bg-img-32" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 30))?>">
                                            <span class="title">Мода и шоппинг</span>
                                            <span class="text">Что нужно купить в этом сезоне? Где это продаётся? Есть ли скидки и акции? Для женщин, мужчин и детей – всё интересное о моде и покупках.</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a class="big-link bg-img-33" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 33))?>">
                                            <span class="title">Здоровье родителей</span>
                                            <span class="text">Вся информация о заболеваниях, их лечении и профилактике, народные советы и адреса клиник.</span>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <?php $this->endWidget();?>

                    </li>
                    <li class="home navdrp">
                        <a href="javascript:void(0);" onclick="navDrpOpen(this);"><i class="text"></i></a>

                        <?php $this->beginWidget('application.widgets.SeoContentWidget'); ?>
                        <div class="drp">
                            <div class="in">

                                <ul class="cols cols-5">
                                    <li class="col">
                                        <a class="big-link bg-img-41" href="<?= Yii::app()->createUrl('/cook')?>">
                                            <span class="title">Кулинарные рецепты</span>
                                            <span class="text">Рецепты на все случаи жизни: простые и сложные, диетические и многие другие.</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a class="big-link bg-img-42" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 23))?>">
                                            <span class="title">Детские рецепты</span>
                                            <span class="text">Готовим блюда, которые придутся по вкусу даже самому большому привереде.</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a class="big-link bg-img-43" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 26))?>">
                                            <span class="title">Интерьер и дизайн</span>
                                            <span class="text">Советы о том, как превратить свое жилье в уютное гнездышко.</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a class="big-link bg-img-44" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 28))?>">
                                            <span class="title">Домашние хлопоты</span>
                                            <span class="text">Превращаем самую тяжелую домашнюю работу в приятные хлопоты.</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a class="big-link bg-img-45"  href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 34))?>">
                                            <span class="title">Загородная жизнь</span>
                                            <span class="text">Как рационально использовать загородный участок: посадки, строительство, отдых.</span>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <?php $this->endWidget();?>

                    </li>
                    <li class="hobbies navdrp">
                        <a href="javascript:void(0);" onclick="navDrpOpen(this);"><i class="text"></i></a>

                        <?php $this->beginWidget('application.widgets.SeoContentWidget'); ?>
                        <div class="drp">
                            <div class="in">

                                <ul class="cols cols-4">
                                    <li class="col">
                                        <a class="big-link bg-img-51" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 24))?>">
                                            <span class="title">Своими руками</span>
                                            <span class="text">Здесь всегда можно найти нужную информацию и поделиться своими идеями по  рукоделию и творчеству.</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a class="big-link bg-img-52" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 25))?>">
                                            <span class="title">Мастерим детям</span>
                                            <span class="text">Мастер-классы и схемы по вязанию и шитью, для создания удивительных вещей вашими руками для детей.</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a class="big-link bg-img-53" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 27))?>">
                                            <span class="title">За рулем</span>
                                            <span class="text">Здесь вы узнаете все тонкости покупки и содержания авто, а также оформления на него документов.</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a class="big-link bg-img-54" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 35))?>">
                                            <span class="title">Цветоводство</span>
                                            <span class="text">Как выбрать комнатные цветы, куда поставить и что с ними делать – читайте в этом разделе.</span>
                                        </a>
                                    </li>
                                </ul>


                            </div>
                        </div>
                        <?php $this->endWidget();?>

                    </li>
                    <li class="rest navdrp">
                        <a href="javascript:void(0);" onclick="navDrpOpen(this);"><i class="text"></i></a>

                        <?php $this->beginWidget('application.widgets.SeoContentWidget'); ?>
                        <div class="drp">
                            <div class="in">

                                <ul class="cols cols-3">
                                    <li class="col">
                                        <a class="big-link bg-img-61" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 19))?>">
                                            <span class="title">Выходные с ребенком</span>
                                            <span class="text">Информация о том, где происходят самые интересные события, которые можно посетить вместе с ребенком. Отзывы тех, кто там уже был.</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a class="big-link bg-img-62" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 21))?>">
                                            <span class="title">Путешествия семьей</span>
                                            <span class="text">Планируем путешествие для всей семьи: выбираем маршрут, оформляем документы, едем, а потом делимся впечатлениями и фотографиями.</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a class="big-link bg-img-63" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 20))?>">
                                            <span class="title">Праздники</span>
                                            <span class="text">Как устроить потрясающий праздник для детей и взрослых. Как правильно выбирать подарки. Особенности религиозных праздников.</span>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <?php $this->endWidget();?>

                    </li>
                </ul>
            </div>

        </div>

    </div>

    <div id="content" class="clearfix">
        <?php
            $this->widget('zii.widgets.CBreadcrumbs', array(
                'links' => $this->breadcrumbs,
                'separator' => ' &gt; ',
                'htmlOptions' => array(
                    'id' => 'crumbs',
                    'class' => null,
                ),
            ));
        ?>

        <?= $content; ?>
    </div>

    <noindex><?php $this->widget('WhatsNewWidget') ?></noindex>

    <a href="#layout" id="btn-up-page"></a>
    <div class="push"></div>

<?php $this->endContent(); ?>