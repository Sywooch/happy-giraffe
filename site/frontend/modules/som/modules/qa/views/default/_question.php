<?php
/**
 * @var \site\frontend\modules\som\modules\qa\models\QaQuestion $data
 */
?>

<li class="questions_item">
    <div class="live-user">
        <!-- ava--><span href="#" class="ava ava__small ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span>
        <div class="username"><a>Валерия Остапенко</a><span class="tx-date">минуту назад</span></div>
    </div>
    <div class="icons-meta">
        <div href="#" class="icons-meta_view"><span class="icons-meta_tx">3685</span></div>
    </div>
    <div class="clearfix"></div><a class="questions_item_heading"><?=$data->title?></a>
    <div class="questions_item_category">
        <div class="questions_item_category_ico sharp-test"></div><a class="questions_item_category_link"><?=$data->category->title?></a>
    </div>
    <?php if ($data->answersCount == 0): ?>
        <a class="questions_item_answers"><span class="questions_item_answers_ans">ответить</span></a>
    <?php else: ?>
        <a class="questions_item_answers"><span class="questions_item_answers_text"><?=$data->answersCount?> ответов</span></a>
    <?php endif; ?>
    <div class="clearfix"></div>
</li>