<div class="user-weather">
    <div id="today-weather">

        <div class="box-title"><a href="" id="forecast-link" class="a-right pseudo">Еще на три дня</a>Моя погода</div>

        <div class="clearfix">

            <div class="img">
                <img title="<?= $now_condition['condition_title'] ?>"
                                  src="/images/widget/weather/big/<?=$now_condition['condition'] ?>.png">
            </div>

            <div class="text">
                <big><?= $now_temp ?></big>

                <div class="row hl"><span>Ночью</span><?=$night ?></div>
                <div class="row"><span>Завтра</span><?=$yesterday ?></div>
            </div>

        </div>

    </div>

    <div id="forecast" style="display: none;">

        <div class="box-title"><a id="today-link" href="" class="a-right pseudo">Погода сейчас</a>Моя погода</div>

        <table>
            <thead>
            <tr>
                <?php $days = HDate::getDaysList(3); ?>
                <?php foreach ($days as $day): ?>
                <td><?php echo $day ?></td>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php foreach ($data as $day) : ?>
                <td><img title="<?php echo $day['condition_title'] ?>"
                         src="/images/widget/weather/small/<?php echo $day['condition'] ?>.png"></td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($data as $day) : ?>
                <td><?php echo $day['high'] ?></td>
                <?php endforeach; ?>
            </tr>
            <tr class="hl">
                <?php foreach ($data as $day) : ?>
                <td><?php echo $day['low'] ?></td>
                <?php endforeach; ?>
            </tr>
            </tbody>
        </table>

    </div>
</div>