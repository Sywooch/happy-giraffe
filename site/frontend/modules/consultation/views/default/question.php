<?php
/**
 * @var \site\frontend\modules\consultation\models\ConsultationQuestion $question
 */
?>

<div class="b-main_col-article">
    <!-- Статья с текстом-->
    <!-- b-article-->
    <article class="b-article b-article__single clearfix b-article__lite">
        <div class="b-article_cont clearfix">
            <div class="b-article_header clearfix">
                <div class="float-l">
                    <a href="<?=$question->user->profileUrl ?>" class="ava ava__female ava__small-xxs ava__middle-xs ava__middle-sm-mid "><span class="ico-status ico-status__online"></span><img alt="<?=$question->user->fullName ?>" src="<?=$question->user->avatarUrl ?>" class="ava_img"></a><a href="<?=$question->user->profileUrl ?>" class="b-article_author"><?=$question->user->fullName?></a>
                    <?=HHtml::timeTag($question, array('class' => 'tx-date'), null) ?>
                </div>
                <div class="icons-meta">
                    <div class="icons-meta_view"><span class="icons-meta_tx">305</span></div>
                </div>
            </div>
            <h1 class="b-article_t"><?=$question->title?></h1>
            <div class="b-article_in clearfix">
                <div class="wysiwyg-content clearfix">
                    <?=$question->text?>
                </div>
            </div>
        </div>
    </article>
    <!-- Статья с текстом-->
    <!-- b-article-->
    <?php if ($question->answer): ?>
    <article class="b-article b-article__single clearfix b-article__lite">
        <div class="b-consult-open">
            <div class="b-consult-open__answer">Ответ:</div>
            <div class="b-article_cont clearfix">
                <div class="b-article_header clearfix"><a href="#" class="b-consult-button small right">Задать вопрос</a>
                    <div class="float-l">
                        <a href="<?=$question->answer->user->profileUrl ?>" class="ava ava__female ava__small-xxs ava__middle-xs ava__middle-sm-mid "><span class="ico-status ico-status__online"></span><img alt="<?=$question->answer->user->fullName ?>" src="<?=$question->answer->user->avatarUrl ?>" class="ava_img"></a><a href="<?=$question->answer->user->profileUrl ?>" class="b-article_author"><?=$question->answer->user->fullName?></a>
                        <?=HHtml::timeTag($question->answer, array('class' => 'tx-date'), null) ?>
                    </div>
                </div>
                <div class="b-article_in clearfix">
                    <div class="wysiwyg-content clearfix">
                        <?=$question->answer->text?>
                    </div>
                </div>
            </div>
        </div>
    </article>
    <?php endif; ?>
</div>
<div class="b-main_col-sidebar visible-md">
    <div class="b-consult-specialist">
        <div class="b-consult-specialist__img"><img src="/lite/images/services/consult/consult-man.png" alt=""></div>
        <div class="b-consult-specialist__name">Морозов Сергей Леонидович</div>
        <div class="b-consult-specialist__position">Врач педиатр</div>
        <div class="b-consult-specialist__edu">

            Кандидат медицинских наук, <br />
            Научный сотрудник Научно-исследовательского <br />
            клинического института педиатрии <br />
            ГБОУ ВПО РНИМУ им. Н.И. Пирогова
        </div><a href="#" class="b-consult-button">Задать вопрос</a>
    </div>
    <?php
        $this->widget('site\frontend\modules\consultation\widgets\OtherQuestionsWidget', array(
            'question' => $question,
        ));
    ?>
</div>