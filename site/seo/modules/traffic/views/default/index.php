<?php

$sections = TrafficSection::model()->findAll();
$all_traffic = GApi::getUrlOrganicSearches($date, $last_date, '/');
?>
<div class="seo-table">
    <?php $this->renderPartial('_date_form', compact('period', 'last_date', 'date')); ?>
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
                    <td><?=$section->title ?></td>
                    <td><?=$value = GApi::getUrlOrganicSearches($date, $last_date, '/' . $section->url) ?></td>
                    <td><?=round(($value / $all_traffic)*100) ?> %</td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
