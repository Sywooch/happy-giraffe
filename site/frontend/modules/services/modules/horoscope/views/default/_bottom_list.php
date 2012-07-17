<?php if (Yii::app()->user->isGuest):?>
    <div class="banner-box">
        <a href="#register" class="fancy" data-theme="white-square"><img src="/images/banner_08.png"></a>
    </div>

<?php endif ?><?php $type = $model->getType() ?>
<div class="horoscope-fast-list clearfix">

    <div class="title">Все знаки зодиака</div>

    <ul>
        <li><a href="<?=$this->createUrl($type, array('zodiac'=>'aries')) ?>"><img src="/images/widget/horoscope/small/1.png"><br><span>Овен</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl($type, array('zodiac'=>'taurus')) ?>"><img src="/images/widget/horoscope/small/2.png"><br><span>Телец</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl($type, array('zodiac'=>'gemini')) ?>"><img src="/images/widget/horoscope/small/3.png"><br><span>Близнецы</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl($type, array('zodiac'=>'cancer')) ?>"><img src="/images/widget/horoscope/small/4.png"><br><span>Рак</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl($type, array('zodiac'=>'leo')) ?>"><img src="/images/widget/horoscope/small/5.png"><br><span>Лев</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl($type, array('zodiac'=>'virgo')) ?>"><img src="/images/widget/horoscope/small/6.png"><br><span>Дева</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl($type, array('zodiac'=>'libra')) ?>"><img src="/images/widget/horoscope/small/7.png"><br><span>Весы</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl($type, array('zodiac'=>'scorpio')) ?>"><img src="/images/widget/horoscope/small/8.png"><br><span>Скорпион</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl($type, array('zodiac'=>'sagittarius')) ?>"><img src="/images/widget/horoscope/small/9.png"><br><span>Стрелец</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl($type, array('zodiac'=>'capricorn')) ?>"><img src="/images/widget/horoscope/small/10.png"><br><span>Козерог</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl($type, array('zodiac'=>'aquarius')) ?>"><img src="/images/widget/horoscope/small/11.png"><br><span>Водолей</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl($type, array('zodiac'=>'pisces')) ?>"><img src="/images/widget/horoscope/small/12.png"><br><span>Рыбы</span><br>22.01 - 3.02</a></li>
    </ul>

</div>