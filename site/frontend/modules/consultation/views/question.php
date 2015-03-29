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
    <article class="b-article b-article__single clearfix b-article__lite">
        <div class="b-consult-open">
            <div class="b-consult-open__answer">Ответ:</div>
            <div class="b-article_cont clearfix">
                <div class="b-article_header clearfix"><a href="#" class="b-consult-button small right">Задать вопрос</a>
                    <div class="float-l">
                        <!-- ava--><a href="#" class="ava ava__female ava__small-xxs ava__middle-xs ava__middle-sm-mid "><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="#" class="b-article_author">Сергей Леонидович</a>
                        <time pubdate="1957-10-04" class="tx-date">Сегодня 13:25</time>
                    </div>
                </div>
                <div class="b-article_in clearfix">
                    <div class="wysiwyg-content clearfix">
                        <p>Главное - не надо паники. Постарайтесь успокоится, иначе молоко пропадет. В норме бывают колебания количества молока, но чаще мама неправильно интерпретирует поведение ребенка. Ребенок может плакать по большому числу проблем: есть хочет, пить хочет, животик болит, грязный, мокрый, замерз, перегрелся, ему неудобно или просто хочет общения с мамой… Но мама, почему то, думает, что если ребенок плачет, то есть хочет и все. Так что, скорее всего просто у вашего ребенка что-то не так, но он не обязательно голодный, может у него животик болит. Если вы уверены, что это точно недокорм, то чтобы быть уверенным, что молока хватает, сделайте контрольное взвешивание до и после кормления и определите, сколько ребенок съедает.</p>
                    </div>
                </div>
            </div>
        </div>
    </article>
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
    <div class="b-consult-aside">
        <div class="b-consult-aside__title">Другие вопросы <a href="#" class="b-consult-aside__title__all">Все вопросы 828 </a></div>
        <div class="b-consult-aside-item"><a href="#" class="b-consult-aside-item__ava"><img src="/lite/images/services/consult/consult-small.png" alt=""></a><a href="#" class="b-article_author">Ангелина Богоявленская</a>
            <time pubdate="1957-10-04" class="tx-date">Сегодня 13:25</time>
            <div class="b-consult-aside-item__message">
                <div class="b-consult-qa-ms__message__title">Молочная жидкость</div>Здравствуйте.Дочери 10 недель и 6 дней. Не знаю с чего даже начать-дня 4 назад начались проблемы с молоком. Малышка...
            </div>
        </div>
        <div class="b-consult-aside-item"><a href="#" class="b-consult-aside-item__ava"><img src="/lite/images/services/consult/consult-small.png" alt=""></a><a href="#" class="b-article_author">Ангелина Богоявленская</a>
            <time pubdate="1957-10-04" class="tx-date">Сегодня 13:25</time>
            <div class="b-consult-aside-item__message">
                <div class="b-consult-qa-ms__message__title">Молочная жидкость</div>Здравствуйте.Дочери 10 недель и 6 дней. Не знаю с чего даже начать-дня 4 назад начались проблемы с молоком. Малышка...
            </div>
        </div>
        <div class="b-consult-aside-item"><a href="#" class="b-consult-aside-item__ava"><img src="/lite/images/services/consult/consult-small.png" alt=""></a><a href="#" class="b-article_author">Ангелина Богоявленская</a>
            <time pubdate="1957-10-04" class="tx-date">Сегодня 13:25</time>
            <div class="b-consult-aside-item__message">
                <div class="b-consult-qa-ms__message__title">Молочная жидкость</div>Здравствуйте.Дочери 10 недель и 6 дней. Не знаю с чего даже начать-дня 4 назад начались проблемы с молоком. Малышка...
            </div>
        </div>
        <div class="b-consult-aside-item"><a href="#" class="b-consult-aside-item__ava"><img src="/lite/images/services/consult/consult-small.png" alt=""></a><a href="#" class="b-article_author">Ангелина Богоявленская</a>
            <time pubdate="1957-10-04" class="tx-date">Сегодня 13:25</time>
            <div class="b-consult-aside-item__message">
                <div class="b-consult-qa-ms__message__title">Молочная жидкость</div>Здравствуйте.Дочери 10 недель и 6 дней. Не знаю с чего даже начать-дня 4 назад начались проблемы с молоком. Малышка...
            </div>
        </div>
        <div class="b-consult-aside-item"><a href="#" class="b-consult-aside-item__ava"><img src="/lite/images/services/consult/consult-small.png" alt=""></a><a href="#" class="b-article_author">Ангелина Богоявленская</a>
            <time pubdate="1957-10-04" class="tx-date">Сегодня 13:25</time>
            <div class="b-consult-aside-item__message">
                <div class="b-consult-qa-ms__message__title">Молочная жидкость</div>Здравствуйте.Дочери 10 недель и 6 дней. Не знаю с чего даже начать-дня 4 назад начались проблемы с молоком. Малышка...
            </div>
        </div>
    </div>
</div>