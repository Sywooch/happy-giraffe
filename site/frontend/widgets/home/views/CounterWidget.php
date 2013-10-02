<?php
Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.lwtCountdown-1.0.js');

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
    eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('4(3).2(0(){$(\'#1-5\').6({b:a,9:7,8:c})});',13,13,'function|counter|ready|document|jQuery|users|countUp|<?=$inc_min?>|randomNumberMax|randomNumberMin|<?=$visitors?>|numberSet|<?=$inc_max?>'.split('|'),0,{}))
</script>
