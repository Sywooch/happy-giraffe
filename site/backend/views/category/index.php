<?php
    $model = new Category;

    $cs = Yii::app()->clientScript;

    $js = "
        var treeInfo = new Array;

        $('table.common_sett tr[class!=\"sett_lvl1\"]:gt(0)').hide();

        $('body').delegate('a.turn_icon, a.expand_icon', 'click', function(e) {
            e.preventDefault();
            $(this).toggleClass('turn_icon expand_icon');
        });

        $('body').delegate('a.turn_icon', 'click', function() {
            var currentRow = $(this).parents('tr');
            var currentPk = currentRow.attr('id').replace('node_', '');
            expand(currentPk);
        });

        $('body').delegate('a.expand_icon', 'click', function() {
            var currentRow = $(this).parents('tr');
            var currentPk = currentRow.attr('id').replace('node_', '');
            collapse(currentPk);
        });

        $('body').delegate('span.add_main_ct', 'click', function() {
            $('#new_root_form').tmpl().appendTo('table.common_sett');
        });

        $('body').delegate('span.add_child', 'click', function() {
            var currentRow = $(this).parents('tr');
            var currentLvl = parseInt(currentRow.attr('class').replace(/sett_lvl/, ''));
            var currentPk = currentRow.attr('id').replace('node_', '');
            expand(currentPk);
            currentRow.after($('#new_child_form').tmpl({lvl: currentLvl + 1, prependTo: currentPk}));
        });

        $('body').delegate('input[type=button].b_new_catg', 'click', function() {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: $(this).parents('form').attr('action'),
                data: $(this).parents('form').serialize(),
                success: function(response) {
                    if (response.status == '1')
                    {
                        $(this).parents('tr').replaceWith($('#new_ct').tmpl({
                            lvl: response.attributes.category_level,
                            category_name: response.attributes.category_name,
                            modelPk: response.modelPk,
                            modelName: response.modelName,
                            modelActive: response.attributes.modelActive,
                        }));

                        var parentId = $(this).parents('form').find('input[name=\"prependTo\"]').val();
                        addNode(response.modelPk, parentId);

                        totalCountInc(response.attributes.modelActive);
                    }
                },
                context: $(this)
            });
        });

        function addNode(pk, to)
        {
            treeInfo[pk] = new Array;
            treeInfo[pk]['descendants'] = new Array;
            treeInfo[pk]['children'] = new Array;
            treeInfo[pk]['ancestors'] = new Array;
            treeInfo[pk]['parent'] = '';

            if (typeof(to) != 'undefined')
            {
                treeInfo[pk]['ancestors'] = treeInfo[to]['ancestors'];
                treeInfo[pk]['ancestors'].push(to);
                treeInfo[pk]['parent'] = to;
                treeInfo[to]['children'].push(pk);
                treeInfo[to]['descendants'].push(pk);
                for (var key in treeInfo[to]['ancestors'])
                {
                    treeInfo[treeInfo[to]['ancestors'][key]]['descendants'].push(pk);
                }
            }
        }

        function deleteNode(pk)
        {
            for (var key in treeInfo[pk]['descendants'])
            {
                $('#node_' + treeInfo[pk]['descendants'][key]).remove();
            }
        }

        function expand(pk)
        {
            for (var key in treeInfo[pk]['children'])
            {
                $('#node_' + treeInfo[pk]['children'][key]).show();
            }
        }

        function collapse(pk)
        {
            for (var key in treeInfo[pk]['descendants'])
            {
                var node = $('#node_' + treeInfo[pk]['descendants'][key]);
                node.find('a.expand_icon').toggleClass('turn_icon expand_icon');
                node.hide();
            }
        }

        function totalCountInc(active)
        {
            $('div.total_block > p > ins').text(parseInt($('div.total_block > p > ins').text()) + 1);
            var selector = ((active) ? 'span.deactive' : 'span.active') + ' > ins';
            selector.text(parseInt(selector.text()) + 1);
        }
    ";

    $cs->registerScript('add_root_category', $js)
?>

