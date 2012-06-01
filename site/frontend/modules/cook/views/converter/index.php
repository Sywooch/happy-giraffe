<?php
$basePath = Yii::getPathOfAlias('application.modules.cook.views.converter.assets');
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);

$units = CookUnit::model()->findAll(array('order' => 'title'));
?>

<div id="measure">

    <div class="title">

        <h2>Калькулятор <span>мер и весов</span></h2>

    </div>

    <div class="calculator">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'converter-form',
            'action' => CHtml::normalizeUrl(array('converter/calculate')),
            'enableAjaxValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => false,
                'validateOnType' => false,
                'validationUrl' => $this->createUrl('converter/calculate'),
                'afterValidate' => "js:function(form, data, hasError) { if (!hasError){ Converter.Calculate();} else { return false;} }",
            )
        ));
        ?>

        <div class="product">

            <div class="block-title">Продукт</div>
            <!--<input type="text" placeholder="Введите название продукта" value="Яйцо куриное"/>-->
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'sourceUrl' => Yii::app()->createUrl('cook/converter/ac'),
                'name' => 'ac',
                'id' => 'ac'
            ));
            echo $form->hiddenField($model, 'ingredient');
            ?>

        </div>

        <div class="values">

            <!--<input type="text" placeholder="0" value="0"/>-->
            <?php echo $form->textField($model, 'qty',array('onchange'=>'Converter.Calculate();')); ?>

            <div class="drp-list from">
                <?=$form->hiddenField($model, 'from', array('value'=>1));?>
                <a href="" class="trigger from" data-id="1" onclick="$('.drp-list ul').hide(); $(this).next().show(); event.preventDefault();">грамм</a>
                <ul style="display:none;">
                    <?php
                    foreach ($units as $unit)
                        echo '<li data-id="' . $unit->id . '" style="display:none"><a href="" onclick="Converter.unitSelect($(this), event);">' . $unit->title . '</a></li>';
                    ?>
                </ul>
            </div>

            <a href="" class="equal" onclick="Converter.unitSwap(event);"></a>

            <span class="value current"></span>

            <div class="drp-list">
                <?=$form->hiddenField($model, 'to', array('value'=>1));?>
                <a href="" class="trigger to" data-id="1" onclick="$('.drp-list ul').hide(); $(this).next().show(); event.preventDefault();">грамм</a>
                <ul style="display:none;">
                    <?php
                    foreach ($units as $unit)
                        echo '<li data-id="' . $unit->id . '" style="display:none"><a href="" onclick="Converter.unitSelect($(this), event);">' . $unit->title . '</a></li>';
                    ?>
                </ul>
            </div>

            <a href="" class="btn btn-gray-small"><span><span>Запомнить</span></span></a>

        </div>

        <?php

        $form->error($model, 'from');
        $form->error($model, 'to');
        $form->error($model, 'qty');
        $form->error($model, 'ingredient');

        echo $form->errorSummary($model);
        $this->endWidget();

        ?>
    </div>

    <div class="saved-calculations">

        <ul>
            <!--<li>
                <span class="product-name">Яйцо куриное</span>
                <span class="value">10</span>
                штук
                <span class="value">=</span>
                <span class="value">203,5</span>
                грамм
                <a href="" class="remove tooltip" title="Удалить"></a>
            </li>
            <li>
                <span class="product-name">Яйцо куриное</span>
                <span class="value">100</span>
                штук
                <span class="value">=</span>
                <span class="value">2035</span>
                грамм
                <a href="" class="remove tooltip" title="Удалить"></a>
            </li>
            <li>
                <span class="product-name">Яйцо куриное</span>
                <span class="value">1</span>
                штук
                <span class="value">=</span>
                <span class="value">20,35</span>
                грамм
                <a href="" class="remove tooltip" title="Удалить"></a>
            </li>
            <li>
                <span class="product-name">Яйцо куриное</span>
                <span class="value">1000</span>
                штук
                <span class="value">=</span>
                <span class="value">20350</span>
                грамм
                <a href="" class="remove tooltip" title="Удалить"></a>
            </li>
-->
        </ul>

    </div>

</div>