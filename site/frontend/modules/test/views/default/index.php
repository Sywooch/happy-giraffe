<?php
/* @var $this Controller
 * @var $tests Test[]
 */
?>
<ul>
    <?php foreach ($tests as $test): ?>
        <li><?php echo CHtml::link($test->name, $this->createUrl('/test/default/view', array('slug'=>$test->slug))) ?></li>
    <?php endforeach; ?>
</ul>