<script id="new_root_form" type="text/x-jquery-tmpl">
    <tr class="sett_lvl1">
        <td class="name_ct" colspan="4">
            <a href="#" class="move_lvl" title="Переместить">&nbsp;</a>
            <a href="#" class="nm_catg turn_icon" title="Развернуть">&nbsp;</a>
            <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'action' => 'category/add/type/root',
                ));
            ?>
                <?php echo $form->textField($model, 'category_name', array('class' => 't_new_catg')); ?>
                <?php echo CHtml::button('Ok', array('class' => 'b_new_catg')); ?>
            <?php $this->endWidget(); ?>
        </td>
    </tr>
</script>

<script id="new_child_form" type="text/x-jquery-tmpl">
    <tr class="sett_lvl${lvl}">
        <td class="name_ct" colspan="4">
            <a href="#" class="move_lvl" title="Переместить">&nbsp;</a>
            <a href="#" class="nm_catg turn_icon" title="Развернуть">&nbsp;</a>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'action' => 'category/add/type/child',
            ));
            ?>
            <?php echo $form->textField($model, 'category_name', array('class' => 't_new_catg')); ?>
            <?php echo CHtml::hiddenField('prependTo', '${prependTo}'); ?>
            <?php echo CHtml::button('Ok', array('class' => 'b_new_catg')); ?>
            <?php $this->endWidget(); ?>
        </td>
    </tr>
</script>

<script id="new_ct" type="text/x-jquery-tmpl">
    <tr class="sett_lvl${lvl}" id="node_${modelPk}">
        <td class="name_ct">
            <a href="#" class="move_lvl" title="Переместить">&nbsp;</a>
            <a href="#" class="nm_catg expand_icon" title="Свернуть">&nbsp;</a>
            <a href="#" class="edit">${category_name}</a>
        </td>
        <td class="active_ct">
            <ul>
                {{if lvl < 3}}
                    <li><span title="Создание подкатегории" class="add_child">
                    <img src="images/icons/add_catg_icon.png" alt="Создание подкатегории"/></span></li>
                {{/if}}
                <li><a href="#" title="Подробно о категории">
                    <img src="images/icons/info_catg_icon.png" alt="Подробно о категории"/></a></li>
                <li><a href="#" title="Посмотреть в магазине">
                    <img src="images/icons/view_shop_icon.png" alt="Посмотреть в магазине"/></a></li>
            </ul>
        </td>
        <td class="goods_ct">
            <ul>
                <li>Товаров - <a href="#">0</a></li>
                <li>Брендов - <a href="#">0</a></li>
            </ul>
        </td>
        <td class="sell_ct">
            <ul>
                <li>
                    <ins>Оборот</ins>
                    - 23 256 789
                </li>
                <li>
                    <ins>Прибыль</ins>
                    - 8 363 123
                </li>
            </ul>
        </td>
        <td class="ad_ct">
            <ul>
                <li>
                    <?php
                        $this->widget('OnOffWidget', array(
                            'modelPk' => '${modelPk}',
                            'modelName' => get_class($model),
                            'modelActive' => '${modelActive}',
                        ));
                    ?>
                </li>
                <li>
                    <?php
                        $this->widget('DeleteWidget', array(
                            'modelPk' => '${modelPk}',
                            'modelName' => get_class($model),
                            'modelAccusativeName' => $model->accusativeName,
                            'modelIsTree' => true,
                        ));
                    ?>
                </li>
            </ul>
        </td>
    </tr>
</script>

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
        <form action="#">
            <p>
                <label for="findText">Поиск категории</label>
                <input id="findText" type="text" class="search_catg"/>
                <input type="button" class="search_subm" value="Найти"/>
            </p>
        </form>
    </div>
    <!-- .search_ct -->
    <div class="clear"></div>
    <!-- .clear -->
</div>

<!-- .centered -->
<div class="sett_block">
<table class="common_sett">
<tr>
    <th class="name_ct">
        <span>Название категории</span>
        <span class="add_main_ct" title="Создание подкатегории">+</span>
    </th>
    <th class="active_ct">Действие</th>
    <th class="goods_ct">Товары</th>
    <th class="sell_ct">
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
    </th>
    <th class="ad_ct"></th>
</tr>
<?php foreach ($tree as $c): ?>
    <?php $this->renderPartial('_tr', array(
        'category' => $c,
    )); ?>
<?php endforeach; ?>
</table>
</div>
<!-- .sett_block -->