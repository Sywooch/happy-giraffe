<?php
/* @var $this Controller
 * @var $name Name
 */
?>
<script type="text/javascript">
    $(function() {
        $('.diagram_navi a').click(function(){

            return false;
        });
    });
</script>
<div class="left-inner mirror">
    <div class="name_link">
        <a href="<?php echo $this->createUrl('/names/default/index') ?>">Все имена</a>
        <a href="<?php echo $this->createUrl('/names/default/index',array('letter'=>$name->GetFirstLetter())) ?>">Имена на букву А</a>
    </div>

    <div class="name_info_right <?php echo ($name->gender == 1)?'boy':'girl' ?>">
        <p class="header first">Значение имени <?php echo $name->name; ?></p>

        <p>"<?php echo $name->translate; ?>"</p>

        <?php if (!empty($name->nameSaintDates)):?>
            <p class="header">Святцы</p>
            <ul class="calendar">
                <?php foreach ($name->nameSaintDates as $saint): ?>
                    <li><span><?php echo $saint->day ?></span><?php echo HDate::ruMonth($saint->month) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif ?>

        <div class="clear"></div>
        <p class="header like">Имя нравится</p>

        <p class="heart_like"><?php echo $name->likes; ?></p>

        <div class="clear"></div>
        <?php $this->renderPartial('_stats',array()); ?>
    </div>
</div>

<div class="right-inner mirror">
    <div class="name_info">
        <h1 class="<?php echo ($name->gender == 1)?'boy':'girl' ?>"><?php echo $name->name; ?></h1>
        <a rel="<?php echo $name->id ?>" href="#"
           class="like_name heart <?php if (!$name->isUserLike(Yii::app()->user->getId())) echo 'empty_heart' ?>"></a>

        <p class="name">Имя: <span class="<?php echo ($name->gender == 1)?'boy':'girl' ?>">
            <?php echo ($name->gender == 1)?'мужское':'женское' ?></span></p>

        <div class="plashka">
            <p class="variants">Варианты имени <?php echo $name->name; ?>, ласковое обращение</p>

            <p><span>Варианты имени <?php echo $name->name; ?>:</span> <?php echo $name->options; ?></p>
            <p><span>Ласковое обращение <?php echo $name->name; ?>:</span> <?php echo $name->sweet; ?></p>
        </div>

        <h2>Характеристика имени <?php echo $name->name; ?></h2>

        <p><span>Характеристика имени <?php echo $name->name; ?>:</span> <?php echo $name->description ?></p>

        <h2>Подходящие отчества к имени <?php echo $name->name; ?></h2>

        <p><span>Подходящие отчества к имени <?php echo $name->name; ?>:</span> <?php echo $name->middle_names ?></p>

        <h2>Христианские святые с именем <?php echo $name->name; ?></h2>

        <p><span>Христианские святые с именем <?php echo $name->name; ?>:</span> <?php echo $name->saints ?></p>

        <h2>Известные личности с именем <?php echo $name->name; ?></h2>

        <?php foreach ($name->nameFamouses as $famous): ?>
            <div class="best_person">
                <?php if (!empty($famous->photo)) $famous->GetAdminPhoto() ?>
                <a href="#" onclick="return false;"><?php echo $name->name.' '.$famous->last_name ?></a>
            </div>
        <?php endforeach; ?>

    </div>
</div>

