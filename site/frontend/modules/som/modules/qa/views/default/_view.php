<?php
use site\frontend\modules\som\modules\qa\models\QaQuestion;

/**
 * @var QaQuestion $question
 */
?>

<div class="b-col b-col--6 b-hidden-md">
    <div class="b-breadcrumbs b-breadcrumbs--theme-default">
        <ul class="b-breadcrumbs__list">
            <li class="b-breadcrumbs__item"><a href="javascript:voit(0);" class="b-breadcrumbs__link">Главная</a>
            </li>
            <li class="b-breadcrumbs__item">Мой педиатр</li>
        </ul>
    </div>
</div>
<div class="b-col b-col--6 b-col-sm--10 b-col-xs">
    <div class="b-mobile-nav">
        <div class="b-mobile-nav__title">Мой педиатор</div>
        <div class="b-mobile-nav__right"><a href="javascript:voit(0);" class="b-mobile-nav__btn btn btn--default">Задать вопрос</a>
        </div>
    </div>
    <div class="b-open-question">
        <!-- вопрос -->
        <div class="b-open-question-box">
            <div class="b-open-question__header b-open-header">
                <div class="b-open-header__item"><a href="javascript:voit(0);" class="b-answer-header__link"><?= CHtml::encode($question->author->fullName) ?></a>
                    <?= HHtml::timeTag($question, ['class' => 'b-answer-header__time']); ?>
                </div>
                <div class="b-open-header__item">
                    <span class="b-open-header__review b-open-header__review--ico-grey"><?= Yii::app()->getModule('analytics')->visitsManager->getVisits()?></span>
                </div>
            </div>
            <div class="b-open-question__body"><span class="b-title--h1 b-title--bold b-text-color--blue-link"><?= CHtml::encode($question->title) ?></span>
                <div class="b-open-question__wrapper b-question-wrapper">
                    <?php if (!is_null($question->tag)): ?>
                    <div class="b-question-wrapper__item">
                        <a href="<?= $this->createUrl('/som/qa/default/index/', ['categoryId' => $question->category->id, 'tagId' => $question->tag->id]) ?>" class="b-answer-footer__age b-text--link-color">
                            <?= $question->tag->name ?>
                        </a>
                    <?php endif; ?>
                    </div>
                    <div class="b-question-wrapper__item">
                        <div class="b-open-question__quant b-open-quant"><span class="b-open-quant__num"><?= $question->answersCount?></span><span class="b-open-quant__sub"><?= Yii::t('app', 'ответ|ответа|ответов|ответа', $question->answersCount)?></span>
                        </div>
                    </div>
                </div>
                <p class="b-text--size-14 b-text--black">
                    <?= $question->purified->text ?>
                </p>
                <div class="b-answer__footer b-answer-footer--theme-user"><span class="b-pediator-answer-quest__control">Редактировать</span><span class="b-pediator-answer-quest__control">Удалить</span>
                </div>
                <div class="b-open-question__nav b-open-nav">
                    <!-- TODO длинные названия? -->
                    <? if($previousQuestion = QaQuestion::getPreviousQuestion($question)): ?>
                        <div class="b-open-nav__item">
                            <a href="javascript:voit(0);" class="b-open-nav__link b-open-nav__link--left-ico"><?= CHtml::encode($previousQuestion->title) ?></a>
                        </div>
                    <? endif; ?>

                    <? if($nextQuestion = QaQuestion::getNextQuestion($question)): ?>
                        <div class="b-open-nav__item">
                            <a href="javascript:voit(0);" class="b-open-nav__link b-open-nav__link--right-ico"><?= CHtml::encode($nextQuestion->title) ?></a>
                        </div>
                    <? endif; ?>
                </div>
                <? if(!\Yii::app()->user->isGuest && $question->canBeAnsweredBy(\Yii::app()->user->id)):?>
                    <form id="createAnswer" action="/api/qa/createAnswer" method="post">
                        <input type="hidden" name="questionId" value="<?= $question->id?>">
                        <div class="b-redactor">
                            <div class="b-redactor__action">
                                <textarea id="js--redactor__textarea" placeholder="Введите ваш ответ" class="b-redactor__textarea" name="text"></textarea>
                            </div>
                            <div class="b-redactor__footer b-redactor-footer b-redactor-footer--theme-small">
                                <div class="b-redactor-footer__item">
                                    <div id="redactor-post-toolbar"></div>
                                </div>
                                <div class="b-redactor-footer__item">
                                    <button type="submit" class="btn btn--blue btn--sm">Ответить</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <script>
                        $(function(){
                            $("#createAnswer").bind("submit", function() {
                                $.post("/api/qa/createAnswer");

                                return false;
                            });
                        });
                    </script>
                <? endif;?>
            </div>
        </div>
        <!-- /вопрос-->
        <div class="b-open-question__title">Ответы</div>
        <div class="b-margin--bottom_60">
            <ul class="b-answer">
                <li class="b-answer__item">
                    <div class="b-pediator-answer">
                        <div class="b-pediator-answer__left">
                            <div class="b-pediator-answer__ava b-pediator-answer__ava--theme-pink">
                                <a href="javascript:voit(0);" class="ava ava--theme-pedaitor ava--medium ava--medium_male">
                                    <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                </a>
                            </div>
                        </div>
                        <div class="b-pediator-answer__right b-pediator-answer__right--pink">
                            <div class="b-answer__header b-answer-header"><a href="javascript:voit(0);" class="b-answer-header__link">Владимир Александрович</a>
                                <time class="b-answer-header__time">5 минут назад</time>
                                <div class="b-answer-header__spezialisation">педиатр, детский хирург</div>
                                <div class="b-answer-header__box b-answer-header-box">
                                    <div class="b-answer-header-box__item"><span class="b-text-color--grey b-text--size-12">Ответы 562</span>
                                    </div>
                                    <div class="b-answer-header-box__item"><span class="b-answer-header-box__roze"><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span>
                                                                <span
                                                                    class="b-answer-header-box__ico"></span>
                                                                    </span><span class="b-text-color--grey b-text--size-12">869</span>
                                    </div>
                                </div>
                            </div>
                            <div class="b-answer__body b-answer-body">
                                <p class="b-pediator-answer__text">Добрый день. Конечно же можно. Но только нужно гулять чтобы была комфортная температура для ребенка, не кутайте его. и поменьше контактируйте с другими людьми. Можно подключить противовоспалительные
                                    препараты для носа или противовирусные средства: Назаваль плюс, Анаферон, Гриппферон, Виферон. Можно выбрать любое из этих средств, только внимательно посмотрите на необходимую дозировку.</p>
                            </div>
                        </div>
                        <div class="b-pedaitor-answer__footer b-answer-footer b-answer-footer--pink">
                            <div class="b-pedaitor-answer__footer__item"><span class="b-pediator-answer-quest__event">Ответить</span>
                            </div>
                            <div class="b-pedaitor-answer__footer__item">
                                <button type="button" class="btn-answer btn-answer--theme-green"><span class="btn-answer__num btn-answer__num--theme-green">Спасибо 98</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="b-answer__item">
                    <div class="b-pediator-answer">
                        <div class="b-pediator-answer__left">
                            <div class="b-pediator-answer__ava b-pediator-answer__ava--theme-pink">
                                <a href="javascript:voit(0);" class="ava ava--theme-pedaitor ava--medium ava--medium_male">
                                    <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                </a>
                            </div>
                        </div>
                        <div class="b-pediator-answer__right b-pediator-answer__right--pink">
                            <div class="b-answer__header b-answer-header"><a href="javascript:voit(0);" class="b-answer-header__link">Владимир Александрович</a>
                                <time class="b-answer-header__time">5 минут назад</time>
                                <div class="b-answer-header__spezialisation">педиатр, детский хирург</div>
                                <div class="b-answer-header__box b-answer-header-box">
                                    <div class="b-answer-header-box__item"><span class="b-text-color--grey b-text--size-12">Ответы 562</span>
                                    </div>
                                    <div class="b-answer-header-box__item"><span class="b-answer-header-box__roze"><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span>
                                                                <span
                                                                    class="b-answer-header-box__ico"></span>
                                                                    </span><span class="b-text-color--grey b-text--size-12">869</span>
                                    </div>
                                </div>
                            </div>
                            <div class="b-answer__body b-answer-body">
                                <p class="b-pediator-answer__text">Добрый день. Конечно же можно. Но только нужно гулять чтобы была комфортная температура для ребенка, не кутайте его. и поменьше контактируйте с другими людьми. Можно подключить противовоспалительные
                                    препараты для носа или противовирусные средства: Назаваль плюс, Анаферон, Гриппферон, Виферон. Можно выбрать любое из этих средств, только внимательно посмотрите на необходимую дозировку.</p>
                            </div>
                        </div>
                        <div class="b-pedaitor-answer__footer b-answer-footer b-answer-footer--pink">
                            <div class="b-pedaitor-answer__footer__item"></div>
                            <div class="b-pedaitor-answer__footer__item">
                                <button type="button" class="btn-answer btn-answer--theme-green btn-answer--active"><span class="btn-answer__num btn-answer__num--theme-green">Спасибо 98</span>
                                </button>
                            </div>
                        </div>
                        <ul class="b-pediator-answer__quest b-pediator-answer-quest">
                            <li class="b-pediator-answer-quest__item">
                                <div class="b-answer__header b-answer-header"><span class="b-answer-header__link">Ирина, Донецк</span>
                                    <time class="b-answer-header__time">2 минут назад</time>
                                </div>
                                <div class="b-answer__body b-answer-body">
                                    <p class="b-pediator-answer__text">Уважаемая Нина если это поможет ответу, то да мой сын уже давно орудует ложкой!!!</p>
                                </div>
                            </li>
                            <li class="b-pediator-answer-quest__item b-pediator-answer-quest__item--left">
                                <div class="b-pediator-answer__left">
                                    <div class="b-pediator-answer__ava b-pediator-answer__ava--theme-pink">
                                        <a href="javascript:voit(0);" class="ava ava--theme-pedaitor ava--small ava--medium_male">
                                            <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                        </a>
                                    </div>
                                </div>
                                <div class="b-pediator-answer__right-small b-pediator-answer__right--pink">
                                    <div class="b-answer__header b-answer-header"><a href="javascript:voit(0);" class="b-answer-header__link">Владимир Александрович</a>
                                        <time class="b-answer-header__time">5 минут назад</time>
                                        <div class="b-answer-header__spezialisation">педиатр, детский хирург</div>
                                        <div class="b-answer-header__box b-answer-header-box">
                                            <div class="b-answer-header-box__item"><span class="b-text-color--grey b-text--size-12">Ответы 562</span>
                                            </div>
                                            <div class="b-answer-header-box__item"><span class="b-answer-header-box__roze"><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span>
                                                                        <span
                                                                            class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span></span><span class="b-text-color--grey b-text--size-12">869</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="b-answer__body b-answer-body">
                                        <p class="b-pediator-answer__text">Добрый день. Конечно же можно. Но только нужно гулять чтобы была комфортная температура для ребенка</p>
                                    </div>
                                </div>
                            </li>
                            <li class="b-pediator-answer-quest__item">
                                <div class="b-answer__header b-answer-header"><span class="b-answer-header__link">Ирина, Донецк</span>
                                    <time class="b-answer-header__time">2 минут назад</time>
                                </div>
                                <div class="b-answer__body b-answer-body">
                                    <p class="b-pediator-answer__text">Уважаемая Нина если это поможет ответу, то да мой сын уже давно орудует ложкой!!!</p>
                                </div>
                                <div class="b-answer__footer b-answer-footer"><span class="b-pediator-answer-quest__control">Редактировать</span><span class="b-pediator-answer-quest__control">Удалить</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <p class="b-rest-block"><span>Ваш ответ успешно удален и баллы сняты</span><a href="javascript:voit(0);" class="b-rest-block__link">Восстановить</a>
                </p>
                <li class="b-answer__item">
                    <div class="b-pediator-answer">
                        <div class="b-pediator-answer__left">
                            <div class="b-pediator-answer__ava b-pediator-answer__ava--theme-pink">
                                <a href="javascript:voit(0);" class="ava ava--style ava--medium ava--medium_male">
                                    <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                </a>
                            </div>
                        </div>
                        <div class="b-pediator-answer__right">
                            <div class="b-answer__header b-answer-header"><a href="javascript:voit(0);" class="b-answer-header__link">Мария Мочалова</a>
                                <time class="b-answer-header__time">5 минут назад</time>
                                <div class="b-answer-header__box b-answer-header-box">
                                    <div class="b-answer-header-box__item"><span class="b-text-color--grey b-text--size-12">Ответы 562</span>
                                    </div>
                                    <div class="b-answer-header-box__item"><span class="b-answer-header-box__roze"><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span></span>
                                        <span
                                            class="b-text-color--grey b-text--size-12">869</span>
                                    </div>
                                </div>
                            </div>
                            <div class="b-answer__body b-answer-body">
                                <p class="b-pediator-answer__text">Незадолго до издания указа, министр обороны России Сергей Шойгу заявил о начале совместной с властями САР масштабной гуманитарной операции в Алеппо</p>
                            </div>
                        </div>
                        <div class="b-pedaitor-answer__footer b-answer-footer b-answer-footer--pink">
                            <div class="b-pedaitor-answer__footer__item"><a href="javascript:voit(0);" class="b-answer-footer__comment">10</a>
                            </div>
                            <div class="b-pedaitor-answer__footer__item">
                                <button type="button" class="btn-answer btn-answer--theme-green"><span class="btn-answer__num btn-answer__num--theme-green">Спасибо 98</span>
                                </button>
                            </div>
                        </div>
                        <ul class="b-pediator-answer__quest b-pediator-answer-quest">
                            <li class="b-pediator-answer-quest__item">
                                <div class="b-answer__header b-answer-header"><span class="b-answer-header__link">Ирина, Донецк</span>
                                    <time class="b-answer-header__time">2 минут назад</time>
                                </div>
                                <div class="b-answer__body b-answer-body">
                                    <p class="b-pediator-answer__text">возможно если это поможет ответу, то да мой сын уже давно орудует ложкой!!!</p>
                                </div>
                            </li>
                            <li class="b-pediator-answer-quest__item b-pediator-answer-quest__item--left">
                                <div class="b-pediator-answer__left">
                                    <div class="b-pediator-answer__ava b-pediator-answer__ava--theme-pink">
                                        <a href="javascript:voit(0);" class="ava ava--style ava--small ava--medium_male">
                                            <img src="http://gravitsapa.com/wp-content/images2_1/sasha_grej_pokazala_novogo_bojfrenda.jpg" class="ava__img" />
                                        </a>
                                    </div>
                                </div>
                                <div class="b-pediator-answer__right-small">
                                    <div class="b-answer__header b-answer-header"><span class="b-answer-header__link">Ирина, Донецк</span>
                                        <time class="b-answer-header__time">2 минут назад</time>
                                        <div class="b-answer-header__box b-answer-header-box">
                                            <div class="b-answer-header-box__item"><span class="b-text-color--grey b-text--size-12">Ответы 129</span>
                                            </div>
                                            <div class="b-answer-header-box__item"><span class="b-answer-header-box__roze"><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span><span class="b-answer-header-box__ico"></span></span>
                                                <span
                                                    class="b-text-color--grey b-text--size-12">545</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="b-answer__body b-answer-body">
                                        <p class="b-pediator-answer__text">Уважаемая Нина если это поможет ответу, то да мой сын уже давно орудует ложкой!!!</p>
                                    </div>
                                    <div class="b-answer__footer b-answer-footer"><span class="b-pediator-answer-quest__event">Ответить</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>