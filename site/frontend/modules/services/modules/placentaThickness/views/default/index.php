<?php
/* @var $model PlacentaThicknessForm
 * @var $form CActiveForm
 */

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
$this->meta_description = 'Вы были на УЗИ и в результатах исследования прочитали, какая у вас толщина плаценты, а теперь вас мучает вопрос: это норма или нет? Воспользуйтесь нашим сервисом – и через пару минут вам всё станет ясно';

?><div class="col-white-hoar">
    <div id="baby">
        <div class="placenta_about">
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
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'action' => '#',
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => false,
                    'validateOnType' => false,
                    'validationUrl' => $this->createUrl('default/calculate'),
                    'afterValidate' => "js:function(form, data, hasError) {
                                        if (!hasError)
                                            placentaThickness.calc();
                                        return false;
                                      }",
                )));?>

                <div class="row">
                    <span>Мой срок беременности:</span>

                    <div class="input-box">
                        <?php echo $form->dropDownList($model, 'week', HDate::Range(7, 40), array('class' => 'chzn pregnancy_term', 'empty'=>'-')) ?>
                        <span class="units">нед</span>
                        <?php echo $form->error($model, 'week'); ?>
                    </div>
                </div>
                <div class="row">
                    <span>Толщина плаценты:</span>

                    <div class="input-box">
                        <?php echo $form->textField($model, 'thickness') ?>
                        <span class="units">мм</span>
                        <div><?php echo $form->error($model, 'thickness') ?></div>
                    </div>
                </div>
                <input type="submit" class="placenta_submit" value="Определить"/>
                <?php $this->endWidget(); ?>
            </div>
            <!-- .placenta_calculation -->
        </div><!-- .placenta_about -->
        <div id="result">

        </div>
        <div class="wysiwyg-content margin-20">
            <h2 class="h2-services">Это важное детское место – плацента</h2>

            <p>Слово «плацента» переводится с латыни как «лепешка». По форме она действительно её напоминает. Второе название
                плаценты – «детское место», так как в ней происходит взаимодействие организмов матери и плода.</p>

            <h3>Плацента очень важна</h3>
            <ul>
                <li>Она осуществляет газообмен между организмами плода и матери: кислород поступает плоду, а углекислый газ
                    возвращается в материнский кровоток.
                </li>
                <li>Через неё плод получает все питательные вещества, а продукты его жизнедеятельности возвращаются матери.</li>
                <li>Плацента имеет значение для иммунной защиты плода.</li>
                <li>Плацента выполняет барьерную функцию: через неё не могут проходить антитела матери, некоторые лекарства и
                    токсины. Однако вирусы, никотин, алкоголь и наркотические средства она не задерживает.
                </li>
                <li>Плацента синтезирует гормоны, которые важны для правильного течения беременности.</li>
            </ul>

            <p>Учитывая важную роль плаценты для сохранения беременности и развития плода, акушеры-гинекологи пристально следят
                за её состоянием по нескольким параметрам.</p>
            <ol>
                <li>
                    <i>Степень зрелости</i><br>
                    <span
                        style="margin-left: 20px;">До 27-й недели беременности плацента имеет обычно нулевую степень зрелости.</span><br>
                    <span style="margin-left: 20px;">С 27-й недели плацента может быть первой степени.</span><br>
                    <span style="margin-left: 20px;">С 32-34-й недели – второй степени.</span><br>
                    <span style="margin-left: 20px;">С 37-й недели – третьей.</span><br>
                    <span style="margin-left: 20px;">Степень зрелости может быть меньше, чем положено по сроку, – ничего страшного в этом нет.</span><br>
                    В конце беременности плацента «стареет» – площадь обменной поверхности уменьшается, начинают появляться
                    участки отложения солей.
                </li>
                <li>
                    <i>Место прикрепления плаценты может быть любым, чаще она локализуется на задней поверхности матки.</i>
                </li>
                <li>
                    <i>Толщина плаценты определяется при проведении УЗИ.</i> В России толщина плаценты с 20-й недели составляет
                    в норме
                    от 20 до 40 миллиметров, в некоторых странах эти границы шире – от 15 до 50 миллиметров. До 20-й недели
                    беременности плаценту целенаправленно не исследуют, о ней говорят, только если имеется выраженная патология
                    – кровотечение или задержка развития плода. После 20-й недели на УЗИ обязательно отмечают состояние плаценты
                    и её толщину.
                </li>
            </ol>
            <div class="brushed">
                <p style="font-style: italic;font-weight: bold;margin-top:0;">Наш сервис даёт возможность определить
                    соответствие толщины
                    плаценты сроку вашей беременности и проверить: всё в норме или стоит более внимательно отнестись к своему
                    здоровью?</p>

                <p>Для этого нужно ввести срок беременности и толщину плаценты (данные можно посмотреть в описании последнего
                    УЗИ) и
                    нажать кнопку «Определить». Через секунду вы получите результат и узнаете, соответствует ли ваша плацента
                    норме,
                    а также прочитаете рекомендации по дальнейшим действиям. Удачи!</p>
            </div>
        </div><!-- .placenta_article -->
    </div>
</div>