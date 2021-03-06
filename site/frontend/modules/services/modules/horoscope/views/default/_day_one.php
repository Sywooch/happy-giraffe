<?php
if (!$this->alias)
{
    $prev = Horoscope::model()->exists('`date` = date_add(:d, Interval -1 DAY) AND `zodiac` = :z', array('z' => $model->zodiac, 'd' => $model->date)) ? strtotime('-1 day', $this->date) : false;
    $next = Horoscope::model()->exists('`date` = date_add(:d, Interval  1 DAY) AND `zodiac` = :z', array('z' => $model->zodiac, 'd' => $model->date)) ? strtotime('+1 day', $this->date) : false;
    ?>
    <table class="article-nearby clearfix">
        <tbody>
            <tr>
                <td><?php
                    if ($prev)
                    {
                        ?><a class="article-nearby_a article-nearby_a__l" href="<?= $this->getUrl(array('date' => $prev)) ?>"><span class="article-nearby_tx"><?= HDate::date('j F Y', $prev) ?></span></a><?php } ?></td>
                <td><?php
                    if ($next)
                    {
                        ?><a class="article-nearby_a article-nearby_a__r" href="<?= $this->getUrl(array('date' => $next)) ?>"><span class="article-nearby_tx"><?= HDate::date('j F Y', $next) ?></span></a><?php } ?></td>
            </tr>
        </tbody>
    </table>
    <?php
}
?>
<div class="horoscope-day">
    <div class="ico-zodiac ico-zodiac__xl">
        <div class="ico-zodiac_in ico-zodiac__<?= $model->zodiac ?>"></div>
    </div>
    <div class="horoscope-day_tx"><?= $model->zodiacText() ?></div>
</div>
<div class="wysiwyg-content clearfix">
    <?php
    if ($this->alias)
        echo CHtml::tag('noindex', array(), Str::strToParagraph($model->text));
    else
        echo Str::strToParagraph($model->text);
    ?>
</div>
