<?php
/**
 * @var Horoscope $horoscope
 * @var User $user
 */
?><div id="horoscope">

    <div class="horoscope-one horoscope-one__conversion">

        <div class="block-in">
            <div class="heading-title clearfix">Ваш гороскоп на сегодня</div>
            <div class="img">

                <div class="in"><img src="/images/widget/horoscope/big/<?=$horoscope->zodiac ?>.png"></div>
                <div class="date"><span><?=$horoscope->zodiacText() ?></span><?=$horoscope->zodiacDates() ?></div>

            </div>

            <div class="text clearfix">
                <div class="date">
                    <span><?=date("j", strtotime($horoscope->date)) ?></span><?=HDate::ruMonthShort(date("n", strtotime($horoscope->date)))?>
                </div>
                <div class="holder">
                    <?=Str::strToParagraph($horoscope->text) ?>
                </div>

            </div>

            <?php $this->render('application.modules.services.modules.horoscope.views.default.likes_simple', array('model' => $horoscope)); ?>

            <div class="margin-20 clearfix">
                <a href="javascript:;" class="float-r a-pseudo-white margin-t18" onclick="HoroscopeUnSubscribe();">Не хочу получать гороскоп на Мой Жираф</a>
                <div class="float-l color-white">
                    Каждое утро вас ждет <br> новый гороскоп на Веселом Жирафе!
                </div>
            </div>

        </div>

    </div>
</div>
<script type="text/javascript">
    var HoroscopeUnSubscribe = function () {
        $.post('/my/unsubscribe/', function (response) {
            if (response.success)
                $('#horoscope').remove();
        }, 'json');
    }
</script>