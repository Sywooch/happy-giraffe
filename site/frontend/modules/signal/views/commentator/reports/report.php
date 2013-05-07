<?php
/* @var $this CommentatorController
 * @var $month string месяц отчетности
 * @var $section string раздел отчетности
 */
?><?php $this->renderPartial('reports/menu', compact('section')); ?>
<div class="block">
    <?php $this->renderPartial('_month_list', array('month' => $month, 'params'=>array('section'=>$section))); ?>
    <?php $this->renderPartial('reports/' . $section, array('month' => $month)); ?>
</div>