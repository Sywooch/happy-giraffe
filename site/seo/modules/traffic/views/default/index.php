<?php
/* @var $sections TrafficSection[]
 * @var $all_section TrafficSection
 */

$all_visits = $all_section->getVisitsCount($date, $last_date);
if ($all_visits != 0):
?>
<div class="seo-table">
    <?php $this->renderPartial('_date_form', compact('period', 'last_date', 'date')); ?>
    <div id="crumbs">
        <?php if ($all_section->id != 1) {
            echo CHtml::link('Все', $this->createUrl('index', compact('last_date', 'date'))).' > <span>'.$all_section->title.'</span>';
        } ?>
    </div>
    <div class="table-box table-statistic">
        <table>
            <thead>
            <tr>
                <th width="200"><span class="big">Раздел</span></th>
                <th><span class="big">Трафик</span></th>
                <th><span class="big">Процент от общего</span></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($sections as $section):?>
                <tr>
                    <td>
                    <?php if (empty($section->sections)):?>
                        <?=$section->title ?>
                    <?php else: ?>
                        <?php $parent_id = $section->id ?>
                        <?=CHtml::link($section->title, $this->createUrl('index', compact('last_date', 'date', 'parent_id'))) ?>
                    <?php endif ?>
                        <?=CHtml::link('link', $this->createUrl('section', array('id'=>$section->id))) ?>
                    </td>
                    <td><?=$value = $section->getVisitsCount($date, $last_date) ?></td>
                    <td><?=round(($value / $all_visits)*100, 1) ?> %</td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<style type="text/css">
    #crumbs {color:#51afc3;font:11px/18px tahoma, arial, sans-serif;position:relative;z-index:5;margin-bottom:15px;}
    #crumbs span {background:#fffedf;padding:0px 5px;display:inline-block;*zoom:1;*display:inline;color:#0a87bb;}
</style>