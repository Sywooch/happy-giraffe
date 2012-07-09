<style type="text/css">
    #result table td {
        padding: 3px 10px
    }
</style>

<table>
    <tr>
        <td>Идеальный вес</td>
        <td><?=$result['idealWeight']['result']?> кг</td>
    </tr>

    <tr>
        <td>отклонение от идеального веса</td>
        <td><?=$result['idealWeight']['deviation']?> %</td>
    </tr>

    <?php if ($result['lossRight'] > 0): ?>

    <tr>
        <td>Вам нужно похудеть на</td>
        <td><?=$result['lossRight']?> кг</td>
    </tr>

    <tr>
        <td>Ваша суточная потребность</td>
        <td><?=$result['dailyCalories']['calories']?> кал</td>
    </tr>

    <tr>
        <td>Ваша суточная потребность для похудения на <?=$result['lossRight']?> кг за <?=$result['input']['days']?> дней</td>
        <td><?=$result['dailyCaloriesLoss']?> кал</td>
    </tr>

    <tr>
        <td>Ваша безопасная суточная потребность для похудения на <?=$result['lossRight']?> кг за <?=$result['daysRight']?> дней</td>
        <td><?= $result['dailyCaloriesRightLoss']?> кал</td>
    </tr>
    <?php endif; ?>

</table>