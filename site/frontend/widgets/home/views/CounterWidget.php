<?php
Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.lwtCountdown-1.0.js');
?>
<div class="homepage_row">
    <div class="homepage-counter">
        <div class="homepage_title"> Нас посетило уже! </div>
        <div id="counter-users" class="counter-users">
            <div class="counter-users_dash counter-users_dash__millions">
                <div class="counter-users_digit">0</div>
                <div class="counter-users_digit">0</div>
            </div>
            <div class="counter-users_dash counter-users_dash__thousands">
                <div class="counter-users_digit">0</div>
                <div class="counter-users_digit">0</div>
                <div class="counter-users_digit">0</div>
            </div>
            <div class="counter-users_dash counter-users_dash__hundreds">
                <div class="counter-users_digit">0</div>
                <div class="counter-users_digit">0</div>
                <div class="counter-users_digit">0</div>
            </div>
        </div>
        <div class="homepage_desc-tx">будущих и настоящих мам и пап</div><a href="#registerWidget" class="homepage_btn-sign btn btn-success btn-xxl popup-a">Присоединяйся!</a>
    </div>
</div>
<script type="text/javascript">
    var _0xb000 = ["\x63\x6F\x75\x6E\x74\x55\x70", "\x23\x63\x6F\x75\x6E\x74\x65\x72\x2D\x75\x73\x65\x72\x73", "\x72\x65\x61\x64\x79"];
    jQuery(document)[_0xb000[2]](function() {
        $(_0xb000[1])[_0xb000[0]]({numberSet:<?= $visitors ?>, randomNumberMin:<?= $inc_min ?>, randomNumberMax:<?= $inc_max ?>});
    });
</script>
