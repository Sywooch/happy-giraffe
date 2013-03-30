<?php
/**
 * Author: alexk984
 * Date: 11.12.12
 */
?>
<div class="block">

    <div class="report-icons clearfix margin-b20">
        <div class="report-icons_i float-r">
            <img src="/images/seo2/ico/report.png" alt="" class="report-icons_img">
            <div class="report-icons_hold">
                <div class="report-icons_tx">Заявок</div>
                <div class="report-icons_count" data-bind="text:count">0</div>
            </div>
        </div>

        <div class="report-icons_newcomer">
            Новички на сайте
        </div>
    </div>

    <div class="newcomers clearfix">
        <?php $this->widget('MyListView', array(
            'id'=>'friends',
            'dataProvider' => $dataProvider,
            'itemView' => 'users/_user',
            'pager' => array(
                'class' => 'AlbumLinkPager',
            ),
            'itemsTagName' => 'div',
            'template' => '{items}',
        ))?>
    </div>
</div>

<script type="text/javascript">
    var myViewModel = {
        count: ko.observable(<?=CommentatorHelper::friendRequestsCount(Yii::app()->user->id, date("Y-m-d"),date("Y-m-d"))?>)
    };

    $(function() {
        $('body').delegate('a.newcomers_add-friend', 'click', function(){
            $.post('/friendRequests/send/', {to_id: $(this).data('id')}, function () {
                $.fn.yiiListView.update('friends');
                myViewModel.count(myViewModel.count()+1);
            });
        });

        ko.applyBindings(myViewModel);
    });
</script>