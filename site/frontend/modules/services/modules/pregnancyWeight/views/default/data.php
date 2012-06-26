<?php
/* @var $this Controller
 * @var $model PregnantParamsForm
 */
?>

<div class="pregnancy-weight-summary">
    <div class="block-in" id="recommend">
        <div class="box-left">
            <div class="img-box">
                <?php if ($model->weight > $model->max_weight): ?>
                    <img src="/images/img_pregnancy_weight_gt.png" />
                    <span>+<?php echo round(($model->weight - $model->recommend_gain*0.1 - $model->recommend_weight),1) ?></span>
                <?php elseif ($model->weight < $model->min_weight): ?>
                    <img src="/images/img_pregnancy_weight_lt.png" />
                    <span>-<?php echo round(($model->recommend_weight - $model->weight - $model->recommend_gain*0.1),1) ?></span>
                <?php else: ?>
                    <img src="/images/img_pregnancy_weight_e.png" />
                <?php endif ?>
            </div>

            <?php if ($model->weight > $model->max_weight): ?>
                <div class="summary-text">Ваш вес <span>></span> нормы</div>
            <?php elseif ($model->weight < $model->min_weight): ?>
                <div class="summary-text">Ваш вес <span><</span> нормы</div>
            <?php else: ?>
                <div class="summary-text">Ваш вес в норме</div>
            <?php endif ?>
            <div class="summary-weight"><?php echo $model->normal_weight ?><span>кг</span></div>
        </div>
        <div class="box-main">

            <?php if ($model->weight > $model->max_weight): ?>
                <big>Ваш вес выше нормы</big>
                <p>Ваш вес выше нормы. Это может быть по нескольким причинам:</p>
                <ul style="list-style-type: decimal;padding-left: 40px;">
                    <li>Вы изначально имели вес ниже нормы, а сейчас набрали больше, компенсируя его дефицит</li>
                    <li>Ваш ребёнок обещает родиться крупнее сверстников</li>
                    <li>У Вас многоплодная беременность</li>
                    <li>Вы не можете устоять перед мучным и сладким и едите гораздо больше, чем обычно. Нужно вернуться к обычному режиму питания, с перевесом овощей и фруктов</li>
                    <li>Вы любите солёное, и Ваши почки не справляются с повышенной нагрузкой. В этом случае нужно уменьшить количество потребляемой соли</li>
                    <li>У Вас есть отёки. Они могут быть и скрытыми. Нужно обратиться к врачу</li>
                    <li>У Вас многоводие. Нужно обратиться к врачу и сделать УЗИ.</li>
                </ul>
            <?php elseif ($model->weight < $model->min_weight): ?>
                <big>Ваш вес ниже нормы</big>
                <ul style="list-style-type: decimal;padding-left: 20px;">
                    <li>Вы изначально имели повышенный вес, а сейчас просто организм использует жировые запасы для своих целей</li>
                    <li>Ваш ребёнок обещает родиться небольшим, как кто-то из родителей</li>
                    <li>Вы мало пьёте жидкости. Нужно употреблять столько, сколько необходимо с учётом климата и погоды</li>
                    <li>У Вас токсикоз с частой рвотой и резким снижением аппетита. Необходимо обратиться к врачу</li>
                    <li>Ваш ребёнок развивается медленнее, чем нужно. Необходимо обратиться к врачу</li>
                    <li>У Вас маловодие. Нужно обратиться к врачу и сделать УЗИ</li>
                </ul>
            <?php else: ?>
                <big>Ваш вес в норме</big>
                <p>Ваш вес в норме. Так держать!</p>
                <p>Вы прекрасно знаете, что во время беременности главное – физическая активность и сбалансированное питание. Продолжайте гулять в любую погоду не менее двух часов в день и заниматься гимнастикой или йогой для беременных.</p>
                <p>Не забывайте употреблять достаточное количество овощей, фруктов, рыбы и мяса. Солонку можно отставить подальше, так как недосол при беременности является прекрасной профилактикой возможных отёков. И пусть каждый день приносит Вам радость!</p>
            <?php endif ?>
            <br/>
            <a href="#" onclick="return pregnancyWeight.toWeight()">Таблица нормальной прибавки вашего веса при беременности</a>
        </div>
    </div>

    <div class="pregnancy-weight-summary" id="weight-table" style="display: none;">
        <div class="block-in">
            <div class="weight-table">
                <big>Таблица Вашего веса при беременности (нед / кг)</big>
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <table>
                            <?php for($i=1;$i<=40;$i++): ?>
                                    <tr<?php if ($i == $model->week) echo ' class="active"' ?>>
                                        <td class="col-1"><?php echo $i ?></td>
                                        <td class="col-2"><?php echo $model->data[$i] ?></td>
                                    </tr>
                            <?php if ($i % 10 == 0 && $i < 40):?>
                                </table>
                            </td>
                            <td>
                                <table>
                            <?php endif ?>
                            <?php endfor; ?>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a href="#" onclick="return pregnancyWeight.toRecommend()">Рекомендации для Вашего веса</a>
            </div>
        </div>
    </div>
</div>