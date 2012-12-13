<?php
/* @var $this CommunityController
 * @var $data CommunityContent
*/

$this->renderPartial('_post', array('data' => $data, 'full' => true));

$this->renderPartial('_prev_next', array('data' => $data));

$this->widget('application.widgets.commentWidget.CommentWidget', array('model' => $data));

$this->widget('application.widgets.seo.SeoLinksWidget');

$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();

$this->widget('WhatsNewWidget');
