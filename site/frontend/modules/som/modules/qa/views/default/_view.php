<?php

use site\frontend\modules\som\modules\qa\components\QaManager;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\widgets\answers\AnswersWidget;

/**
 * @var QaQuestion $question
 */
$this->pageTitle = 'Мой педиатр - ' . $question->title;
?>

<?php

    $breadcrumbs = [
        'Главная' => ['/site/index'],
        'Мой педиатр' => ['/som/qa/default/pediatrician'],
    ];

    $tag = $question->tag;

    if (!is_null($question->attachedChild) and !is_null($question->attChild)) {
        $arrFooterData = $question->attChild->getAnswerFooterData();
        $tag = $arrFooterData['tag'];
    }

    if (!is_null($tag))
    {
        $breadcrumbs[$tag->name] = $this->createUrl('/som/qa/default/pediatrician', ['tab' => 'new', 'tagId' => $tag->id]);
    }

    $breadcrumbs[] = CHtml::encode($question->title);

    \Yii::app()->clientScript->registerAMD(
        'Realplexor-reg',
        [
            'common',
            'comet'
        ],
        'comet.connect(\'http://' . \Yii::app()->comet->host . '\', \'' . \Yii::app()->comet->namespace . '\', \'' . QaManager::getQuestionChannelId($question->id) . '\');'
    );

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
        <div class="b-mobile-nav__title">Мой педиатр</div>
        <div class="b-mobile-nav__right">
            <a href="javascript:void(0);" class="b-mobile-nav__btn btn btn--default">Задать вопрос</a>
        </div>
    </div>
    <div class="b-open-question">
        <!-- вопрос -->
        <div class="b-open-question-box">
            <div class="b-open-question__header b-open-header">
                <div class="b-open-header__item">
                    <span class="b-answer-header__link"><?= $question->user->getAnonName(); ?></span>
                    <?= HHtml::timeTag($question, ['class' => 'b-answer-header__time']); ?>
                </div>
                <div class="b-open-header__item">
                    <span class="b-open-header__review b-open-header__review--ico-grey">
                        <?= Yii::app()->getModule('analytics')->visitsManager->getVisits() ?>
                    </span>
                </div>
            </div>
            <div class="b-open-question__body">
                <div id="js-question-data">
                    <span class="b-title--h1 b-title--bold b-text-color--blue-link" data-bind="text: title()"><?= CHtml::encode($question->title) ?></span>
                    <div class="b-open-question__wrapper b-question-wrapper">

                        <?php if (!is_null($tag)) { ?>

                        <div class="b-question-wrapper__item">
                            <a href="<?= $this->createUrl('/som/qa/default/index/', ['categoryId' => $question->category->id, 'tagId' => $tag->id]) ?>" class="b-answer-footer__age b-text--link-color" data-bind="attr: {href: tagUrl()}">
                                <i aria-hidden="true" class="icon icon-tag"></i>&nbsp;&nbsp;<span data-bind="text: tagTitle()"><?= $tag->getTitle() ?></span>
                            </a>
                        </div>

                        <?php } ?>

                        <!-- ko stopBinding: true -->

                        <mp-answers-count-widget params="count: <?= $answersCount ?>, countText: '<?= \Yii::t('app', 'ответ|ответа|ответов|ответа', $answersCount); ?>'">

                            <div class="b-question-wrapper__item">
                                <div class="b-open-question__quant b-open-quant">
                                    <span class="b-open-quant__num"><?= $answersCount ?></span>
                                    <span class="b-open-quant__sub"><?= Yii::t('app', 'ответ|ответа|ответов|ответа', $answersCount) ?></span>
                                </div>
                            </div>

                        </mp-answers-count-widget>

                        <!-- /ko -->

                    </div>
                    <div class="b-text--size-14 b-text--black" data-bind="html: text()">
                        <p ><?= $question->purified->text; ?></p>
                    </div>
                </div>

                <?php
                    \Yii::app()->clientScript->registerAMD(
                        'questionData',
                        [
                            'ko'                => 'knockout',
                            'QuestionData'      => 'mypediatrician/question-data',
                            'ko_library'        => 'ko_library'
                        ],
                        '
                            ko.applyBindings(new QuestionData(' . CJSON::encode($question->toJSON()) . '),
                            document.getElementById("js-question-data"));
                        '
                    );
                ?>

                <?php
                    $isOwner = !\Yii::app()->user->isGuest && \Yii::app()->user->id == $question->authorId;

                    if ($isOwner):
                ?>

                    <mp-question-actions-widget params="id: <?= $question->id; ?>, answersCount: <?= $question->answersCount; ?>, redirectUrl: <?= $this->createUrl('/som/qa/default/pediatrician'); ?>, editUrl: '<?= $this->createUrl('/som/qa/default/pediatricianEditForm', ['questionId' => $question->id]); ?>'"></mp-question-actions-widget>

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

                <?php if (\Yii::app()->user->isGuest): ?>

                    <?php $this->widget('site.frontend.modules.signup.widgets.AuthWidget', ['view' => 'comments_new']); ?>

                <?php elseif ($question->canBeAnsweredBy(\Yii::app()->user->id)): ?>

                    <div id="js-question-reply-form" class="b-redactor">
                        <!-- ko if: isFormEnabled() -->
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
                                <button type="button" class="btn btn--blue btn--sm" data-bind="css: {'disabled': isSubmitDisabled()},click: addAnswerToQuestion">Ответить</button>
                            </div>
                        </div>
                        <!-- /ko -->
                    </div>

                    <?php
                    $params = [
                        'questionId'    => $question->id,
                        'isEditing'     => $isEditing
                    ];

                    \Yii::app()->clientScript->registerAMD(
                        'questionReplyForm',
                        [
                            'ko'                => 'knockout',
                            'QuestionReplyForm' => 'mypediatrician/question-reply-form',
                            'ko_library'        => 'ko_library'
                        ],
                        '
                                ko.applyBindings(new QuestionReplyForm(' . CJSON::encode($params) . '),
                                document.getElementById("js-question-reply-form"));
                            '
                    );

                    ?>

                <?php endif; ?>

            </div>
        </div>

        <div class="b-open-question__title">Ответы</div>
        <div class="b-margin--bottom_60">

            <mp-answers-widget params='questionData: <?= CJSON::encode($question->toJSON()); ?>, answersList: <?= CJSON::encode($answersTreeList); ?>, isEditing: <?= $isEditing; ?>'>

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
    </div>
</div>


