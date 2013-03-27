<?php
/**
 * @var $month string месяц за который показываем статистику
 * @var $links CommentatorLink[] ссылки пользователя
 */
$months = array();
for ($i = 0; $i < 7; $i++)
    $months [] = date("Y-m", strtotime('- ' . $i . ' month'));


?><div class="block">
    <div class="month-list clearfix">
        <ul class="month-list_ul">
            <?php foreach ($months as $menu_month): ?>
                <li class="month-list_li<?php if ($menu_month == $month) echo ' active' ?>">
                    <a href="<?=$this->createUrl('links', array('month'=>$menu_month)) ?>" class="month-list_i">
                        <span class="month-list_tx"><?= HDate::ruShortMonth(date("n", strtotime($menu_month.'-01'))).' '.date("Y", strtotime($menu_month.'-01'))?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="external-link-add">
        <input type="text" name="" id="url" class="itx-bluelight external-link-add_itx" placeholder="Где проставлена ссылка">
        <div class="external-link-add_ico"></div>
        <input type="text" name="" id="page_url" class="itx-bluelight external-link-add_itx" placeholder="Моя запись на Веселом Жирафе">
        <button id="add_link_btn" class="external-link-add_btn btn-green">Ok</button>
    </div>

    <table class="external-link">
        <tbody>
        <?php $count = 0 ?>
        <?php foreach ($links as $link): ?>
            <?php $this->renderPartial('_link', array('link' => $link, 'count' => $count)); ?>
            <?php $count++ ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $('#add_link_btn').click(function () {
        $.post('/commentator/addLink/', {
            url:$('#url').val(),
            page_url:$('#page_url').val()
        }, function (response) {
            if (response.status) {
                $('table.external-link tbody').prepend(response.html);

                if (!$('table.external-link tr:eq(1)').hasClass('external-link_odd'))
                    $('table.external-link tr:first').addClass('external-link_odd');
                $('#url').val('');
                $('#page_url').val('');
            }else
                alert(response.error);
        }, 'json');
    });
</script>