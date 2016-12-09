<?php
/**
 * @var $this site\frontend\modules\som\modules\qa\controllers\DefaultController
 * @var string $content
 * @var site\frontend\modules\som\modules\qa\widgets\ConsultationsMenu $consultationsMenu
 */
$this->beginContent('//layouts/lite/new_main');
$this->renderSidebarClip();
?>
 <div class="b-col__container">
	<?=$content?>
     <aside class="b-main__aside b-col b-col--3 b-hidden-md">
        <?php $this->renderPartial('/_sidebar/new_ask');?>
       	<?php $this->renderPartial('/_sidebar/new_menu');?>
        <div class="b-text--left b-margin--bottom_40">
            <div class="b-user-box b-user-box--yellow">
                <div class="b-user-box__item">
                    <div class="b-user-box__num b-user-box__num--black">6888</div>
                    <div class="b-user-box__text">пользователей уже
                        <br/>получили помощь</div>
                </div>
                <div class="b-user-box__item">
                    <div class="b-user-box__num b-user-box__num--green b-user-box__num--position">65834</div>
                    <div class="b-user-box__text">раз уже сказали Спасибо!</div>
                </div>
            </div>
        </div>
        <div class="b-text--left b-margin--bottom_40">
            <div class="b-sidebar-widget">
                <div class="b-sidebar-widget__header b-sidebar-widget-header b-sidebar-widget-header--red">
                    <div class="b-sidebar-widget-header__title b-sidebar-widget-header-title b-sidebar-widget-header-title--white">Педиатор декабря</div>
                </div>
                <ul class="b-sidebar-widget__body b-sidebar b-sidebar-widget__body--white">
                    <li class="b-sidebar__item">
                        <div class="b-sidebar__place"><span class="b-sidebar__place--yellow"></span>
                        </div>
                        <div class="b-sidebar__content b-sidebar-content b-sidebar-content--mod">
                            <div class="b-sidebar-content__box">
                                <a href="javascript:void(0)" class="ava ava--style ava--medium ava--default">
                                    <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                </a>
                            </div>
                            <div class="b-sidebar-content__box"><a href="javascript:voit(0);" class="b-sidebar-content__link">Александр Владим…</a><span class="b-sidebar-content__answer b-sidebar-content__answer--grey"> Ответы 44</span><span class="b-sidebar-content__thank b-sidebar-content__thank--grey">24</span>
                            </div>
                        </div>
                        <div class="b-sidebar__right b-text--right">
                            <div class="b-sidebar__num b-sidebar__num--grey">68</div>
                            <div class="b-sidebar__balls b-sidebar__balls--grey">баллов</div>
                        </div>
                    </li>
                    <li class="b-sidebar__item">
                        <div class="b-sidebar__place"><span class="b-sidebar__place--blue"></span>
                        </div>
                        <div class="b-sidebar__content b-sidebar-content b-sidebar-content--mod">
                            <div class="b-sidebar-content__box">
                                <a href="javascript:void(0)" class="ava ava--style ava--medium ava--default">
                                    <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                </a>
                            </div>
                            <div class="b-sidebar-content__box"><a href="javascript:voit(0);" class="b-sidebar-content__link">Тамара Михайловна</a><span class="b-sidebar-content__answer b-sidebar-content__answer--grey"> Ответы 44</span><span class="b-sidebar-content__thank b-sidebar-content__thank--grey">24</span>
                            </div>
                        </div>
                        <div class="b-sidebar__right b-text--right">
                            <div class="b-sidebar__num b-sidebar__num--grey">68</div>
                            <div class="b-sidebar__balls b-sidebar__balls--grey">баллов</div>
                        </div>
                    </li>
                    <li class="b-sidebar__item">
                        <div class="b-sidebar__place"><span class="b-sidebar__place--green"></span>
                        </div>
                        <div class="b-sidebar__content b-sidebar-content b-sidebar-content--mod">
                            <div class="b-sidebar-content__box">
                                <a href="javascript:void(0)" class="ava ava--style ava--medium ava--default">
                                    <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                </a>
                            </div>
                            <div class="b-sidebar-content__box"><a href="javascript:voit(0);" class="b-sidebar-content__link">Ирина Викторовна К.</a><span class="b-sidebar-content__answer b-sidebar-content__answer--grey"> Ответы 44</span><span class="b-sidebar-content__thank b-sidebar-content__thank--grey">24</span>
                            </div>
                        </div>
                        <div class="b-sidebar__right b-text--right">
                            <div class="b-sidebar__num b-sidebar__num--grey">68</div>
                            <div class="b-sidebar__balls b-sidebar__balls--grey">баллов</div>
                        </div>
                    </li>
                    <li class="b-sidebar__item">
                        <div class="b-sidebar__place"><span class="b-sidebar__place--grey">4</span>
                        </div>
                        <div class="b-sidebar__content b-sidebar-content b-sidebar-content--mod">
                            <div class="b-sidebar-content__box">
                                <a href="javascript:void(0)" class="ava ava--style ava--medium ava--default">
                                    <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                </a>
                            </div>
                            <div class="b-sidebar-content__box"><a href="javascript:voit(0);" class="b-sidebar-content__link">Денис Петрович Ж.</a><span class="b-sidebar-content__answer b-sidebar-content__answer--grey"> Ответы 44</span><span class="b-sidebar-content__thank b-sidebar-content__thank--grey">24</span>
                            </div>
                        </div>
                        <div class="b-sidebar__right b-text--right">
                            <div class="b-sidebar__num b-sidebar__num--grey">68</div>
                            <div class="b-sidebar__balls b-sidebar__balls--grey">баллов</div>
                        </div>
                    </li>
                    <li class="b-sidebar__item">
                        <div class="b-sidebar__place"><span class="b-sidebar__place--grey">5</span>
                        </div>
                        <div class="b-sidebar__content b-sidebar-content b-sidebar-content--mod">
                            <div class="b-sidebar-content__box">
                                <a href="javascript:void(0)" class="ava ava--style ava--medium ava--default">
                                    <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                </a>
                            </div>
                            <div class="b-sidebar-content__box"><a href="javascript:voit(0);" class="b-sidebar-content__link">Денис Петрович Ж.</a><span class="b-sidebar-content__answer b-sidebar-content__answer--grey"> Ответы 44</span><span class="b-sidebar-content__thank b-sidebar-content__thank--grey">24</span>
                            </div>
                        </div>
                        <div class="b-sidebar__right b-text--right">
                            <div class="b-sidebar__num b-sidebar__num--grey">68</div>
                            <div class="b-sidebar__balls b-sidebar__balls--grey">баллов</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <?php
        $title       = isset($title) ? $title : null;
        $titlePrefix = isset($titlePrefix) ? $titlePrefix : null;
        $viewFileName = isset($viewFileName) ? $viewFileName : 'view';

        $this->widget('site\frontend\modules\som\modules\qa\widgets\usersTop\NewUsersTopWidget', [
//             'authorId'      => \Yii::app()->user->id,
            'titlePrefix'   => 'Знаток',
            'viewFileName'  => 'view_pediatrician',
        ]);
        ?>
        <?php /**
        <div class="b-text--left b-margin--bottom_40">
            <div class="b-sidebar-widget">
                <div class="b-sidebar-widget__header b-sidebar-widget-header b-sidebar-widget-header--green">
                    <div class="b-sidebar-widget-header__title b-sidebar-widget-header-title b-sidebar-widget-header-title--white">Знаток июля</div>
                </div>
                <ul class="b-sidebar-widget__body b-sidebar b-sidebar-widget__body--green">
                    <li class="b-sidebar__item">
                        <div class="b-sidebar__place"><span class="b-sidebar__place--yellow"></span>
                        </div>
                        <div class="b-sidebar__content b-sidebar-content b-sidebar-content--mod">
                            <div class="b-sidebar-content__box">
                                <a href="javascript:void(0)" class="ava ava--style ava--medium ava--default">
                                    <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                </a>
                            </div>
                            <div class="b-sidebar-content__box"><a href="javascript:voit(0);" class="b-sidebar-content__link b-sidebar-content__link--white">Александр Владим…</a><span class="b-sidebar-content__answer b-sidebar-content__answer--white"> Ответы 44</span>
                                <span
                                class="b-sidebar-content__thank b-sidebar-content__thank--white">24</span>
                            </div>
                        </div>
                        <div class="b-sidebar__right b-text--right">
                            <div class="b-sidebar__num b-sidebar__num--white">68</div>
                            <div class="b-sidebar__balls b-sidebar__balls--white">баллов</div>
                        </div>
                    </li>
                    <li class="b-sidebar__item">
                        <div class="b-sidebar__place"><span class="b-sidebar__place--blue"></span>
                        </div>
                        <div class="b-sidebar__content b-sidebar-content b-sidebar-content--mod">
                            <div class="b-sidebar-content__box">
                                <a href="javascript:void(0)" class="ava ava--style ava--medium ava--default">
                                    <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                </a>
                            </div>
                            <div class="b-sidebar-content__box"><a href="javascript:voit(0);" class="b-sidebar-content__link b-sidebar-content__link--white">Тамара Михайловна</a><span class="b-sidebar-content__answer b-sidebar-content__answer--white"> Ответы 44</span>
                                <span
                                class="b-sidebar-content__thank b-sidebar-content__thank--white">24</span>
                            </div>
                        </div>
                        <div class="b-sidebar__right b-text--right">
                            <div class="b-sidebar__num b-sidebar__num--white">68</div>
                            <div class="b-sidebar__balls b-sidebar__balls--white">баллов</div>
                        </div>
                    </li>
                    <li class="b-sidebar__item">
                        <div class="b-sidebar__place"><span class="b-sidebar__place--green"></span>
                        </div>
                        <div class="b-sidebar__content b-sidebar-content b-sidebar-content--mod">
                            <div class="b-sidebar-content__box">
                                <a href="javascript:void(0)" class="ava ava--style ava--medium ava--default">
                                    <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                </a>
                            </div>
                            <div class="b-sidebar-content__box"><a href="javascript:voit(0);" class="b-sidebar-content__link b-sidebar-content__link--white">Ирина Викторовна К.</a><span class="b-sidebar-content__answer b-sidebar-content__answer--white"> Ответы 44</span>
                                <span
                                class="b-sidebar-content__thank b-sidebar-content__thank--white">24</span>
                            </div>
                        </div>
                        <div class="b-sidebar__right b-text--right">
                            <div class="b-sidebar__num b-sidebar__num--white">68</div>
                            <div class="b-sidebar__balls b-sidebar__balls--white">баллов</div>
                        </div>
                    </li>
                    <li class="b-sidebar__item">
                        <div class="b-sidebar__place"><span class="b-sidebar__place--white">4</span>
                        </div>
                        <div class="b-sidebar__content b-sidebar-content b-sidebar-content--mod">
                            <div class="b-sidebar-content__box">
                                <a href="javascript:void(0)" class="ava ava--style ava--medium ava--default">
                                    <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                </a>
                            </div>
                            <div class="b-sidebar-content__box"><a href="javascript:voit(0);" class="b-sidebar-content__link b-sidebar-content__link--white">Денис Петрович Ж.</a><span class="b-sidebar-content__answer b-sidebar-content__answer--white"> Ответы 44</span>
                                <span
                                class="b-sidebar-content__thank b-sidebar-content__thank--white">24</span>
                            </div>
                        </div>
                        <div class="b-sidebar__right b-text--right">
                            <div class="b-sidebar__num b-sidebar__num--white">68</div>
                            <div class="b-sidebar__balls b-sidebar__balls--white">баллов</div>
                        </div>
                    </li>
                    <li class="b-sidebar__item">
                        <div class="b-sidebar__place"><span class="b-sidebar__place--white">5</span>
                        </div>
                        <div class="b-sidebar__content b-sidebar-content b-sidebar-content--mod">
                            <div class="b-sidebar-content__box">
                                <a href="javascript:void(0)" class="ava ava--style ava--medium ava--default">
                                    <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                </a>
                            </div>
                            <div class="b-sidebar-content__box"><a href="javascript:voit(0);" class="b-sidebar-content__link b-sidebar-content__link--white">Денис Петрович Ж.</a><span class="b-sidebar-content__answer b-sidebar-content__answer--white"> Ответы 44</span>
                                <span
                                class="b-sidebar-content__thank b-sidebar-content__thank--white">24</span>
                            </div>
                        </div>
                        <div class="b-sidebar__right b-text--right">
                            <div class="b-sidebar__num b-sidebar__num--white">68</div>
                            <div class="b-sidebar__balls b-sidebar__balls--white">баллов</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        **/?>
    </aside>
</div>
<?php $this->endContent(); ?>