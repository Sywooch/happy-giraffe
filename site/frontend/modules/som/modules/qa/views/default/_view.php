<?php

use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\widgets\answers\AnswersWidget;

/**
 * @var QaQuestion $question
 */

?>

<?php
$breadcrumbs = [
    'Главная' => ['/site/index'],
    'Педиатр' => ['/som/qa/default/pediatrician'],
];

$tag = $question->tag;

if (!is_null($question->attachedChild)) {
    $arrFooterData = $question->attChild->getAnswerFooterData();
    $tag = $arrFooterData['tag'];
}

$breadcrumbs[$tag->name] = $this->createUrl('/som/qa/default/pediatrician', ['tab' => 'new', 'tagId' => $tag->id]);
$breadcrumbs[] = CHtml::encode($question->title);

?>

<div class="b-col b-col--6 b-hidden-md">
    <div class="b-breadcrumbs b-breadcrumbs--theme-default">
        <ul class="b-breadcrumbs__list">

            <?php

                $this->widget('zii.widgets.CBreadcrumbs', [
                    'links'                 => $breadcrumbs,
                    'tagName'               => 'ul',
                    'homeLink'              => false,
                    'separator'             => '',
                    'activeLinkTemplate'    => '<li class="b-breadcrumbs__item"><a href="{url}" class="b-breadcrumbs__link">{label}</a></li>',
                    'inactiveLinkTemplate'  => '<li class="b-breadcrumbs__item">{label}</li>',
                ]);

            ?>

        </ul>
    </div>
</div>

<div class="b-col b-col--6 b-col-sm--10 b-col-xs">
    <div class="b-mobile-nav">
        <div class="b-mobile-nav__title">Мой педиатор</div>
        <div class="b-mobile-nav__right">
            <a href="javascript:void(0);" class="b-mobile-nav__btn btn btn--default">Задать вопрос</a>
        </div>
    </div>
    <div class="b-open-question">
        <!-- вопрос -->
        <div class="b-open-question-box">
            <div class="b-open-question__header b-open-header">
                <div class="b-open-header__item">
                    <a href="javascript:void(0);" class="b-answer-header__link"><?= CHtml::encode($question->author->fullName); ?></a>
                    <?= HHtml::timeTag($question, ['class' => 'b-answer-header__time']); ?>
                </div>
                <div class="b-open-header__item">
                    <span class="b-open-header__review b-open-header__review--ico-grey">
                        <?= Yii::app()->getModule('analytics')->visitsManager->getVisits() ?>
                    </span>
                </div>
            </div>
            <div class="b-open-question__body">
                <span class="b-title--h1 b-title--bold b-text-color--blue-link"><?= CHtml::encode($question->title) ?></span>
                <div class="b-open-question__wrapper b-question-wrapper">
                    <?php if (!is_null($tag)) { ?>
                    <div class="b-question-wrapper__item">
                        <a href="<?= $this->createUrl('/som/qa/default/index/', ['categoryId' => $question->category->id, 'tagId' => $tag->id]) ?>"
                           class="b-answer-footer__age b-text--link-color">
                            <?= $tag->getTitle() ?>
                        </a>
                    </div>
                    <?php } ?>

                    <mp-answers-count-widget params="count: <?= $question->answersCount ?>, countText: '<?= \Yii::t('app', 'ответ|ответа|ответов|ответа', $question->answersCount); ?>'">

                        <div class="b-question-wrapper__item">
                            <div class="b-open-question__quant b-open-quant">
                                <span class="b-open-quant__num"><?= $question->answersCount ?></span>
                                <span class="b-open-quant__sub"><?= Yii::t('app', 'ответ|ответа|ответов|ответа', $question->answersCount) ?></span>
                            </div>
                        </div>

                    </mp-answers-count-widget>

                </div>
                <p class="b-text--size-14 b-text--black">
                    <?= $question->purified->text; ?>
                </p>

                <?php if (! \Yii::app()->user->isGuest && \Yii::app()->user->id == $question->authorId): ?>

                    <div class="b-answer__footer b-answer-footer--theme-user">
                        <span class="b-pediator-answer-quest__control">Редактировать</span>
                        <span class="b-pediator-answer-quest__control">Удалить</span>
                    </div>

                <?php endif; ?>

                <div class="b-open-question__nav b-open-nav">

                    <?php if ($previousQuestion = QaQuestion::getPreviousQuestion($question)): ?>

                        <div class="b-open-nav__item">
                            <a href="<?= $previousQuestion->url; ?>" class="b-open-nav__link b-open-nav__link--left-ico"><?= CHtml::encode($previousQuestion->title) ?></a>
                        </div>

                    <?php endif; ?>

                    <?php if ($nextQuestion = QaQuestion::getNextQuestion($question)): ?>

                        <div class="b-open-nav__item">
                            <a href="<?= $nextQuestion->url; ?>" class="b-open-nav__link b-open-nav__link--right-ico"><?= CHtml::encode($nextQuestion->title) ?></a>
                        </div>

                    <?php endif; ?>

                </div>

                <?php if (\Yii::app()->user->isGuest || $question->canBeAnsweredBy(\Yii::app()->user->id)): ?>

                <div id="js-question-reply-form" class="b-redactor">
                    <div class="b-redactor__action">
                        <textarea
                            id="js--redactor__textarea"
                            placeholder="Введите ваш ответ"
                            class="b-redactor__textarea"
                            data-bind="wswgHG: { config: {
                                    minHeight: 140,
                                    plugins: ['text', 'imageCustom', 'smilesModal'],
                                    toolbarExternal: '.redactor-post-toolbar',
                                    placeholder: 'Введите ваш ответ',
                                    focus: true,
                                    callbacks: {

                                    }
                                }, attr: text }"
                        >
                        </textarea>
                    </div>
                    <div class="b-redactor__footer b-redactor-footer b-redactor-footer--theme-small">
                        <div class="b-redactor-footer__item">
                            <div class="redactor-post-toolbar"></div>
                        </div>
                        <div class="b-redactor-footer__item">
                            <button type="button" class="btn btn--blue btn--sm" data-bind="click: addAnswerToQuestion">Ответить</button>
                        </div>
                    </div>
                </div>

                <?php

                    \Yii::app()->clientScript->registerAMD(
                        'questionReplyForm',
                        [
                            'ko'                => 'knockout',
                            'QuestionReplyForm' => 'mypediatrician/question-reply-form',
                            'ko_library'        => 'ko_library'
                        ],
                        '
                            ko.applyBindings(new QuestionReplyForm(' . CJSON::encode(['questionId' => $question->id]) . '),
                            document.getElementById("js-question-reply-form"));
                        '
                    );

                ?>

                <?php endif; ?>

            </div>
        </div>

        <div class="b-open-question__title">Ответы</div>
        <div class="b-margin--bottom_60">

            <mp-answers-widget params='questionData: <?= CJSON::encode($question->toJSON()); ?>, answersList: <?= CJSON::encode($answersTreeList); ?>'>

                <div class="preloader-answer">
                    <div class="preloader__inner">
                        <div class="preloader__box">
                            <span class="preloader__ico preloader__ico--md"></span>
                        </div>
                        <span class="preloader__text">Загрузка</span>
                    </div>
                </div>

            </mp-answers-widget>

        </div>

        <?php // $this->widget(AnswersWidget::class, ['question' => $question]); ?>

    </div>
</div>


