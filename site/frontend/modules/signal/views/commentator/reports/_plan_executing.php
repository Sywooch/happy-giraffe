<?php
/* @var $this CommentatorController
 * @var $period
 */
?><table class="table-task">
    <tr>
        <td class="col-1">6.  Выполнение плана </td>

        <td class="col-2"></td>
        <td class="col-3"></td>
        <td class="col-4"></td>
    </tr>
</table>

<div class="table-box table-statistic">
    <table>
        <thead>
        <tr>
            <th><span class="big">Дата</span></th>
            <th><span class="big">Записей в блог</span></th>
            <th><span class="big">Записей в клуб</span></th>
            <th><span class="big">Комментариев</span></th>
            <th><span class="big">Выполнение</span></th>
        </tr>
        </thead>
        <tbody>
<?php foreach ($this->commentator->getDays($period) as $day): ?>
            <tr>
                <td><?=Yii::app()->dateFormatter->format('dd MMM yyyy',$day->created)?></td>
                <td><?=$day->blog_posts ?></td>
                <td><?=$day->club_posts ?></td>
                <td><?=$day->comments ?></td>
                <?=$day->getStatusView() ?>
            </tr>

<?php endforeach; ?>
        </tbody>
    </table>
</div>