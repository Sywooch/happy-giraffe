<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
?>
<script type="text/javascript">
    $(function() {
        $('.pregnancy-weight-form button').click(function(data){
            $.ajax({
                url: "<?php echo Yii::app()->createUrl("/pregnancyWeight/default/getData") ?>",
                data: $("#pregnant-params-form").serialize(),
                type: "POST",
                success: function(data) {
                    $(".intro-text").hide();
                    $("#result").html(data);
                }
            });

            return false;
        });
    });
</script>
<div class="section-banner" style="margin:0;">

        <img src="/images/section_banner_05.jpg" />

        <div class="pregnancy-weight-form">
            <?php $form=$this->beginWidget('CActiveForm', array(
            	'id'=>'pregnant-params-form',
            	'enableAjaxValidation'=>false,
            ));
            $model = new PregnantParamsForm();
            ?>
                <div class="row">
                    <span>Мой рост:</span>
                    <div class="input-box">
                        <?php echo $form->textField($model, 'height'); ?>
                        <span class="units">см</span>
                    </div>
                </div>
                <div class="row">
                    <span>Мой вес до беременности:</span>
                    <div class="input-box">
                        <?php echo $form->textField($model, 'weight_before'); ?>
                        <span class="units">кг</span>
                    </div>
                </div>
                <img src="/images/pregnancy_weight_form_sep.png" />
                <div class="row">
                    <span>Мой срок беременности:</span>
                    <div class="input-box">
                        <div class="select-box">
                            <div class="select-value" onclick="toggleSelectBox(this);">
                                <span>1</span>
                                <input type="hidden" value="1" name="PregnantParamsForm[week]" id="week"/>
                            </div>
                            <div class="select-list">
                                <ul>
                                    <?php for($i=1;$i<=40;$i++): ?>
                                        <li onclick="setSelectBoxValue(this);"><span><?php echo $i ?></span><input type="hidden" value="<?php echo $i ?>" /></li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
<!--                            --><?php //echo $form->dropDownList($model, 'week', HDate::Range(1, 40)); ?>
                        </div>
                        <span class="units">нед</span>
                    </div>
                </div>
                <div class="row">
                    <span>Сейчас мой вес:</span>
                    <div class="input-box">
                        <?php echo $form->textField($model, 'weight'); ?>
                        <span class="units">кг</span>
                    </div>
                </div>
<!--            --><?php //echo CHtml::ajaxSubmitButton('Submit',$this->createUrl('/pregnancyWeight/default/getData'),array(
//                'type'=>'POST',
//                'success'=>'function(data){
//                    $(".intro-text").hide();
//                    $("#result").html(data);
//                }'
//            )); ?>
                <button>Рассчитать<br/>прибавку</button>
            <?php $this->endWidget(); ?>
        </div>

    </div>

<div class="block-in" id="result">

</div>
