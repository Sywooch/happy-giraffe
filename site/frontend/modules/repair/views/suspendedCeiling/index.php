<div id="repair-ceiling">

    <div class="form">

        <div class="title">
            <h1>Расчет количества обоев</h1>
            <span>ПОДВЕСНОГО ПОТОЛКА</span>
            <p>Калькулятор поможет Вам рассчитать cколько надо материалов (потолочной плитки, реек, подвесов) для плиточного подвесного потолка.</p>
        </div>

        <div class="form-in">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'SuspendedCeiling-calculate-form',
                'action' => $this->createUrl('suspendedCeiling/calculate'),
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => false,
                    'validateOnType' => false,
                    'validationUrl' => $this->createUrl('suspendedCeiling/calculate'),
                    'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    SuspendedCeiling.Calculate();
                                return false;
                              }",
                )));
            ?>

            <?php echo $form->errorSummary($SuspendedCeilingModel); ?>

            <div class="row">

                <big>Площадь потолка</big> <?php echo $form->textField($SuspendedCeilingModel, 'area') ?> <b>м</b><sup>2</sup>

                <div class="small"><span>Потолочная плитка</span>
                    <?php echo $form->dropDownList($SuspendedCeilingModel, 'plate', $SuspendedCeilingModel->plateTypes, array('class'=>'chzn')) ?>
                </div>

            </div>

            <div class="row row-btn">
                <button>Рассчитать</button>
                <?php echo CHtml::submitButton('Рассчитать', array('id'=>'test')); ?>
            </div>

            <?php $this->endWidget(); ?>

            <div class="row row-result">

                <div class="title">Материалов потребуется</div>

                <ul>
                    <li>
                        <span class="count">84&nbsp; шт.</span>
                        <span>Потолочная плитка</span>
                    </li>
                    <li>
                        <span class="count">15&nbsp; шт.</span>
                        <span>Подвес</span>
                    </li>
                    <li>
                        <span class="count">5&nbsp; шт.</span>
                        <span>Рейка - 3 м</span>
                    </li>
                    <li>
                        <span class="count">6&nbsp; шт.</span>
                        <span>Рейка несущая - 3.6 м</span>
                    </li>
                    <li>
                        <span class="count">39&nbsp; шт.</span>
                        <span>Рейка - 0.6 м</span>
                    </li>
                    <li>
                        <span class="count">39&nbsp; шт.</span>
                        <span>Рейка - 1.2 м</span>
                    </li>
                </ul>

                <div style="text-align:right;"><a href="" class="pseudo">Прочитать рекомендации</a></div>

            </div>



        </div>

    </div>

    <div class="recommendation clearfix">

        <p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам. Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из нескольких показателей: вес ребенка, матки, околоплодных вод, плаценты, а также увеличиваются</p>

    </div>

    <div class="wysiwyg-content">

        <h3>Сервис «Когда уходить в декрет»</h3>

        <p>Наступление беременности сопровождается значительными изменениями в организме женщины. Это и понятно: теперь ему приходится работать, как говорят в народе, «за двоих». Увеличивается слой подкожно-жировой клетчатки, которая является своеобразным «депо» воды, питательных веществ и витаминов для благополучного развития ребенка. Но это не единственный фактор, влияющий на вес во время беременности. Рассмотрим данный вопрос подробнее.<br/>
            Вес при беременности увеличивается, потому что:</p>

        <ul>
            <li>растет плодное яйцо (плод + плодные оболочки),</li>
            <li>развивается плацента,</li>
            <li>увеличивается вес и размеры матки (как собственно мышечной ткани, так и околоплодных вод),</li>
            <li>изменяется толщина подкожно-жирового слоя,</li>
            <li>увеличиваются молочные железы.</li>
        </ul>

        <p>На вес при беременности влияют:</p>

        <ul>
            <li>Возраст: чем старше женщина, тем больший вес во время беременности она набирает.</li>
            <li>Самочувствие. При токсикозе на раннем сроке и частой рвоте женщина может похудеть, а при токсикозе на последних месяцах беременности, сопровождающемся нефропатией и отеками, вес быстро нарастает.</li>
            <li>Многоплодная беременность – понятно, что два или три ребенка весят больше, чем один.</li>
            <li>Патологическое течение беременности, например многоводие при внутриутробных инфекциях или отеки при сопутствующих заболеваниях почек.</li>
            <li>Индекс массы тела (ИМТ) до беременности. ИМТ – это отношение веса женщины в килограммах к квадрату ее роста в метрах. Чем меньше ИМТ, тем обычно больше прибавка веса.</li>
        </ul>

        <p>Существуют ли стандарты набора веса при беременности?</p>

        <p>Да, существуют. Однако нужно помнить: набор веса беременными индивидуален и зависит от многих факторов. Очевидно, что полная женщина и совсем худенькая, крупная и миниатюрная наберут разное количество килограммов. Поэтому вес во время беременности оценивают по специальным таблицам, опираясь на ИМТ.<br/>
            Чем опасна низкая прибавка веса?</p>

        <p>Малый набор массы тела при беременности опасен тем, что ребенок будет получать недостаточное количество питательных веществ и начнет отставать в своем развитии.</p>

        <p>Не секрет, что каждый день внутриутробного развития очень важен для малыша, и любая задержка негативно скажется на его здоровье.</p>
    </div>

</div>