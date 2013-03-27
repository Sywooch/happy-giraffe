<?php
/* @var $this CommentatorController
 * @var $month string месяц отчетности
 * @var $section string раздел отчетности
 */
?>
<?php $this->renderPartial('reports/menu', compact('section')); ?>
<div class="block">

    <div class="month-list clearfix">
        <ul class="month-list_ul">
            <li class="month-list_li active">
                <a href="" class="month-list_i">
                    <span class="month-list_tx">МАР 2013</span>
                </a>
            </li>
            <li class="month-list_li">
                <a href="" class="month-list_i">
                    <span class="month-list_tx">АПР 2013</span>
                </a>
            </li>
            <li class="month-list_li">
                <a href="" class="month-list_i">
                    <span class="month-list_tx">АПР 2013</span>
                </a>
            </li>
            <li class="month-list_li">
                <a href="" class="month-list_i">
                    <span class="month-list_tx">АПР 2013</span>
                </a>
            </li>
            <li class="month-list_li">
                <a href="" class="month-list_i">
                    <span class="month-list_tx">АПР 2013</span>
                </a>
            </li>
            <li class="month-list_li">
                <a href="" class="month-list_i">
                    <span class="month-list_tx">АПР 2013</span>
                </a>
            </li>
            <li class="month-list_li">
                <a href="" class="month-list_i">
                    <span class="month-list_tx">АПР 2013</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="report-icons">
        <div class="report-icons_i">
            <img src="/images/seo2/ico/blog-purple-circle.png" alt="" class="report-icons_img">
            <div class="report-icons_hold">
                <div class="report-icons_tx">Записей в блог</div>
                <div class="report-icons_count">
                    899
                    <span class="report-icons_percent">(87%)</span>
                </div>
            </div>
        </div>
        <div class="report-icons_i">
            <img src="/images/seo2/ico/club-purple-circle.png" alt="" class="report-icons_img">
            <div class="report-icons_hold">
                <div class="report-icons_tx">Записей в клуб</div>
                <div class="report-icons_count">
                    8
                    <span class="report-icons_percent">(87%)</span>
                </div>
            </div>
        </div>

        <div class="report-icons_i">
            <img src="/images/seo2/ico/comment-purple-circle.png" alt="" class="report-icons_img">
            <div class="report-icons_hold">
                <div class="report-icons_tx">Комментариев</div>
                <div class="report-icons_count">
                    87956
                    <span class="report-icons_percent">(87%)</span>
                </div>
            </div>
        </div>

    </div>
    <div class="report">
        <table class="report_table">
            <tbody><tr class="report_odd">
                <td class="report_td-date">
                    <div class="b-date">22 ФЕВРАЛЯ 2013</div>
                </td>
                <td class="report_td-empty"></td>
                <td class="report_td-count">
                    <!--
                        Выполнено    - blog-green-small.png
                        Не выполнено - blog-red-small.png
                      -->
                    <img src="/images/seo2/ico/blog-green-small.png" alt="" class="report_count-ico">
                    <div class="report_count">68654</div>
                </td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/club-green-small.png" alt="" class="report_count-ico">
                    <div class="report_count">54</div>
                </td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/comment-green-small.png" alt="" class="report_count-ico">
                    <div class="report_count">566654</div>
                </td>
                <td class="report_td-empty w-50"></td>
                <td class="report_td-status">
                    <div class="report_status color-green">Выполнен</div>
                </td>
            </tr>
            <tr class="">
                <td class="report_td-date">
                    <div class="b-date">22 ФЕВРАЛЯ 2013</div>
                </td>
                <td class="report_td-empty"></td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/blog-red-small.png" alt="" class="report_count-ico">
                    <div class="report_count">68654</div>
                </td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/club-red-small.png" alt="" class="report_count-ico">
                    <div class="report_count">54</div>
                </td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/comment-red-small.png" alt="" class="report_count-ico">
                    <div class="report_count">566654</div>
                </td>
                <td class="report_td-empty w-50"></td>
                <td class="report_td-status">
                    <div class="report_status color-alizarin">Не выполнен</div>
                </td>
            </tr>
            <tr class="report_odd">
                <td class="report_td-date">
                    <div class="b-date">22 ФЕВРАЛЯ 2013</div>
                </td>
                <td class="report_td-empty"></td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/blog-red-small.png" alt="" class="report_count-ico">
                    <div class="report_count">68654</div>
                </td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/club-green-small.png" alt="" class="report_count-ico">
                    <div class="report_count">54</div>
                </td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/comment-green-small.png" alt="" class="report_count-ico">
                    <div class="report_count">54</div>
                </td>
                <td class="report_td-empty w-50"></td>
                <td class="report_td-status">
                    <div class="report_status color-alizarin">Не выполнен</div>
                </td>
            </tr>
            <tr class="">
                <td class="report_td-date">
                    <div class="b-date">22 ФЕВРАЛЯ 2013</div>
                </td>
                <td class="report_td-empty"></td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/blog-green-small.png" alt="" class="report_count-ico">
                    <div class="report_count">64</div>
                </td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/club-green-small.png" alt="" class="report_count-ico">
                    <div class="report_count">54456</div>
                </td>
                <td class="report_td-count">
                    <img src="/images/seo2/ico/comment-red-small.png" alt="" class="report_count-ico">
                    <div class="report_count">566654</div>
                </td>
                <td class="report_td-empty w-50"></td>
                <td class="report_td-status">
                    <div class="report_status color-alizarin">Не выполнен</div>
                </td>
            </tr>
            </tbody></table>
    </div>
</div>

<table class="table-task">
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
<?php foreach ($this->commentator->getDays($month) as $day): ?>
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