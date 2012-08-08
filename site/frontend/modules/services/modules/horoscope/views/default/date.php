<?php $time = strtotime($model->date);?>
<div class="horoscope-one">

    <div class="block-in">

        <h1><?=$this->title ?></h1>

        <div class="img">

            <div class="in"><img src="/images/widget/horoscope/big/<?=$model->zodiac ?>.png"></div>
            <div class="date"><span><?=$model->zodiacText() ?></span><?=$model->zodiacDates() ?></div>

        </div>

        <div class="dates">
            <?php $this->renderPartial('_forecast_menu',array('model'=>$model))?>
        </div>

        <div class="text clearfix">
            <div class="date">
                <?php if (!empty($model->date)):?>
                    <?=date("j", strtotime($model->date)) ?>
                    <br>
                    <?=Yii::app()->dateFormatter->format('MMM',strtotime($model->date))?>
                <?php else: ?>
                    <?php if (!empty($model->month)):?>
                        <?=Yii::app()->dateFormatter->format('MMM',strtotime($model->month))?>
                    <?php else: ?>
                        <?=$model->year  ?>
                    <?php endif ?>
                <?php endif ?>
            </div>
            <?=Str::strToParagraph($model->text) ?>
        </div>

        <div class="socials">

            <noindex>
                <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
                'model' => $model,
                'type' => '3_btns',
                'options' => array(
                    'title' => CHtml::encode($this->title),
                    'image' => '/images/widget/horoscope/big/'.$model->zodiac.'.jpg',
                    'description' => Str::truncate($model->text, 250),
                ),
            )); ?>
            </noindex>

        </div>

    </div>

</div>

<?php $this->renderPartial('_bottom_list',array('model'=>$model)); ?>

<div class="wysiwyg-content">

    <?=HoroscopeText::getText($model); ?>

</div>
