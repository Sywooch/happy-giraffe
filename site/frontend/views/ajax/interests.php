<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $(function() {
            $('.interest-drag').draggable();
            $('.drag-in-area').droppable({
                drop: function (event, ui) {
                    $('.selected-interests-list > ul').append($('#interestTmpl').tmpl({
                        categoryId: ui.draggable.data('category-id'),
                        id: ui.draggable.data('id'),
                        title: ui.draggable.text()
                    }));
                    ui.draggable.hide();
                }
            });
        });
    ";

    $cs
        ->registerScriptFile('/javascripts/jquery.tmpl.min.js')
        ->registerCoreScript('jquery.ui')
        ->registerScript('interests', $js)
    ;
?>

<div id="interestsManage" class="popup">

    <a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>

    <div class="title">Интересы</div>

    <div class="interests-steps clearfix">

        <div class="step-1">

            <div class="step-title clearfix">
                <span class="num">1</span>
                <span class="text">Выберите категорию</span>
            </div>

            <ul>
                <?php foreach ($categories as $i => $c): ?>
                    <li<?php if ($i == 0):?> class="active"<?php endif; ?>>
                        <a href="javascript:void(0)" onclick="Interest.changeCategory(this)"><?=$c->title?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>

        <div class="step-2">

            <div class="step-title clearfix">
                <span class="num">2</span>
                <span class="text">Выберите интересы *</span>
            </div>

            <?php foreach ($categories as $i => $c): ?>
                <div class="interests-drag-list clearfix"<?php if ($i != 0): ?> style="display: none;"<?php endif; ?>>

                    <?php foreach ($c->interests as $interest): ?>
                        <div class="interest-drag" data-id="<?=$interest->id?>" data-category-id="<?=$interest->category_id?>"><i class="icon"></i><?=$interest->title?></div>
                    <?php endforeach; ?>

                </div>
            <?php endforeach; ?>

            <div class="note">
                <span>*</span> Подведи курсор, хватай и тащи
            </div>
            <img src="/images/interests_drag_note.png" />

        </div>

        <div class="step-3">

            <div class="step-title clearfix">
                <span class="num">3</span>
                <span class="text">Мои<br/>интересы</span>
            </div>

            <div class="drag-in-area clearfix">

                <span class="small">Выберите  от 1 до 10 ваших интересов</span>

                <span class="text clearfix"><img src="/images/interests_drag_in_arrow.gif" />Перетащите сюда интерес</span>

            </div>

            <div class="selected-interests-list">
                <ul>
                    <?php foreach ($user_interests as $ui): ?>
                        <li>
                            <span class="img"><a href=""><img src="/images/interest_icon_<?=$ui->category_id?>.png" /></a></span>
                            <span class="text"><a href="javascript:void(0)"><?=$ui->title?></a></span>
                            <a href="javascript:void(0)" class="remove"></a>
                        </li>
                        <?php echo CHtml::hiddenField('Interest[' . $interest->id . ']'); ?>
                    <?php endforeach; ?>
                </ul>

                <div class="btn-box"><a href="" class="btn-finish">Завершить</a></div>

            </div>



        </div>

    </div>

</div>

<script id="interestTmpl" type="text/x-jquery-tmpl">
    <li>
        <span class="img"><a href=""><img src="/images/interest_icon_${categoryId}.png" /></a></span>
        <span class="text"><a href="">${title}</a></span>
        <a href="javascript:void(0)" class="remove"></a>
        <?php echo CHtml::hiddenField('Interest[${id}]'); ?>
    </li>
</script>