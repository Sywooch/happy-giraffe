<?php $type = $model->getType() ?>
<div class="horoscope-fast-list">

    <div class="title">Все знаки зодиака</div>

    <ul>
        <li><a href="<?=$this->createUrl('/horoscope/default/'.$type, array('zodiac'=>'Овен')) ?>"><img src="/images/widget/horoscope/small/1.png"><br><span>Овен</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl('/horoscope/default/'.$type, array('zodiac'=>'Телец')) ?>"><img src="/images/widget/horoscope/small/2.png"><br><span>Телец</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl('/horoscope/default/'.$type, array('zodiac'=>'Близнецы')) ?>"><img src="/images/widget/horoscope/small/3.png"><br><span>Близнецы</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl('/horoscope/default/'.$type, array('zodiac'=>'Рак')) ?>"><img src="/images/widget/horoscope/small/4.png"><br><span>Рак</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl('/horoscope/default/'.$type, array('zodiac'=>'Лев')) ?>"><img src="/images/widget/horoscope/small/5.png"><br><span>Лев</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl('/horoscope/default/'.$type, array('zodiac'=>'Дева')) ?>"><img src="/images/widget/horoscope/small/6.png"><br><span>Дева</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl('/horoscope/default/'.$type, array('zodiac'=>'Весы')) ?>"><img src="/images/widget/horoscope/small/7.png"><br><span>Весы</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl('/horoscope/default/'.$type, array('zodiac'=>'Скорпион')) ?>"><img src="/images/widget/horoscope/small/8.png"><br><span>Скорпион</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl('/horoscope/default/'.$type, array('zodiac'=>'Стрелец')) ?>"><img src="/images/widget/horoscope/small/9.png"><br><span>Стрелец</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl('/horoscope/default/'.$type, array('zodiac'=>'Козерог')) ?>"><img src="/images/widget/horoscope/small/10.png"><br><span>Козерог</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl('/horoscope/default/'.$type, array('zodiac'=>'Водолей')) ?>"><img src="/images/widget/horoscope/small/11.png"><br><span>Водолей</span><br>22.01 - 3.02</a></li>
        <li><a href="<?=$this->createUrl('/horoscope/default/'.$type, array('zodiac'=>'Рыбы')) ?>"><img src="/images/widget/horoscope/small/12.png"><br><span>Рыбы</span><br>22.01 - 3.02</a></li>
    </ul>

</div>