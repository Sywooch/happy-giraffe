<?php
Yii::app()->clientScript->registerScriptFile('\javascripts\jquery.lwtCountdown-1.0.js');

?><div class="start-page_row start-page_row__counter">
    <div class="start-page_hold">
        <div class="start-page_counter">
            <div class="start-page_counter-desc">
                Нас посетило уже
            </div>

            <!-- Countdown dashboard start -->
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
            <!-- Countdown dashboard end -->
            <div class="start-page_counter-desc">
                мам и пап!
            </div>

        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">
    jQuery(document).ready(function() {
        $('#counter-users').countUp({
            numberSet : <?=$visitors ?>,
            randomNumberMin : <?=$inc_min ?>,
            randomNumberMax : <?=$inc_max ?>
        });

    });
</script>
