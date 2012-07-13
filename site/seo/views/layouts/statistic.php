<?php $this->beginContent('//layouts/main');?>
<div class="clearfix">
    <div class="default-nav">

        <?php
        $this->widget('zii.widgets.CMenu', array(
            'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
            'items' => array(
                array(
                    'label' => 'Модераторы',
                    'url' => array('/statistic/stat/moderators'),
                ),
                array(
                    'label' => 'Пользователи',
                    'url' => array('/statistic/stat/users'),
                ),
                array(
                    'label' => 'Группы',
                    'url' => array('/statistic/stat/groups'),
                ),
            )));

        ?>
    </div>

    <?php $this->renderPartial('//layouts/_header'); ?>
</div>
<?php echo $content; ?>
<script type="text/javascript">
    $(function () {
        $('.table-box table').each(function(){
            var $this = $(this);
            var column = $this.find('tr:nth-child(2)').find('td').length;
            var row = $this.find('tr').length;

            var arr = new Array();
            for (cc=1; cc<column; cc++) {
                arr[cc] = 0;
            }

            for (rr=1; rr<row; rr++) {
                var $tr = $this.find('tr').eq(rr);

                for (cc=1; cc<=column; cc++) {
                    var mark = $tr.find('td').eq(cc).html();
                    if (parseInt(mark) > 0) {
                        arr[cc] += parseInt(mark);
                    }
                }
            }

            for (cc=0; cc<column; cc++) {
                $this.find('tr.total td').eq(cc).html(arr[cc]);
            }
        });
    });
</script>
<?php $this->endContent(); ?>