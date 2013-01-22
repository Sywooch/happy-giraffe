<?php
/* @var $section TrafficSection
 */

$all = TrafficSection::model()->findByPk(1);
?>
<div class="seo-table">
    <?php $this->renderPartial('_date_form', compact('period', 'last_date', 'date')); ?>
    <div id="crumbs">
        <?= CHtml::link('Все', $this->createUrl('index', compact('last_date', 'date'))).' > <span>'.$section->title.'</span>'; ?>
    </div>
    <div class="table-box table-statistic">
        <table>
            <thead>
            <tr>
                <th width="200"><span class="big">Дата</span></th>
                <th><span class="big">Трафик</span></th>
                <th><span class="big">Процент от общего</span></th>
            </tr>
            </thead>
            <tbody>
            <?php for($i=0;$i<10;$i++):?>
            <?php $date = date("Y-m-d", strtotime('- '.$i.' days'))  ?>
            <tr>
                <td><?=Yii::app()->dateFormatter->format('d MMM',strtotime($date))?></td>
                <td><?=$value = $section->getVisitsCount($date, $date) ?></td>
                <td><?=round(100*($value / ($all->getVisitsCount($date, $date) + 0.01)), 1) ?> %</td>
            </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </div>
</div>

<style type="text/css">
    #crumbs {color:#51afc3;font:11px/18px tahoma, arial, sans-serif;position:relative;z-index:5;margin-bottom:15px;}
    #crumbs span {background:#fffedf;padding:0px 5px;display:inline-block;*zoom:1;*display:inline;color:#0a87bb;}
</style>