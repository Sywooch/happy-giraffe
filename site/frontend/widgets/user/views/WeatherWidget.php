<div class="user-weather">

    <div class="location">
        <?php echo $this->user->getFlag() ?>
        <?php echo $this->user->country->name ?><br/>
        <big><?php echo $this->user->settlement->name ?></big>
    </div>

    <div class="clearfix">

        <div class="img"><img src="/images/user_weather_01.png"/></div>

        <div class="text">
            <big><?php echo $now_temp ?></big>

            <div class="row hl"><span>Ночью</span><?php echo $night ?></div>
            <div class="row"><span>Завтра</span><?php echo $yesterday ?></div>
        </div>

    </div>

    <a href="">Прогноз на неделю</a>

</div>