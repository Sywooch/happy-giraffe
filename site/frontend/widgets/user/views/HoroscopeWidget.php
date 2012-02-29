<?php
/* @var $this Controller
 * @var $forecast Horoscope
 */
?>
<div class="user-horoscope">

    <div class="actions">
        <a href="" class="close"></a>
        <a href="" class="settings"></a>
    </div>

    <div class="clearfix">
        <div class="img"><img src="/images/user_horoscope_01.png"></div>
        <div class="date"><big><?php echo $forecast->zodiacText() ?></big>(<?php echo $forecast->zodiacDates() ?>)</div>
    </div>

    <p><b><?php echo Yii::app()->dateFormatter->format('d MMMM', time());  ?></b> <?php
        echo str_replace("\n", '</p><p>', $forecast->text) ?></p>

</div>