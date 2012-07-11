<?php
/* @var $this Controller
 * @var $name Name
 */
?><div class="left-inner mirror">
    <div class="name_link">
        <a href="<?php echo $this->createUrl('index') ?>">Все имена</a>
        <a href="<?php echo $this->createUrl('index',array('letter'=>$name->GetFirstLetter())) ?>">Имена на букву <?php echo $name->GetFirstLetter() ?></a>
    </div>

    <div class="name_info_right <?php echo ($name->gender == 1)?'boy':'girl' ?>">
        <p class="header first">Значение имени <?php echo $name->name; ?></p>

        <p>"<?php echo $name->translate; ?>"</p>

        <?php if (!empty($name->nameSaintDates)):?>
            <p class="header">Святцы <a href="#" id="calendar-link2" onclick="NameModule.showFirstSaints(this);return false;" class="calendar-link" style="display: none;">только ближайшие</a></p>
            <ul class="calendar">
                <?php $i = 0; ?>
                <?php foreach ($name->nameSaintDates as $saint): ?>
                    <?php if ($i == 5) :?>
                        <li><a href="#" class="calendar-link" onclick="NameModule.showAllSaints(this);return false;">Все святцы</a></li>
                    <?php endif; ?>
                    <li<?php if ($i >= 5) echo ' style="display:none;"' ?>><span><?php echo $saint->day ?></span><?php echo HDate::ruMonth($saint->month) ?></li>
                    <?php $i++ ?>
                <?php endforeach; ?>
            </ul>
        <?php endif ?>

        <div class="clear"></div>
        <p class="header like">Имя нравится</p>

        <p class="heart_like"><?php echo $name->likes; ?></p>

        <div class="clear"></div>
        <?php //$this->renderPartial('_stats',array()); ?>
    </div>
</div>

<div class="right-inner mirror">
    <div class="name_info">
        <h1 class="<?php echo ($name->gender == 1)?'boy':'girl' ?>"><?php echo $name->name; ?></h1>
        <?php if (Yii::app()->user->isGuest):?>
            <a href="#register" class="like_name heart empty_heart fancy" data-theme="white-square"></a>
        <?php else: ?>
            <a rel="<?php echo $name->id ?>" href="#" onclick="return NameModule.like(this);"
               class="like_name heart <?php if (!$name->isUserLike(Yii::app()->user->id)) echo 'empty_heart' ?>"></a>
        <?php endif ?>

        <p class="name">Имя: <span class="<?php echo ($name->gender == 1)?'boy':'girl' ?>">
            <?php echo ($name->gender == 1)?'мужское':'женское' ?></span></p>

    <?php if (!empty($name->options) || !empty($name->sweet)):?>
        <div class="plashka">
            <?php if (!empty($name->options)):?>
                <p><span>Варианты имени <?php echo $name->name; ?>:</span> <?php echo $name->options; ?></p>
            <?php endif ?>
            <?php if (!empty($name->sweet)):?>
                <p><span>Ласковое обращение <?php echo $name->name; ?>:</span> <?php echo $name->sweet; ?></p>
            <?php endif ?>
        </div>
    <?php endif ?>

        <?php if (!empty($name->description)):?>
            <h2>Характеристика имени <?php echo $name->name; ?></h2>

            <p><?php echo $name->description ?></p>
        <?php endif ?>

        <?php if (!empty($name->middle_names)):?>
            <h2>Подходящие отчества к имени <?php echo $name->name; ?></h2>

            <p><?php echo $name->middle_names ?></p>

        <?php endif ?>


        <?php //if (!empty($name->saints)):?>
<!--            <h2>Христианские святые с именем --><?php //echo $name->name; ?><!--</h2>-->
<!---->
<!--            <p>--><?php //echo $name->saints ?><!--</p>-->
        <?php //endif ?>

        <?php if (!empty($name->famous)):?>
            <h2>Известные личности с именем <?php echo $name->name; ?></h2>
        <?php $i = 0; ?>
            <div class="clearfix">
            <?php foreach ($name->famous as $famous): ?>
                <?php $i++; ?>
                <div class="best_person">
                    <?php if (!empty($famous->photo)) echo CHtml::image($famous->GetUrl()) ?>
                    <?php if (!empty($famous->link)): ?>
                        <a href="<?php echo $famous->link ?>" rel="nofollow"><?php echo CHtml::encode($name->name).' '.CHtml::encode($famous->last_name); ?>
                            <?php if (!empty($famous->description)) echo ', '.$famous->description ?></a>
                    <?php else: ?>
                        <p><?php echo CHtml::encode($name->name).' '.CHtml::encode($famous->last_name); ?>
                            <?php if (!empty($famous->description)) echo ', '.$famous->description ?></p>
                    <?php endif ?>
                </div>
                <?php if ($i % 3 == 0) echo '</div><div class="clearfix">' ?>
            <?php endforeach; ?>
            </div>
        <?php endif ?>

    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('.diagram_navi a').click(function(){
            return false;
        });
    });
</script>