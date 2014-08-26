<?php
$this->pageTitle = $this->getText('title');
$this->breadcrumbs = array($this->getText('title'));
?>
<div class="b-main_cont">
    <div class="b-main_col-wide">   
        <h1 class="heading-link-xxl heading-link-xxl__center"><?= $this->getText('title') ?></h1>
    </div>
</div>
<?php
$this->beginClip('description_pregnacy');
?>
<div class="b-main_row b-main_row__blue-light">
    <div class="b-main_cont">
        <div class="b-main_col-wide tx-content">
            <p class="a-span">Наш календарь является отличным инструментом, который позволяет отслеживать вашу беременность шаг за шагом, неделя за неделей. С помощью его вы узнаете, когда сможете почувствовать первый удар вашего малыша, а когда увидеть его на первом снимке в кабинете УЗИ. Вы будете поражены, узнав насколько удивительно это путешествие в 40 недель – от нескольких клеток до полностью сформированного маленького человечка.</p>
        </div>
    </div>
</div>
<?php
$this->endClip();
$this->beginClip('description_child');
?>
<div class="b-main_row b-main_row__brown-light">
    <div class="b-main_cont">
        <div class="b-main_col-wide tx-content">
            <p class="color-brown">Этот календарь даст вам представление о развитии вашего ребенка, начиная с момента его рождения до окончания школы. Вот он впервые приподнял свою маленькую головку, а теперь улыбнулся вам в ответ, произнес первое слово, вот уже побежал, а вот и 1 класс… Наш календарь организован такими периодами, чтобы дать вам практические и полезные рекомендации в самые необходимые моменты.</p>
        </div>
    </div>
</div>
<?php
$this->endClip();

$this->renderClip($this->calendar == 0 ? 'description_child' : 'description_pregnacy');

$this->renderPartial($this->getText('menu'), compact('periods'));

$this->beginClip('club_pregnacy');
?>
<div class="b-main_cont">
    <div class="conv-pregnancy visible-md-block">
        <div class="conv-pregnancy_hold">
            <div class="conv-pregnancy_tx">Здесь вы можете узнать тысячи советов по беременности, и услышать реальные истории других будущих мам. Вы не одиноки. </div><a href="#registerWidget" class="btn btn-success btn-xl" onclick="$('a[href=\'#registerWidget\']:eq(0)').click(); return false;">Присоединяйтесь!</a>
        </div>
    </div>
</div>
<?php
$this->endClip();
$this->beginClip('club_child');
?>
<div class="b-main_cont">
    <div class="conv-pregnancy conv-pregnancy__baby visible-md-block">
        <div class="conv-pregnancy_hold">
            <div class="conv-pregnancy_tx">Вы можете получить тысячи советов от других родителей. Вы не одиноки.</div><a href="#registerWidget" class="btn btn-success btn-xl" onclick="$('a[href=\'#registerWidget\']:eq(0)').click(); return false;">Присоединяйтесь!</a>
        </div>
    </div>
</div>
<?php
$this->endClip();

if(Yii::app()->user->isGuest)
    $this->renderClip($this->calendar == 0 ? 'club_child' : 'club_pregnacy');
?>