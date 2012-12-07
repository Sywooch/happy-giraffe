<?php
/* @var $this HController
 * @var $form CActiveForm
 */

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/blood_group.js', CClientScript::POS_HEAD);

?><div class="child_sex_blood_banner">
    <form action="">
        <div class="man_blood">II Rh(+)</div>
        <!-- .man_blood -->
        <div class="woman_blood">I Rh(-)</div>
        <!-- .woman_blood -->
        <div class="gr_bl man_bl">
            <span>Группа крови отца:</span>

            <div class="ch_group">
                <ul>
                    <li><a href="#">I</a></li>
                    <li><a href="#">II</a></li>
                    <li><a href="#">III</a></li>
                    <li><a href="#">IV</a></li>
                </ul>
                <?php echo CHtml::hiddenField('father_blood_group', '', array('id' => 'father_blood_group')) ?>
            </div>
            <div style="display: none;" id="man_bl_em_" class="errorMessage">Выберите группу крови отца</div>
            <!-- .ch_group -->
        </div>
        <!-- .gr_bl -->
        <div class="gr_bl woman_bl">
            <span>Группа крови матери:</span>

            <div class="ch_group">
                <ul>
                    <li><a href="#">I</a></li>
                    <li><a href="#">II</a></li>
                    <li><a href="#">III</a></li>
                    <li><a href="#">IV</a></li>
                </ul>
                <?php echo CHtml::hiddenField('mother_blood_group', '', array('id' => 'mother_blood_group')) ?>
            </div>
            <div style="display: none;" id="woman_bl_em_" class="errorMessage">Выберите группу крови матери</div>
            <!-- .ch_group -->
        </div>
        <!-- .gr_bl -->
        <input type="button" class="calc_grey" value="Рассчитать"/>
    </form>
</div><!-- .child_sex_blood_banner -->

<div class="wh_wait wh_daughter" style="display: none;">
    <div class="img-box">
        <img src="/images/baby_girl.jpg">
    </div>
    <div class="text">
        <span class="title_wh_wait">Поздравляем! У вас будет девочка!</span>

        <p>Об этом говорят ваши группы крови и резус-факторы. Метод имеет точность невысокую – чуть больше 50%. На
            результаты влияют переливания крови, введение сывороток и препаратов крови. Поэтому рождение девочки не
            гарантировано.</p>
    </div>
</div>
<div class="wh_wait wh_son" style="display: none;">
    <div class="img-box">
        <img src="/images/baby_boy.jpg">
    </div>
    <div class="text">
        <span class="title_wh_wait">Поздравляем! У вас будет мальчик!</span>

        <p>Именно об этом говорит сочетание групп крови. На результаты влияет введение в
            организм
            любого из родителей любых препаратов крови. Поэтому точность метода чуть выше 50% и рождение мальчика не
            гарантировано.</p>
    </div>
</div>

<?php $this->widget('application.widgets.serviceSocial.serviceSocialWidget', array(
    'service' => $service,
    'image' => '/images/sex_child_blood.jpg',
    'description' => 'Согласно этому методу, если у отца группа крови 1-я или 3-я, а у мамы – 1-я, то высока вероятность рождения девочки...'
)); ?>

<br><br>
<div class="wysiwyg-content">
    <h1>Пол ребенка по группе крови родителей</h1>
    <p>Уже стало хорошей традицией планирование пола малыша. Будущие мамы честно высчитывают даты, считают месяцы и едят
        определенный вид пищи, но 100%-ную гарантию не дает ни один из данных методов. Но, как говорится, «попробовать
        можно», и в ход идут все возможные методы, одним из которых является метод планирования пола будущего малыша,
        исходя из совместимости групп крови мужчины и женщины.</p>

    <p>Согласно этому методу, если у отца группа крови 1-я или 3-я, а у мамы – 1-я, то высока вероятность рождения
        девочки. Если у будущего папы 2-я либо 4-я группа крови, а у мамы – 1-я, то родится мальчик. Достаточно часто
        мальчики рождаются, если группа крови отца 1-я либо 3-я, а у мамы 2-я. У женщин со 2-ой группой крови девочки
        рождаются, если у папы ребенка 2-я или 4-я группа крови. У женщины, имеющей 3-ю группу крови, может родиться
        девочка, если у папы 1-я группа, в иных случаях у женщин с 3-ей группой крови рождаются мальчики.</p>

    <p>Метод кажется вам сложным? Слегка запутались? Вы можете не запоминать эти витиеватые «если» и «то» – в наш сервис
        уже заложены все возможные варианты.</p>

    <p>Конечно, реальность не всегда совпадает с прогнозируемым результатом, в общем, это и не важно. Ведь любить свою
        новорожденную кроху дочку вы будете не меньше, чем планируемого мальчика.</p>
</div>