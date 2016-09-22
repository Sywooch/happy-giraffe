<?php
$cs = Yii::app()->clientScript;
if (Yii::app()->vm->version != VersionManager::VERSION_MOBILE) {
    $cs->registerAMD('photoAd', array('popup' => 'photo-ad/photo-popup'));
}
/** @todo перенести обработку $this->post->metaObject в контроллер */
$this->pageTitle = $this->post->title;
$this->metaDescription = $this->post->metaObject->description;
$this->metaNoindex = $this->post->isNoindex;

$breadcrumbs = [
    'Главная'   => ['/site/index'],
    'Форумы'    => ['/posts/forums/default/index'],
];

if (!is_null($this->forum))
{   
    $breadcrumbs[$this->club->title] = $this->club->getUrl();
    
    if (isset($this->post->title))
    {
        if (count($this->club->communities) > 1)
        {
            $breadcrumbs[$this->forum->title] = $this->forum->getUrl();
        }
    }
    else
    {
        $breadcrumbs[] = $this->forum->title;
    }
}
else
{
    $breadcrumbs[] = $this->club->title;
}

$breadcrumbs[] = $this->post->title;


$comments = $this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
        /** @todo Исправить класс при конвертации */
        'entity' => 'BlogContent', //$this->post->originEntity,
        'entity_id' => $this->post->originEntityId,
        )));
?>

<div class="b-breadcrumbs" style="margin-left: 0">
  		
<?php 

$this->widget('zii.widgets.CBreadcrumbs', [
    'links'                => $breadcrumbs,
    'tagName'              => 'ul',
    'homeLink'             => FALSE,
    'separator'            => '',
    'activeLinkTemplate'   => '<li><a href="{url}">{label}</a></li>',
    'inactiveLinkTemplate' => '<li>{label}</li>',
]); 

?>

</div>

<?php $this->renderPartial('site.frontend.modules.posts.views.post._view'); ?>