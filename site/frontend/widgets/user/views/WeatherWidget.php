<div class="user-weather">

    <div class="location">
        <?php echo $this->user->getFlag() ?><?php echo $this->user->country->name ?><br/>
        <big><?php echo $this->user->settlement->name ?></big>
    </div>

    <div class="clearfix" id="today-weather">

        <div class="img"><img src="/images/user_weather_01.png"/></div>

        <div class="text">
            <big><?php echo $now_temp ?></big>

            <div class="row hl"><span>Ночью</span><?php echo $night ?></div>
            <div class="row"><span>Завтра</span><?php echo $yesterday ?></div>
        </div>

    </div>

    <a href="#" id="forecast-link">Прогноз на неделю</a>
    <div id="forecast" style="display: none;">
        <table>
            <thead>
            <tr>
                <?php $days = HDate::getDaysList(4); ?>
                <?php foreach ($days as $day): ?>
                    <td><?php echo $day ?></td>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php foreach ($data as $day) :?>
                <td><img title="<?php echo $day['condition_title'] ?>" src="/images/widget/weather/small/<?php echo $day['condition'] ?>.png"></td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($data as $day) :?>
                <td><?php echo $day['high'] ?></td>
                <?php endforeach; ?>
            </tr>
            <tr class="hl">
                <?php foreach ($data as $day) :?>
                <td><?php echo $day['low'] ?></td>
                <?php endforeach; ?>
            </tr>
            </tbody>
        </table>
    </div>

    <a href="#" id="today-link" style="display: none;">Прогноз на неделю</a>

</div><?php
Yii::app()->clientScript->registerScript('WeatherWidget',
    "$('#forecast-link').click(function(){
        $(this).hide();
        $(this).prev().hide();
        $(this).next().show()
        $(this).next().next().show()
        return false;
    });

    $('#today-link').click(function(){
        $(this).hide();
        $(this).prev().hide();
        $(this).prev().prev().show()
        $(this).prev().prev().prev().show()
        return false;
    });");
?>