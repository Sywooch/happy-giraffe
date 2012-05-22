<div class="table-box tab-box tab-box-1" style="display: block; ">
    <table>
        <tbody>
        <tr>
            <th class="al">Ключевые слова и фразы</th>
            <th>Исполнитель</th>
            <th>Статус</th>
        </tr>

        <?php foreach ($tasks as $task): ?>
        <tr>
            <td class="al"><?=$task->getText() ?></td>
            <td><?=$task->getIcon() ?></td>
            <td class="seo-status-new-<?=$task->status ?>">Новое</td>
        </tr>
        <?php endforeach; ?>

        <tr>
            <td class="al">кесарева сечение<br>кесарево сечение<br>после кесарева сечения</td>
            <td><i class="icon-moderator"></i><br><span class="admin-name">Петров Александр</span></td>
            <td class="seo-status-new-2">Новое</td>
        </tr>
        <tr>
            <td class="al">кесарева сечение<br>кесарево сечение<br>после кесарева сечения</td>
            <td><i class="icon-admin"></i><br><span class="admin-name">Богоявленский Александр</span></td>
            <td class="seo-status-new-1">Новое</td>
        </tr>
        <tr>
            <td class="al">кесарева сечение<br>кесарево сечение<br>после кесарева сечения</td>
            <td><i class="icon-admin"></i><br><span class="admin-name">Богоявленский Александр</span></td>
            <td class="seo-status-new-2">Новое</td>
        </tr>

        </tbody>
    </table>
</div>
