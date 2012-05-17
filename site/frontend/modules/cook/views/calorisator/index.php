<style type="text/css">
    input {
        border: 1px solid #555
    }

    table#ingredients {
        width: 100%;
        border-collapse: collapse;
    }

    table#ingredients td, th {
        padding: 4px 10px;
        border: 1px solid #AAA
    }

</style>
<h1>Калоризатор</h1>
<div style="display:none">
    <?php
    $this->widget('zii.widgets.jui.CJuiAutoComplete', array('name' => 't', 'sourceUrl' => Yii::app()->createUrl('cook/calorisator/ac'),));
    ?>
</div>
<table id="ingredients">

    <tr>
        <th>Продукт</th>
        <th>Кол-во</th>
        <th>ед.изм.</th>
        <th>белки</th>
        <th>жиры</th>
        <th>углеводы</th>
        <th>калории</th>
    </tr>
    <tr class="template" style="display:none">
        <td class="title">
            <?php
            echo CHtml::textField('ingredient[nnn][name]', '', array('class' => 'ingredient_ac'));
            ?>
        </td>
        <td class="qty">
            <?php
            echo CHtml::textField('ingredient[nnn][qty]', '', array('onblur' => 'Calorisator.Calculate();', 'onkeyup' => 'Calorisator.Calculate();'));
            ?>
        </td>
        <td class="unit">
            <select id="ingredient_nnn_unit" name="ingredient[nnn][unit]" onchange="Calorisator.Calculate();">
                <?php
                foreach ($units as $unit) {
                    $display = (in_array($unit['type'], array('qty', 'single', 'undefined'))) ? ' style="display:none" ' : '';
                    echo '<option value="' . $unit['id'] . '" data-id="' . $unit['id'] . '" data-type="' . $unit['type'] . '" data-ratio="' . $unit['ratio'] . '"' . $display . ' >' . CHtml::encode($unit['title']) . '</option>';
                }
                //echo CHtml::dropDownList('ingredient[nnn][unit]', '1', CHtml::listData($units, 'id', 'title'));
                ?>
            </select>


        </td>
        <td class="nutritional n3" data-value="0" data-n="3"></td>
        <td class="nutritional n2" data-value="0" data-n="2"></td>
        <td class="nutritional n4" data-value="0" data-n="4"></td>
        <td class="nutritional n1" data-value="0" data-n="1"></td>
    </tr>


    <tr class="results">
        <td>Итого</td>
        <td class="qty" data-value="0"></td>
        <td>г</td>
        <td class="nutritional n3" data-n="3"></td>
        <td class="nutritional n2" data-n="2"></td>
        <td class="nutritional n4" data-n="4"></td>
        <td class="nutritional n1" data-n="1"></td>
    </tr>

    <tr class="results100">
        <td>Итого на 100 грамм</td>
        <td class="qty"></td>
        <td>г</td>
        <td class="nutritional n3"></td>
        <td class="nutritional n2"></td>
        <td class="nutritional n4"></td>
        <td class="nutritional n1"></td>
    </tr>
</table>
<a href="#" onclick="Calorisator.addRow(event);" id="addRow">add row</a>