<?php
/**
 * @var $last_date string
 * @var $date string
 * @var $users array
 */
?>
<div class="seo-table">
    <?php $this->renderPartial('_date_form', compact('period', 'last_date', 'date')); ?>
    <div class="table-box table-statistic">
        <table>
            <thead>
            <tr>
                <th rowspan="2"><span class="big">Дата</span></th>
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
            foreach($users as $user){
                echo '<tr>';
                $stats = new UserStats;
                $stats->date = $last_date;
                $stats->date2 = $date;
                $stats->user_id = $user;

                echo '<td><a href="http://www.happy-giraffe.ru/user/'.$user.'/" target="_blank">'.User::getUserById($user)->fullName.'</a></td>';
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
