<?php
/* @var $this SController
 * @var $phrase PagesSearchPhrase
 */
$period = 2;
$page = $phrase->page;

Yii::app()->clientScript->registerScript('set_phrase', '
SeoLinking.phrase_id = "' . $phrase->id . '";
SeoLinking.page_id = "' . $page->id . '";
');
?>
<div id="auto-linking">

    <?php $this->renderPartial('_auto_linking', compact('phrase', 'pages', 'keywords', 'page')); ?>

</div>