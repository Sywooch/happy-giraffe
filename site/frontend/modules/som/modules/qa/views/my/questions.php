<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\MyController $this
 * @var \CActiveDataProvider $dp
 */
$this->sidebar = array('ask', 'my_questions', 'my_rating');
$this->pageTitle = 'Мои ответы';
?>
<?php
$this->widget('LiteListView', array(
    'dataProvider' => $dp,
    'itemView' => '/_question',
    'htmlOptions' => array(
        'class' => 'questions'
    ),
    'itemsTagName' => 'ul',
    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
    'pager' => array(
        'class' => 'LitePager',
        'maxButtonCount' => 10,
        'prevPageLabel' => '&nbsp;',
        'nextPageLabel' => '&nbsp;',
        'showPrevNext' => true,
    ),
));
?>

<?php if (false): ?>
<ul class="questions">
    <li class="questions_item">
        <div class="live-user">
            <!-- ava--><span href="#" class="ava ava__small ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span>
            <div class="username"><a>Валерия Остапенко</a><span class="tx-date">минуту назад</span></div>
        </div>
        <div class="icons-meta">
            <div href="#" class="icons-meta_view"><span class="icons-meta_tx">3685</span></div>
        </div><a class="questions_item_heading">Название архитектуры семейства графических процессоров AMD серии rx 200 выбрано по аналогии с каким названием?</a>
        <div class="questions_item_category">
            <div class="questions_item_category_ico sharp-test"></div><a class="questions_item_category_link">Беременность и роды</a>
        </div><a class="questions_item_answers"><span class="questions_item_answers_ans">ответить</span></a>
    </li>
    <li class="questions_item">
        <div class="live-user">
            <!-- ava--><span href="#" class="ava ava__small ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span>
            <div class="username"><a>Клара Демина</a><span class="tx-date">минуту назад</span></div>
        </div>
        <div class="icons-meta">
            <div href="#" class="icons-meta_view"><span class="icons-meta_tx">3685</span></div>
        </div><a class="questions_item_heading">Какие знания нужны для работы в фмс?</a>
        <div class="questions_item_category">
            <div class="questions_item_category_ico sharp-test"></div><a class="questions_item_category_link">Выходные с семьей</a>
        </div><a class="questions_item_answers"><span class="questions_item_answers_text">9 ответов</span></a>
    </li>
    <li class="questions_item">
        <div class="live-user">
            <!-- ava--><span href="#" class="ava ava__small ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span>
            <div class="username"><a>Клара Демина</a><span class="tx-date">Сегодня 11:51</span></div>
        </div>
        <div class="icons-meta">
            <div href="#" class="icons-meta_view"><span class="icons-meta_tx">3685</span></div>
        </div><a class="questions_item_heading">Вы уверенны - что помидоры в салате забигаловок аликов и самвелчиков для ввассей моют ваащще?</a>
        <div class="questions_item_category">
            <div class="questions_item_category_ico sharp-test"></div><a class="questions_item_category_link">Выходные с семьей</a>
        </div><a class="questions_item_answers"><span class="questions_item_answers_text">9 ответов</span></a>
    </li>
    <li class="questions_item">
        <div class="live-user">
            <!-- ava--><span href="#" class="ava ava__small ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span>
            <div class="username"><a>Клара Демина</a><span class="tx-date">Сегодня 11:51</span></div>
        </div>
        <div class="icons-meta">
            <div href="#" class="icons-meta_view"><span class="icons-meta_tx">3685</span></div>
        </div><a class="questions_item_heading">Какие знания нужны для работы в фмс?</a>
        <div class="questions_item_category">
            <div class="questions_item_category_ico sharp-test"></div><a class="questions_item_category_link">Выходные с семьей</a>
        </div><a class="questions_item_answers"><span class="questions_item_answers_ans">ответить</span></a>
    </li>
    <li class="questions_item">
        <div class="live-user">
            <!-- ava--><span href="#" class="ava ava__small ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span>
            <div class="username"><a>Валерия Остапенко</a><span class="tx-date">минуту назад</span></div>
        </div>
        <div class="icons-meta">
            <div href="#" class="icons-meta_view"><span class="icons-meta_tx">3685</span></div>
        </div><a class="questions_item_heading">Название архитектуры семейства графических процессоров AMD серии rx 200 выбрано по аналогии с каким названием?</a>
        <div class="questions_item_category">
            <div class="questions_item_category_ico sharp-test"></div><a class="questions_item_category_link">Беременность и роды</a>
        </div><a class="questions_item_answers"><span class="questions_item_answers_text">9 ответов</span></a>
    </li>
    <div class="questions_pagination">
        <!-- paginator-->
        <div class="yiipagination">
            <div class="pager">
                <ul class="yiiPager">
                    <li class="page"><a href="">1</a></li>
                    <li class="page"><a href="">2</a></li>
                    <li class="page"><a href="">5</a></li>
                    <li class="page"><a href="">6</a></li>
                    <li class="page selected"><a href="">7</a></li>
                    <li class="page"><a href="">8</a></li>
                    <li class="page"><a href="">9</a></li>
                    <li class="page"><a href="">10</a></li>
                    <li class="page hidden"><a href="">11</a></li>
                </ul>
            </div>
        </div>
        <!-- /paginator-->
    </div>
</ul>
<?php endif; ?>