<?php
$basePath = Yii::getPathOfAlias('application.modules.cook.views.converter.assets');
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);

$units = CookUnit::model()->findAll(array('order' => 'title'));
$model->qty = 0;
?>

<div id="measure">

    <div class="title">

        <h2>Калькулятор <span>мер и весов</span></h2>

    </div>

    <div class="hl">

        <div class="calculator">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'converter-form',
                'action' => CHtml::normalizeUrl(array('converter/calculate')),
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => false,
                    'validateOnType' => false,
                    'validationUrl' => $this->createUrl('converter/calculate'),
                    'afterValidate' => "js:function(form, data, hasError) { if (!hasError){ Converter.CalculatePost();} else { return false;} }",
                )
            ));
            ?>

            <div class="product">

                <div class="block-title">Продукт</div>
                <?php
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array('sourceUrl' => Yii::app()->createUrl('cook/converter/ac'), 'name' => 'ac', 'id' => 'ac', 'htmlOptions' => array('data-title' => '', 'placeholder' => 'Введите название продукта')));
                echo $form->hiddenField($model, 'ingredient');
                ?>
                <br/>
                <span>Начинайте вводить название продукта. Например, молоко, мука</span>

            </div>

            <div class="values">

                <div class="input">
                    <?php
                    echo $form->textField($model, 'qty', array(
                        'onkeyup' => 'Converter.Calculate();',
                        'onkeypress' => 'return Converter.qtyInput(event, this);',
                        'onblur' => "if ($(this).val() == ''){ $(this).val(0);}",
                        'onfocus' => "if ($(this).val() == '0'){ $(this).val('');}"
                    ));
                    ?>
                    <br/>
                    Введите кол-во
                </div>

                <div class="drp-list from">
                    <?=$form->hiddenField($model, 'from', array('value' => 1));?>
                    <a href="" class="trigger from" data-id="1" onclick="$('.drp-list ul').hide(); $(this).next().show(); return false;">грамм</a>
                    <ul style="display:none;">
                        <?php
                        foreach ($units as $unit)
                            echo '<li data-id="' . $unit->id . '" style="display:none"><a href="" onclick="Converter.unitSelect($(this), event); return false;">' . $unit->title . '</a></li>';
                        ?>
                    </ul>
                </div>

                <a href="" class="equal" onclick="Converter.unitSwap(event); return false;"></a>

                <span class="value current"></span>

                <div class="drp-list">
                    <?=$form->hiddenField($model, 'to', array('value' => 1));?>
                    <a href="" class="trigger to" data-id="1" onclick="$('.drp-list ul').hide(); $(this).next().show(); return false;">грамм</a>
                    <ul style="display:none;">
                        <?php
                        foreach ($units as $unit)
                            echo '<li data-id="' . $unit->id . '" style="display:none"><a href="" onclick="Converter.unitSelect($(this), event); return false;">' . $unit->title . '</a></li>';
                        ?>
                    </ul>
                </div>

                &nbsp;&nbsp;&nbsp;&nbsp;

                <a href="" class="btn btn-gray-small" onclick="Converter.saveResult(); return false;"><span><span>Запомнить</span></span></a>
                <a href="" class="btn btn-gray-small" onclick="Converter.clear(); return false;"><span><span>Очистить</span></span></a>

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
                <li class="template" style="display: none">
                    <span class="product-name"></span>
                    <span class="value qty"></span>
                    <span class="unit_from"></span>
                    <span class="value">=</span>
                    <span class="value qty_result"></span>
                    <span class="unit_to"></span>
                    <a href="" class="remove tooltip" title="Удалить" onclick="$(this).parent().remove(); return false;"></a>
                </li>
            </ul>

        </div>

    </div>

    <div class="wysiwyg-content">

        <h2>Калькулятор мер и весов</h2>

        <p>Часто бывает: найдёшь с большим трудом нужный рецепт, а в нём хоть одна мера продуктов, да обязательно не в «тех» единицах. Получается, что рецепт-то есть, а воспользоваться им не
            получается. Причём это не единичные случаи, а закономерность для именно тех рецептов, которые очень хочется воспроизвести на своей любимой кухне! Можно, конечно, взять необходимые продукты
            в количестве по наитию или, воспользовавшись калькулятором, посчитать пропорции ингредиентов, можно искать соразмерность каждой единицы в Интернете…но все это занимает достаточно много
            времени и может ещё, даже при незначительной погрешности в вычислениях, привести к плачевным результатам, проще говоря, к выброшенной еде, ведь понятие «мера продуктов» придумана совсем не
            зря.</p>

        <p>Именно для подобных ситуаций создан наш новый сервис о массах и мерах: «Таблица мер продуктов». Теперь, обладая рецептом с набором продуктов в любых измерениях, вы можете легко перевести их
            именно в те, которые вам нужны. Сервис позволяет вообще не задумываться о таком понятии, как мера веса продуктов. В каких бы мерах ни были компоненты – они будут переведены в
            необходимые.</p>

        <div style="background:#fefded;padding:20px 20px 10px;margin-bottom:20px;">
            <h3>Пользоваться сервисом просто: </h3>
            <ol>
                <li>Введите название продукта (выберите из выпадающего списка)</li>
                <li>Впишите количество продукта, выбрав единицы, в которых он указан, затем выбирайте те, которые вам нужны.</li>
            </ol>
            <p> Одна секунда – и вы знаете, сколько граммов масла в чайной ложке или сколько стаканов воды в литре. Любая мера веса продуктов теперь не представляет секрета: наша
                интерактивная таблица мер продуктов переводит любые единицы в те, что надо. Легко, просто, быстро – именно то, что нужно современной хозяйке, у которой очень мало времени. Но это ещё
                не
                всё! Вы можете сохранить результат, чтобы не производить вычисления повторно. Для этого просто нужно нажать на соответствующую кнопку.</p>
        </div>

        <p>Оставьте калькулятор – это не современно! Вооружитесь компьютером и сделайте закладку на странице с нужным сервисом. Мгновенно переводя одни меры в другие, вы сэкономите массу времени и ещё
            больше нервов. Останутся в прошлом сомнения и томление в ожидании: получится – не получится. Получится всё и именно так, как вам нужно. Удачи!</p>

    </div>

</div>