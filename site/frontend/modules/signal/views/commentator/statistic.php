<?php
/* @var $this CommentatorController
 * @var $period
 */

$months = $this->commentator->getWorkingMonths();
?><div class="seo-table">

    <div class="fast-filter fast-filter-community">
        <?php foreach ($months as $key => $month): ?>
            <?php if ($period == $month):?>
                <span class="active" style="text-transform: capitalize;"><?=Yii::app()->dateFormatter->format('MMM yyyy',strtotime($month)) ?></span>
            <?php else: ?>
                <a style="text-transform: capitalize;" href="<?=$this->createUrl('/signal/commentator/statistic', array('period'=>$month)) ?>"><?=Yii::app()->dateFormatter->format('MMM yyyy',strtotime($month)) ?></a>
            <?php endif ?>
        <?php if ($key + 1 < count($months)):?>
            &nbsp;|&nbsp;
        <?php endif ?>
        <?php endforeach; ?>
    </div>

    <ul class="task-list">

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">1.  Друзей за месяц</td>

                    <td class="col-2"><?=$this->commentator->friendsCount($period) ?></td>
                    <td class="col-3"><span class="place place-3">3 место</span></td>
                    <td class="col-4"><a href="">Как найти друзей</a></td>
                </tr>
            </table>

        </li>

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">2.  Уникальных посетителей блога</td>

                    <td class="col-2"><?=$this->commentator->blogVisits($period) ?></td>
                    <td class="col-3"><span class="place">12 место</span></td>
                    <td class="col-4"><a href="">Как найти друзей</a></td>
                </tr>
            </table>

        </li>

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">3.  Количество просмотров анкеты</td>

                    <td class="col-2"><?=$this->commentator->profileUniqueViews($period) ?></td>
                    <td class="col-3"><span class="place place-1">1 место</span></td>
                    <td class="col-4"><a href="">Как увеличить кол-во просмотров анкеты</a></td>
                </tr>
            </table>

        </li>

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">4.  Количество личных сообщений</td>

                    <td class="col-2"><?=$this->commentator->getMessagesCount($period) ?></td>
                    <td class="col-3"><span class="place">6 место</span></td>
                    <td class="col-4"><a href="">Как строить общение</a></td>
                </tr>
            </table>

        </li>

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">5.  Заходов из поисковых систем <a href="" class="pseudo">Скрыть</a></td>

                    <td class="col-2">98</td>
                    <td class="col-3"><span class="place place-2">2 место</span></td>
                    <td class="col-4"><a href="">Как получить много трафика из поисковых систем</a></td>
                </tr>
            </table>

            <div class="table-box table-statistic">
                <table>
                    <thead>
                    <tr>
                        <th class="al"><span class="big">Запись</span></th>
                        <th><span class="big">Заходов</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="al"><span class="big"><a href="">Секреты счастливых семейных пар</a></span></td>
                        <td>34</td>
                    </tr>
                    <tr>
                        <td class="al"><span class="big"><a href="">Кесарево сечение</a></span></td>
                        <td>23</td>
                    </tr>
                    <tr>
                        <td class="al"><span class="big"><a href="">После кесарева сечения</a></span></td>
                        <td>21</td>
                    </tr>
                    <tr>
                        <td class="al"><span class="big"><a href="">5 языков любви: Пойми любимого с полуслова</a></span></td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td class="al"><span class="big"><a href="">Беременность после 30: правда и вымысел</a></span></td>
                        <td>4</td>
                    </tr>
                    </tbody>
                </table>
            </div>


        </li>

        <li>

            <table class="table-task">
                <tr>
                    <td class="col-1">6.  Выполнение плана <a href="" class="pseudo">Скрыть</a></td>

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
                        <th><span class="big">Комментариевv</span></th>
                        <th><span class="big">Выполнение</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>10 сен. 2012</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td class="task-done">Выполнен</td>
                    </tr>
                    <tr>
                        <td>11 сен. 2012</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td class="task-not-done">Не выполнен</td>
                    </tr>
                    <tr>
                        <td>12 сен. 2012</td>
                        <td>3</td>
                        <td>3</td>
                        <td>3</td>
                        <td class="task-overdone">Перевыполнен</td>
                    </tr>

                    </tbody>
                </table>
            </div>


        </li>

    </ul>

</div>