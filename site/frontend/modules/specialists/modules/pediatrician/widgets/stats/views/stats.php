<?php
/**
 * @var \site\frontend\modules\specialists\modules\pediatrician\widgets\stats\StatsWidget $this
 * @var \site\frontend\modules\specialists\modules\pediatrician\widgets\stats\MonthRow[] $months
 */
?>

<?php $this->widget('site\frontend\modules\specialists\modules\pediatrician\widgets\summary\SummaryWidget', [
    'userId' => $this->userId,
]); ?>

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
                <?php foreach ($month->days as $j => $day): ?>
                    <?php if ($day): ?>
                        <?php if ($day['nAnswers'] > 0): ?>
                            <td><?=$day['nAnswers']?></td>
                        <?php else: ?>
                            <td><span class="statistic-table__square statistic-table__square--green"></span></td>
                        <?php endif; ?>
                    <?php else: ?>
                        <td><span class="statistic-table--color-ccc">•</span></td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
            <tr class="statistic-table--bg-red statistic-table--style statistik__text--grey statistic-table--title-font-medium">
                <td class="statistic-table--title statistik__text--grey-lighten statistic-table--title-font-xl">Спасибо</td>
                <?php foreach ($month->days as $j => $day): ?>
                    <?php if ($day): ?>
                        <?php if ($day['nLikes'] > 0): ?>
                            <td>
                                <div class="statistic-table__senks"><span class="statistic-table__roze"></span><span class="statistic-table__num"><?=$day['nLikes']?></span></div>
                            </td>
                        <?php else: ?>
                            <td><span class="statistic-table__square statistic-table__square--red"></span></td>
                        <?php endif; ?>
                    <?php else: ?>
                        <td><span class="statistic-table--color-ccc">•</span></td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
            </tbody></table>
    </div>
    <?php endforeach; ?>
</div>