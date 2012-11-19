<div class="contest-prizes-list contest-prizes-list-4 clearfix">

    <ul>
        <li>
            <div class="img">
                <a href="<?=$this->createUrl('/contest/default/prizes', array('id' => $this->contest->id, '#' => 'prize-1'))?>"><img src="/images/prize_10.jpg" /></a>
            </div>
            <div class="place place-1-1"></div>
            <div class="title">
                <a href="<?=$this->createUrl('/contest/default/prizes', array('id' => $this->contest->id, '#' => 'prize-1'))?>">Детский надувной бассейн<br/><b>Intex «Easy Set»</b></a>
            </div>
            <?=CHtml::link('Подробнее', array('/contest/default/prizes', 'id' => $this->contest->id, '#' => 'prize-1'), array('class' => 'all'))?>
        </li>
        <li>
            <div class="img">
                <a href="<?=$this->createUrl('/contest/default/prizes', array('id' => $this->contest->id, '#' => 'prize-2'))?>"><img src="/images/prize_11.jpg" /></a>
            </div>
            <div class="place place-2"></div>
            <div class="title">
                <a href="<?=$this->createUrl('/contest/default/prizes', array('id' => $this->contest->id, '#' => 'prize-2'))?>">Детский надувной бассейн<br/><b>Intex «Easy Setk»</b></a>
            </div>
            <?=CHtml::link('Подробнее', array('/contest/default/prizes', 'id' => $this->contest->id, '#' => 'prize-2'), array('class' => 'all'))?>
        </li>
        <li>
            <div class="img">
                <a href="<?=$this->createUrl('/contest/default/prizes', array('id' => $this->contest->id, '#' => 'prize-3'))?>"><img src="/images/prize_12.jpg" /></a>
            </div>
            <div class="place place-3"></div>
            <div class="title">
                <a href="<?=$this->createUrl('/contest/default/prizes', array('id' => $this->contest->id, '#' => 'prize-3'))?>">Детский надувной бассейн<br/><b>Intex «Жираф»</b></a>
            </div>
            <?=CHtml::link('Подробнее', array('/contest/default/prizes', 'id' => $this->contest->id, '#' => 'prize-3'), array('class' => 'all'))?>
        </li>
        <li>
            <div class="img">
                <a href="<?=$this->createUrl('/contest/default/prizes', array('id' => $this->contest->id, '#' => 'prize-4'))?>"><img src="/images/prize_13.jpg" /></a>
            </div>
            <div class="place place-4-5"></div>
            <div class="title">
                <a href="<?=$this->createUrl('/contest/default/prizes', array('id' => $this->contest->id, '#' => 'prize-4'))?>">Термометр для воды и воздуха<br/><b>Avent Philips SCH 550</b></a>
            </div>
            <?=CHtml::link('Подробнее', array('/contest/default/prizes', 'id' => $this->contest->id, '#' => 'prize-4'), array('class' => 'all'))?>
        </li>

    </ul>

</div>