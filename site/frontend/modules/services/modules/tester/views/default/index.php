<?php
/* @var $this Controller
 * @var $tests Test[]
 */
?>
<ul>
    <?php foreach ($tests as $test): ?>
        <li><?php echo CHtml::link($test->title, $this->createUrl('view', array('slug'=>$test->slug))) ?></li>
    <?php endforeach; ?>
</ul>