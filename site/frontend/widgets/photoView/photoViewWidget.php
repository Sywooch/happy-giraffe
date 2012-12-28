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
    public $entity_url;
    public $singlePhoto = false;
    public $query = array();

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

        $script = '$("' . $this->selector . '").pGallery(' . CJavaScript::encode(CMap::mergeArray(array('singlePhoto' => $this->singlePhoto, 'entity' => $this->entity, 'entity_id' => $this->entity_id, 'entity_url' => $this->entity_url), $this->query)) . ');';
        Yii::app()->controller->pGallery = $script;

        Yii::app()->clientScript->registerScript('pGallery-' . $this->entity . '-' . $this->entity_id, $script);

        Yii::app()->clientScript->registerScriptFile('/javascripts/history.js');
        Yii::app()->clientScript->registerScriptFile('/javascripts/gallery.js?r=' . time());

        $report = $this->beginWidget('site.frontend.widgets.reportWidget.ReportWidget');
        $report->registerScripts();
        $this->endWidget();
    }
}