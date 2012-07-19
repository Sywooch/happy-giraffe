<?php
/* @var $this Controller
 */
?>
<div class="name_block<?php if (!empty($num) && $num % 3 == 0) echo ' last' ?>">
    <a href="<?php echo $this->createUrl('club/names/update', array('id' => $id)) ?>" class="<?php
    echo ($gender == 1) ? 'boy' : 'girl'  ?>" title="редактировать"><?php
        echo $name ?></a>
    <?php $this->widget('DeleteWidget', array(
    'modelName' => 'Name',
    'modelPk' => $id,
    'modelAccusativeName' => 'Имя',
    'selector' => 'div.name_block',
)); ?>
    <p><?php echo $translate ?></p>
</div>