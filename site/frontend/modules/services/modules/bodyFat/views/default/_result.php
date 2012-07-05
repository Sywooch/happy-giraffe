<style type="text/css">
    #result table td {
        padding: 3px 10px
    }
</style>

<table>
    <tr>
        <td>Процент жира</td>
        <td><?=$result['fatPercent']?> %</td>
    </tr>
    <tr>
        <td>Вес жира</td>
        <td><?=$result['fatWeight']?> кг</td>
    </tr>
    <tr>
        <td>Вес без жира</td>
        <td><?=$result['bodyWeight']?> кг</td>
    </tr>
</table>