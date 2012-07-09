<?php
/**
 * User: Eugene
 * Date: 06.06.12
 */
class photoViewWidget extends CWidget
{
    public $selector;
    public $entity;
    public $entity_id;

    public function init()
    {
        $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
            'registerScripts' => true,
        ));
        $this->widget('site.frontend.widgets.commentWidget.CommentWidget', array(
            'registerScripts' => true,
        ));
        $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
        $remove_tmpl->registerTemplates();
        $this->endWidget();

        Yii::app()->clientScript->registerScript('pGallery',
            '$("' . $this->selector . '").pGallery(' . CJavaScript::encode(array('entity' => $this->entity, 'entity_id' => $this->entity_id)) . ');'
        );

        Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.jcarousel.js');
        Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.jcarousel.control.js');
        Yii::app()->clientScript->registerScriptFile('/javascripts/history.js');
        Yii::app()->clientScript->registerScriptFile('/javascripts/gallery.js?r=1005');


        $report = $this->beginWidget('site.frontend.widgets.reportWidget.ReportWidget');
        $report->registerScripts();
        $this->endWidget();
    }
}
