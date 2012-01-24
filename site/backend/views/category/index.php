<?php
$model = new Category;
?>
<div class="centered">
    <h1>Категории товаров</h1>

    <div class="total_block">
        <p>Категорий (подкатегорий)- <ins><?php echo $count['total']; ?></ins></p>

        <p>
            <span class="deactive_items">- <ins><?php echo $count['off']; ?></ins></span>
            <span class="active_items">- <ins><?php echo $count['on']; ?></ins></span>
        </p>
    </div>

    <div class="search_ct">
        <form action="#" onsubmit="return findNodes(this);">
            <p>
                <label for="findText">Поиск категории</label>
                <input id="findText" type="text" class="search_catg"/>
                <input type="submit" class="search_subm" value="Найти"/>
            </p>
        </form>
    </div>
    <!-- .search_ct -->
    <div class="clear"></div>
    <!-- .clear -->
</div>

<div class="grid">
    <div class="grid_head">
        <div class="name_ct">
            <span>Название категории</span>
            <span class="add_main_ct" title="Создание подкатегории">+</span>
        </div>
        <div class="active_ct">Действие</div>
        <div class="goods_ct">Товары</div>
        <div class="sell_ct">
            <span>Продажи <ins>(руб.)</ins></span>
            <ul>
                <li><a href="#" class="active">д</a></li>
                <li>|</li>
                <li><a href="#">н</a></li>
                <li>|</li>
                <li><a href="#">м</a></li>
                <li>|</li>
                <li><a href="#">г</a></li>
            </ul>
        </div>
        <div class="ad_ct"></div>
    </div>
    <div class="grid_body">
        <?php echo $this->getTreeItems($tree); ?>
    </div>
</div>

<script type="text/javascript">
    $('.grid .grid_body ul').nestedSortable({
        listType : 'ul',
        items: 'li',
        handle : 'a.move_lvl',
        placeholder: 'placeholder',
        forcePlaceholderSize: true,
        helper : 'clone',
        maxLevels : 3,
        update : function(event, ui) {
            //TODO зафиксить, не всегда работает
            var old = $(this);
            if(old.children().size() == 0) {
                old.parent().removeClass('opened').addClass('empty_item');
                old.remove();
            }

            ui.item.parent().addClass('descendants');
            var item_id = ui.item.attr('id').split('_')[2];
            if(ui.item.index() != 0)
                var prev_id = ui.item.prev().attr('id').split('_')[2];
            if(ui.item.parents('li:eq(0)').size() > 0) {
                var parent = ui.item.parents('li:eq(0)');
                var parent_id = parent.attr('id').split('_')[2];
                parent.addClass('opened');
                parent.children('div.data').find('.nm_catg').removeClass('turn_icon').addClass('expand_icon');
                if(parent.hasClass('empty_item'))
                    parent.removeClass('empty_item');
            }
            $.get(
                '<?php echo $this->createUrl('moveNode'); ?>',
                {id : item_id, prev : prev_id, parent : parent_id}
            );
        }
    });
    $('.grid .grid_body').delegate('a.nm_catg', 'click', function() {
        $(this).parents('li:eq(0)').toggleClass('opened');
        $(this).toggleClass('turn_icon expand_icon');
    });
    $('.grid').delegate('span.add_main_ct', 'click', function() {
        $('#grid_new_root_form').tmpl().appendTo('.grid .grid_body > ul');
    });
    $('.grid').delegate('span.add_child', 'click', function() {
        var parent = $(this).parents('li:eq(1)');
        if(parent.children('ul').size() > 0)
            var ul = parent.children('ul');
        else {
            var ul = $('<ul></ul>').addClass('descendants').appendTo(parent);
        }
        $('#grid_new_root_form').tmpl().prependTo(ul);
        if(!parent.hasClass('opened'))
            parent.children('div.data').find('.nm_catg').trigger('click');
    });
    $('body').delegate('input[type=button].b_new_catg', 'click', function() {
        if($(this).parents('li:eq(0)').parent('ul').parent('.grid_body').size() > 0) {
            var type = 'root';
            var prependTo = 0;
        } else {
            var type = 'child';
            var prependTo = $(this).parents('li:eq(1)').attr('id').split('_')[2];
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: $(this).parents('form').attr('action'),
            data: $(this).parents('form').serialize() + '&type=' + type + '&prependTo=' + prependTo,
            success: function(response) {
                if (response.status == '1') {
                    $(this).parents('li:eq(0)').replaceWith($(response.html));
                    totalCountInc(response.attributes.active);
                }
            },
            context: $(this)
        });
    });
    function totalCountInc(active) {
        $('div.total_block > p > ins').text(parseInt($('div.total_block > p > ins').text()) + 1);
        var selector = ((!active || active == null) ? 'span.deactive_items' : 'span.active_items') + ' > ins';
        $('div.total_block').find(selector).text(parseInt($('div.total_block').find(selector).text()) + 1);
    }
</script>
<script id="grid_new_root_form" type="text/x-jquery-tmpl">
    <li class="empty_item new_item">
        <div class="data">
            <div class="name_ct">
                <a href="#" class="move_lvl" title="Переместить">&nbsp;</a>
                <a href="#" class="nm_catg turn_icon" title="Развернуть">&nbsp;</a>
                <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'action' => '/category/add',
                    ));
                ?>
                    <?php echo $form->textField($model, 'category_name', array('class' => 't_new_catg')); ?>
                    <?php echo CHtml::button('Ok', array('class' => 'b_new_catg')); ?>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </li>
</script>