<?php
/**
 * @var $tables
 */
?>

<style>
    table.stats {
        margin-bottom: 40px;
    }

    table.stats td {
        width: 150px;
        border: 1px solid #000;
        text-align: center;
        padding: 5px;
    }
</style>


<div class="page-col">
    <div class="page-col_cont page-col_cont__gray">
        <!-- antispam-->
        <div class="antispam">
            <?php foreach ($tables as $result): ?>
                <table class="stats">
                    <thead>
                    <tr>
                        <td></td>
                        <td>Комментарии - блоги</td>
                        <td>Комментарии - клубы</td>
                        <td>Посты - блоги</td>
                        <td>Посты - клубы</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($result as $r): ?>
                        <tr>
                            <td><?=$r[0]?></td>
                            <td><?=$r[1]?></td>
                            <td><?=$r[2]?></td>
                            <td><?=$r[3]?></td>
                            <td><?=$r[4]?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        </div>
        <!-- /antispam-->
    </div>
</div>

