<?php
/**
 * @var \site\frontend\modules\specialists\modules\pediatrician\widgets\stats\MonthRow[] $months
 */
?>

<div class="statistik-container">
    <?php foreach ($months as $i => $month): ?>
    <div class="table-responsive">
        <table class="table statistic-table">
            <tbody><tr class="statistic-table--bg-white statistic-table--style statistik__text--grey-light statistic-table--title-font-small">
                <td class="statistic-table--title statistic-table--title-bold statistic-table--title-black statistic-table--title-font-big"><?=\Yii::app()->locale->getMonthName(ltrim($month->month, '0'), 'wide', true)?> <?=$month->year?></td>
                <?php for ($k = 1; $k <= count($month->days); $k++): ?>
                    <td><?=$k?></td>
                <?php endfor; ?>
            </tr>
            <tr class="statistic-table--bg-green statistic-table--style statistik__text--grey statistic-table--title-font-medium">
                <td class="statistic-table--title statistik__text--grey-lighten statistic-table--title-font-xl">Ответы</td>
                <?php $square = false; foreach ($month->days as $j => $day): if ($day['nAnswers'] > 0) $square = true; ?>
                    <?php if ($day['nAnswers'] == 0): ?>
                        <?php if (($month->year . '-' . $month->month . '-' . $j) > date('Y-m-d') || (! $square && ($i == count($months) - 1))): ?>
                            <td><span class="statistic-table--color-ccc">•</span></td>
                        <?php else: ?>
                            <td><span class="statistic-table__square statistic-table__square--green"></span></td>
                        <?php endif; ?>
                    <?php else: ?>
                        <td><?=$day['nAnswers']?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!--<td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table__square statistic-table__square--green"></span></td>
                <td><span class="statistic-table__square statistic-table__square--green"></span></td>
                <td><span class="statistic-table__square statistic-table__square--green"></span></td>
                <td>2</td>
                <td>43</td>
                <td>34</td>
                <td>17</td>
                <td>18</td>
                <td>19</td>
                <td>20</td>
                <td>21</td>
                <td>22</td>
                <td>23</td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>-->
            </tr>
            <tr class="statistic-table--bg-red statistic-table--style statistik__text--grey statistic-table--title-font-medium">
                <td class="statistic-table--title statistik__text--grey-lighten statistic-table--title-font-xl">Спасибо</td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table__square statistic-table__square--red"></span></td>
                <td><span class="statistic-table__square statistic-table__square--red"></span></td>
                <td><span class="statistic-table__square statistic-table__square--red"></span></td>
                <td>
                    <div class="statistic-table__senks"><span class="statistic-table__roze"></span><span class="statistic-table__num">12</span></div>
                </td>
                <td>
                    <div class="statistic-table__senks"><span class="statistic-table__roze"></span><span class="statistic-table__num">12</span></div>
                </td>
                <td>
                    <div class="statistic-table__senks"><span class="statistic-table__roze"></span><span class="statistic-table__num">12</span></div>
                </td>
                <td>
                    <div class="statistic-table__senks"><span class="statistic-table__roze"></span><span class="statistic-table__num">12</span></div>
                </td>
                <td>
                    <div class="statistic-table__senks"><span class="statistic-table__roze"></span><span class="statistic-table__num">99</span></div>
                </td>
                <td>
                    <div class="statistic-table__senks"><span class="statistic-table__roze"></span><span class="statistic-table__num">8</span></div>
                </td>
                <td>
                    <div class="statistic-table__senks"><span class="statistic-table__roze"></span><span class="statistic-table__num">8</span></div>
                </td>
                <td>
                    <div class="statistic-table__senks"><span class="statistic-table__roze"></span><span class="statistic-table__num">8</span></div>
                </td>
                <td>
                    <div class="statistic-table__senks"><span class="statistic-table__roze"></span><span class="statistic-table__num">8</span></div>
                </td>
                <td>
                    <div class="statistic-table__senks"><span class="statistic-table__roze"></span><span class="statistic-table__num">8</span></div>
                </td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
                <td><span class="statistic-table--color-ccc">•</span></td>
            </tr>
            </tbody></table>
    </div>
    <?php endforeach; ?>
</div>