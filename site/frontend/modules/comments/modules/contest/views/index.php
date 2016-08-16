<?php
$this->pageTitle = $this->contest->name;
$cs = \Yii::app()->clientScript;
$cs->registerAMD('contestCommentsIndex', array('kow'));
$cs->registerAMD('contestCommentsButton', array('joinOrAuth' => 'extensions/joinOrAuth', 'ContestComments' => 'models/ContestComments'), 'joinOrAuth(".contest-commentator_btn-orange", ContestComments);');
?>

<?php if (!\Yii::app()->user->isGuest): ?>
    <?php $this->widget('site\frontend\modules\comments\modules\contest\widgets\MyStatWidget'); ?>
<?php endif; ?>
<div class="b-contest__block textalign-c">
    <div class="b-contest__title visible-md">Все просто как раз, два, три</div>
    <ul class="b-contest__list">
        <li class="b-contest__li">
            <div class="b-prize__ico-wrapper">
                <div class="b-prize__ico b-prize__ico_girl"></div>
            </div>
            <div class="b-prize__descr">Пиши комментарии на сайте и получай за них баллы</div>
        </li>
        <li class="b-contest__li">
            <div class="b-prize__ico-wrapper">
                <div class="b-prize__ico b-prize__ico_attachment"></div>
            </div><a href="https://play.google.com/store/apps/details?id=ru.happy_giraffe.blogger" class="b-prize__link-appstore"></a>
            <div class="b-prize__descr">Получай за комментарии в мобильном приложении в 2 раза больше баллов</div>
        </li>
        <li class="b-contest__li">
            <div class="b-prize__ico-wrapper">
                <div class="b-prize__ico b-prize__ico_all"></div>
            </div>
            <div class="b-prize__descr">Попади в 10-ку лучших комментаторов месяца и получи приз</div>
        </li>
    </ul>
    <?php if (\Yii::app()->user->isGuest): ?>
        <div class="textalign-c"><a href="#" class="btn btn-forum green-btn login-button" data-bind="follow: {}">Принять участие</a></div>
    <?php endif ?>
</div>
<div class="b-contest__block textalign-c bg-yellow">
    <div class="b-contest-container">
        <div class="b-contest__title">Приз августа</div>
        <div class="b-prize__contain b-prize__contain_bg"><img src="/lite/images/konkurs/ico-contest-prize.svg"></div>
        <div class="w-700 margin-auto font-m">
            <div class="b-contest__text-middle margin-b5">Набор «Каляка-Маляка»</div>
            <p>В набор входит: портфель, альбом для рисования (20 л.), раскраска пластилином, пластилин (12 цв.), магические фломастеры (10 шт.), акварельные карандаши (12 цв.), восковые карандаши (24 цв.)  трафареты для витражей.</p>
        </div>
    </div>
</div>
<div class="b-contest__block visible-md">
    <?php $this->widget('site\frontend\modules\comments\modules\contest\widgets\PulseWidget'); ?>
</div>
<div class="b-contest__block bg-blue">
    <?php $this->widget('site\frontend\modules\comments\modules\contest\widgets\LeadersWidget'); ?>
</div>
</div>