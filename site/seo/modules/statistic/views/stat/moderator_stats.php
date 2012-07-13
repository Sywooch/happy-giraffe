<?php
/**
 * @var $last_date string
 * @var $date string
 * @var $user_id int
 */
?>
<div class="seo-table">
    <?php $this->renderPartial('_date_form', compact('period', 'last_date', 'date')); ?>
    <div class="table-box table-statistic">
        <table>
            <thead>
            <tr>
                <th rowspan="2"><span class="big">Группа</span></th>
                <th colspan="3"><span class="big">Клубы</span></th>
                <th colspan="3"><span class="big">Блоги</span></th>
                <th colspan="2"><span class="big">Сервисы</span></th>
                <th rowspan="2"><span class="big">Гости</span></th>
                <th colspan="2"><span class="big">Фото</span></th>
                <th rowspan="2"><span class="big">Почта</span></th>
                <th rowspan="2"><span class="big">Связи</span></th>
            </tr>
            <tr>
                <th>Посты</th>
                <th>Видео</th>
                <th>Комм.</th>
                <th>Посты</th>
                <th>Видео</th>
                <th>Комм.</th>
                <th>Посты</th>
                <th>Комм.</th>
                <th>Личные</th>
                <th>Сервисы.</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($moderators as $moderator){
                echo '<tr>';
                $stats = new UserStats;
                $stats->date = $last_date;
                $stats->date2 = $date;
                $stats->user_id = $moderator;

                echo '<td><a href="javascript:;" onclick="Statistic.addUser('.$moderator.')">'.User::getUserById($moderator)->fullName.'</a></td>';
                $this->renderPartial('_table_row',compact('stats'));

                echo '</tr>';
            }?>
            <tr class="total">
                <td class="al"><span class="big">Всего</span></td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
