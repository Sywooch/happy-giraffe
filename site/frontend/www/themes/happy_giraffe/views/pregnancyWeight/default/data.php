<?php
/* @var $this Controller
 * @var $recommend_weight int
 * @var $data array
 * @var $gain float
 * @var $model PregnantParamsForm
 */
?>
<script type="text/javascript">
    $(function () {
        $('body').delegate('.go-weight-table', 'click', function () {
            $('#recommend').hide();
            $('#weight-table').show();
            return false;
        });
        $('body').delegate('.go-recommend-table', 'click', function () {
            $('#recommend').show();
            $('#weight-table').hide();
            return false;
        });
    });
</script>

<div class="pregnancy-weight-summary">
    <div class="block-in" id="recommend">
        <div class="box-left">
            <div class="img-box">
                <?php if (($model->weight - $gain*0.1) > $recommend_weight): ?>
                    <img src="/images/img_pregnancy_weight_gt.png" />
                    <span>+<?php echo round(($model->weight - $gain*0.1 - $recommend_weight),1) ?></span>
                <?php else: ?>
                    <?php if (($model->weight + $gain*0.1) < $recommend_weight): ?>
                        <img src="/images/img_pregnancy_weight_lt.png" />
                        <span>-<?php echo round(($recommend_weight - $model->weight - $gain*0.1),1) ?></span>
                        <?php else: ?>
                            <img src="/images/img_pregnancy_weight_e.png" />
                    <?php endif ?>
                <?php endif ?>
            </div>

            <?php if (($model->weight - $gain*0.1) > $recommend_weight): ?>
                <div class="summary-text">Ваш вес <span>></span> нормы</div>
            <?php else: ?>
                <?php if (($model->weight + $gain*0.1) < $recommend_weight): ?>
                    <div class="summary-text">Ваш вес <span><</span> нормы</div>
                    <?php else: ?>
                        <div class="summary-text">Ваш вес в норме</div>
                <?php endif ?>
            <?php endif ?>
            <div class="summary-weight"><?php echo round($recommend_weight - $gain*0.1).'-'.round($recommend_weight + $gain*0.1) ?><span>кг</span></div>
        </div>
        <div class="box-main">
            <big>Рекомендации:</big>
            <p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам. Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из нескольких показателей: вес ребенка, матки, околоплодных вод, плаценты, а также увеличиваются молочные железы, объем циркулирующей крови, ну и, конечно, появляется запас жировой ткани. Желательно, чтобы набор веса при беременности происходил постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности происходил постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности происходил постепенно.</p>
            <br/>
            <?php echo CHtml::link('Таблица вашего веса при беременности', '#', array('class' => 'go-weight-table')); ?>
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
                                    <tr>
                                        <td class="col-1"><?php echo $i ?></td>
                                        <td class="col-2"><?php echo $data[$i] ?></td>
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
                <?php echo CHtml::link('Рекомендации для Вашего веса', '#', array('class' => 'go-recommend-table')); ?>
            </div>
        </div>
    </div>
</div>

<div style="display: none;">
    <div>Норма : <?php echo $recommend_weight ?> кг.</div>
    <?php if ($model->weight - 1 > $recommend_weight): ?>
    <div>Ваш вес больше нормы на <?php echo ($model->weight - 1 - $recommend_weight) ?> кг.</div>
    <?php else: ?>
    <?php if ($model->weight + 1 < $recommend_weight): ?>
        <div>Ваш вес меньше нормы на <?php echo ($recommend_weight - $model->weight - 1) ?> кг.</div>
        <?php else: ?>
        <div>Ваш вес в пределах нормы</div>
        <?php endif ?>
    <?php endif ?>

    <?php echo CHtml::link('Таблица вашего веса при беременности', '#', array('class' => 'go-weight-table')); ?>
</div>
<div style="display: none;">
    <table><?php var_dump($data) ?></table>
    <?php echo CHtml::link('Таблица вашего веса при беременности', '#', array('class' => 'go-recommend-table')); ?>
</div>