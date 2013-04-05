<?php
$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript
    ->registerScriptFile($baseUrl . '/main.js', CClientScript::POS_HEAD);
if (empty($letter))
    if (empty($this->meta_description))
        $this->meta_description = 'Нет ничего сложнее, чем выбрать имя для только что появившегося на свет человечка. Упростите себе эту задачу, воспользовавшись нашим сервисом: можно посмотреть имена по святкам, по известным личностям, по алфавиту и по популярности';

?><ul class="letters">
    <li<?php if (empty($letter)) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index') ?>">Все</a></li>
    <li<?php if ($letter == 'А') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'А')) ?>">А</a></li>
    <li<?php if ($letter == 'Б') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Б')) ?>">Б</a></li>
    <li<?php if ($letter == 'В') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'В')) ?>">В</a></li>
    <li<?php if ($letter == 'Г') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Г')) ?>">Г</a></li>
    <li<?php if ($letter == 'Д') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Д')) ?>">Д</a></li>
    <li<?php if ($letter == 'Е') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Е')) ?>">Е</a></li>
    <li<?php if ($letter == 'Ж') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Ж')) ?>">Ж</a></li>
    <li<?php if ($letter == 'З') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'З')) ?>">З</a></li>
    <li<?php if ($letter == 'И') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'И')) ?>">И</a></li>
    <li<?php if ($letter == 'К') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'К')) ?>">К</a></li>
    <li<?php if ($letter == 'Л') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Л')) ?>">Л</a></li>
    <li<?php if ($letter == 'М') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'М')) ?>">М</a></li>
    <li<?php if ($letter == 'Н') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Н')) ?>">Н</a></li>
    <li<?php if ($letter == 'О') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'О')) ?>">О</a></li>
    <li<?php if ($letter == 'П') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'П')) ?>">П</a></li>
    <li<?php if ($letter == 'Р') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Р')) ?>">Р</a></li>
    <li<?php if ($letter == 'С') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'С')) ?>">С</a></li>
    <li<?php if ($letter == 'Т') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Т')) ?>">Т</a></li>
    <li<?php if ($letter == 'У') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'У')) ?>">У</a></li>
    <li<?php if ($letter == 'Ф') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Ф')) ?>">Ф</a></li>
    <li<?php if ($letter == 'Х') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Х')) ?>">Х</a></li>
    <li<?php if ($letter == 'Ц') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Ц')) ?>">Ц</a></li>
    <li<?php if ($letter == 'Ч') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Ч')) ?>">Ч</a></li>
    <li<?php if ($letter == 'Ш') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Ш')) ?>">Ш</a></li>
    <li<?php if ($letter == 'Э') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Э')) ?>">Э</a></li>
    <li<?php if ($letter == 'Ю') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Ю')) ?>">Ю</a></li>
    <li<?php if ($letter == 'Я') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('index', array('letter'=>'Я')) ?>">Я</a></li>
</ul>
<div class="content_block">
    <?php $this->renderPartial('_gender'); ?>

    <?php if (!empty($letter)):?>
        <p class="names_header">Имена на букву <span><?php echo $letter ?></span></p>
    <?php else: ?>
        <p class="names_header">Все имена</p>
    <?php endif ?>

    <div class="clear"></div>

    <div id="result" class="list_names">
        <?php
        $this->renderPartial('index_data', array(
            'names' => $names,
            'pages' => $pages,
            'like_ids' => $like_ids
        )); ?>
    </div>
</div>
<script type="text/javascript">
    var letter = <?= (empty($letter))?'null':"'".$letter."'" ?>;
    history.replaceState({ path:window.location.href, letter:letter }, '');
</script>