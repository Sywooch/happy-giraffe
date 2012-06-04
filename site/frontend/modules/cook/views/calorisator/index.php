<?php
$basePath = Yii::getPathOfAlias('cook') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'calorisator' . DIRECTORY_SEPARATOR . 'assets';
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
?>

<div id="calories-calculator">

    <div class="title">
        <span>Узнайте!</span>

        <h2>Сколько калорий<br/>в Ваших продуктах</h2>

        <h1>Счетчик калорий</h1>
    </div>

    <div class="calculator">

        <table id="ingredients">
            <thead>
            <tr>
                <td class="col-1">Продукт</td>
                <td class="col-2">Кол-во</td>
                <td class="col-3">Ед. изм.</td>
                <td class="col-4"><span class="calories-icon orange">Б</span>Белки, <span>г.</span></td>
                <td class="col-5"><span class="calories-icon green">Ж</span>Жиры, <span>г.</span></td>
                <td class="col-6"><span class="calories-icon yellow">У</span>Углеводы, <span>г.</span></td>
                <td class="col-7"><span class="calories-icon blue">К</span>Калории, <span>ккал.</span></td>
            </tr>

            </thead>
            <tbody>
            <tr class="template" style="display:none">
                <td class="col-1 title"><input type="text" class="ingredient_ac" value="" placeholder="Введите название продукта"/></td>
                <td class="col-2 qty"><input type="text" value="" placeholder="0" onblur="Calorisator.Calculate();" onkeyup="Calorisator.Calculate();"/></td>
                <td class="col-3 unit">
                    <span class="nchzn-v2">
                        <!--<select class="nchzn" onchange="Calorisator.Calculate();">

                        </select>-->
                        <?php
                        echo CHtml::DropDownList('', 1,
                            CHtml::listData(CookUnit::model()->findAll(array('order' => 'title')), 'id', 'title'),
                            array('class' => 'nchzn', 'onchange' => 'Calorisator.Calculate();', 'options' => CookUnit::model()->getTypesData())
                        );
                        ?>
                    </span>
                </td>
                <td class="col-4 n3 nutritional" data-value="0" data-n="3">
                    <div class="value">&nbsp;</div>
                </td>
                <td class="col-5 n2 nutritional" data-value="0" data-n="2">
                    <div class="value">&nbsp;</div>
                </td>
                <td class="col-6 n4 nutritional" data-value="0" data-n="4">
                    <div class="value">&nbsp;</div>
                </td>
                <td class="col-7 n1 nutritional" data-value="0" data-n="1">
                    <div class="value">&nbsp;</div>
                </td>
                <td class="col-8"><a href="" class="remove tooltip" title="Удалить" onclick="Calorisator.delRow(event);"></a></td>
            </tr>

            <tr class="add">
                <td class="col-1" colspan="7">
                    <a href="#" class="btn btn-green-medium" onclick="Calorisator.addRow(event);" id="addRow"><span><span>Добавить новый продукт</span></span></a>
                    Вы можете добавлять любое количество продуктов. Просто нажмите на кнопку “Добавить новый продукт"
                </td>
            </tr>
            <tr class="summary results">
                <td class="col-1"></td>
                <td class="col-23" colspan="2">Итого:</td>
                <td class="col-4 nutritional" data-n="3"></td>
                <td class="col-5 nutritional" data-n="2"></td>
                <td class="col-6 nutritional" data-n="4"></td>
                <td class="col-7 nutritional" data-n="1"></td>
            </tr>
            <tr class="summary results100">
                <td class="col-1"></td>
                <td class="col-23" colspan="2">Итого на 100г.:</td>
                <td class="col-4 nutritional" data-n="3"></td>
                <td class="col-5 nutritional" data-n="2"></td>
                <td class="col-6 nutritional" data-n="4"></td>
                <td class="col-7 nutritional" data-n="1"></td>
            </tr>

            </tbody>
        </table>

    </div>

    <div class="wysiwyg-content">

        <h2>Сервис «Счетчик калорий»</h2>

        <p>Этот день открывает массу возможностей, но воспользоваться можно только одной из них, так что придется выбирать, и выбор будет нелегким. К профессиональным разногласиям относитесь спокойно,
            сегодня они являются всего лишь частью нормального рабочего процесса. Даже с руководством можно поспорить от души – и без всяких далеко идущих последствий. </p>

        <p>Этот день открывает массу возможностей, но воспользоваться можно только одной из них, так что придется выбирать, и выбор будет нелегким. К профессиональным разногласиям относитесь спокойно,
            сегодня они являются всего лишь частью нормального рабочего процесса. Даже с руководством можно поспорить от души – и без всяких далеко идущих последствий. </p>

        <p>Этот день открывает массу возможностей, но воспользоваться можно только одной из них, так что придется выбирать, и выбор будет нелегким.</p>

    </div>
    <div style="display:none">
        <?php
        // need to get yii include JUI js file
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array('name' => 't', 'sourceUrl' => Yii::app()->createUrl('cook/calorisator/ac'),));
        ?>
    </div>
</div>