<?php
/* @var $model PlacentaThicknessForm
 * @var $form CActiveForm
 */

$js = '$("#placenta-thickness-form input.placenta_submit").click(function(){
            $.ajax({
                url: "' . Yii::app()->createUrl("/placentaThickness/default/calculate") . '",
                data: $("#placenta-thickness-form").serialize(),
                type: "POST",
                success: function(data) {
                    $("#result").html(data);
                }
            });
            return false;
        });';
Yii::app()->clientScript->registerScript('placenta-thickness', $js);
?>

<div class="placenta_about">
    <span class="placenta_bann"><img src="/images/placenta_bann.jpg" alt="" title=""/></span>

    <div class="proff_say">
        <div class="about_proff">
            <img src="/images/demidov.png" alt="" title=""/>
            <span><b>Демидов</b> Владимир Николаевич</span>
            Доктор медицинских наук, профессор. Основоположник ультразвуковой и перинатальной диагностики в СССР.
        </div>
        <!-- .about_proff -->
        <div class="proff_txt">
            <div class="rarr_say"></div>
            <!-- .rarr_say -->
            <span><ins>При физиологически протекающей беременности толщина плаценты постоянно увеличивается в линейной
                зависимости от 10,9 мм в 7 неделю до 35,6 мм в 36 неделю беременности.
            </ins></span>
        </div>
        <!-- .proff_txt -->
    </div>
    <!-- .proff_say -->
    <span class="title_part_placent">Определите, <ins>в норме ли Ваши показатели<br/> толщины плаценты
    </ins> на данном<br/> сроке беременности</span>

    <div class="placenta_calculation">
        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'placenta-thickness-form',
        'enableAjaxValidation' => false,
    ));?>

        <div class="row">
            <span>Мой срок беременности:</span>

            <div class="input-box">
                <div class="select-box">
                    <div class="select-value" onclick="toggleSelectBox(this);"><span>20</span>
                        <input name="PlacentaThicknessForm[week]" type="hidden" value="20"/>
                    </div>
                    <div class="select-list">
                        <ul>
                            <li onclick="setSelectBoxValue(this);"><span>7</span><input type="hidden" value="7"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>8</span><input type="hidden" value="8"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>9</span><input type="hidden" value="9"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>10</span><input type="hidden" value="10"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>11</span><input type="hidden" value="11"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>12</span><input type="hidden" value="12"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>13</span><input type="hidden" value="13"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>14</span><input type="hidden" value="14"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>15</span><input type="hidden" value="15"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>16</span><input type="hidden" value="16"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>17</span><input type="hidden" value="17"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>18</span><input type="hidden" value="18"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>19</span><input type="hidden" value="19"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>20</span><input type="hidden" value="20"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>21</span><input type="hidden" value="21"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>22</span><input type="hidden" value="22"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>23</span><input type="hidden" value="23"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>24</span><input type="hidden" value="24"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>25</span><input type="hidden" value="25"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>26</span><input type="hidden" value="26"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>27</span><input type="hidden" value="27"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>28</span><input type="hidden" value="28"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>29</span><input type="hidden" value="29"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>30</span><input type="hidden" value="30"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>31</span><input type="hidden" value="31"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>32</span><input type="hidden" value="32"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>33</span><input type="hidden" value="33"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>34</span><input type="hidden" value="34"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>35</span><input type="hidden" value="35"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>36</span><input type="hidden" value="36"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>37</span><input type="hidden" value="37"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>38</span><input type="hidden" value="38"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>39</span><input type="hidden" value="39"/></li>
                            <li onclick="setSelectBoxValue(this);"><span>40</span><input type="hidden" value="40"/></li>
                        </ul>
                    </div>
                </div>
                <span class="units">нед</span>
            </div>
            <span class="comm_to">Укажите срок беременности<br/>(диапазон 20-40 недель)</span>
        </div>
        <div class="row">
            <span>Толщина плаценты:</span>

            <div class="input-box">
                <?php echo $form->textField($model, 'thickness') ?>
                <span class="units">мм</span>
            </div>
            <div><?php echo $form->error($model, 'thickness') ?></div>
            <span class="comm_to">Введите целое или дробное число,<br/>например 25 или 25,37</span>
        </div>
        <input type="button" class="placenta_submit" value="Определить"/>
        <?php $this->endWidget(); ?>
    </div>
    <!-- .placenta_calculation -->
</div><!-- .placenta_about -->
<div id="result">

</div>
<div class="placenta_article">
    <span class="article_title">Толщина плаценты бла бла бла</span>

    <p>Наступление беременности сопровождается значительными изменениями в организме женщины. Это и понятно: теперь ему
        приходится работать, как говорят в народе, «за двоих». Увеличивается слой подкожно-жировой клетчатки, которая
        является своеобразным «депо» воды, питательных веществ и витаминов для благополучного развития ребенка. Но это
        не единственный фактор, влияющий на вес во время беременности. Рассмотрим данный вопрос подробнее.<br/>Вес при
        беременности увеличивается, потому что:</p>
    <ul>
        <li>
            <ins>*</ins>
            растет плодное яйцо (плод + плодные оболочки),
        </li>
        <li>
            <ins>*</ins>
            развивается плацента,
        </li>
        <li>
            <ins>*</ins>
            увеличивается вес и размеры матки (как собственно мышечной ткани, так и околоплодных вод),
        </li>
        <li>
            <ins>*</ins>
            изменяется толщина подкожно-жирового слоя,
        </li>
        <li>
            <ins>*</ins>
            увеличиваются молочные железы.
        </li>
    </ul>
    <p>На вес при беременности влияют:</p>
    <ul>
        <li>
            <ins>*</ins>
            Возраст: чем старше женщина, тем больший вес во время беременности она набирает.
        </li>
        <li>
            <ins>*</ins>
            Самочувствие. При токсикозе на раннем сроке и частой рвоте женщина может похудеть, а при токсикозе на
            последних месяцах беременности, сопровождающемся нефропатией и отеками, вес быстро нарастает.
        </li>
        <li>
            <ins>*</ins>
            Многоплодная беременность – понятно, что два или три ребенка весят больше, чем один.
        </li>
        <li>
            <ins>*</ins>
            Патологическое течение беременности, например многоводие при внутриутробных инфекциях или отеки при
            сопутствующих заболеваниях почек.
        </li>
        <li>
            <ins>*</ins>
            Индекс массы тела (ИМТ) до беременности. ИМТ – это отношение веса женщины в килограммах к квадрату ее роста
            в метрах. Чем меньше ИМТ, тем обычно больше прибавка веса
        </li>
    </ul>
    <p>Существуют ли стандарты набора веса при беременности?</p>

    <p>Да, существуют. Однако нужно помнить: набор веса беременными индивидуален и зависит от многих факторов. Очевидно,
        что полная женщина и совсем худенькая, крупная и миниатюрная наберут разное количество килограммов. Поэтому вес
        во время беременности оценивают по специальным таблицам, опираясь на ИМТ.<br/>Чем опасна низкая прибавка веса?
    </p>

    <p>Малый набор массы тела при беременности опасен тем, что ребенок будет получать недостаточное количество
        питательных веществ и начнет отставать в своем развитии.</p>
</div><!-- .placenta_article -->