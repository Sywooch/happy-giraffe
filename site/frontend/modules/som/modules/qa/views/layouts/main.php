<?php
/**
 * @var $this site\frontend\modules\som\modules\qa\controllers\DefaultController
 * @var string $content
 * @var site\frontend\modules\som\modules\qa\widgets\ConsultationsMenu $consultationsMenu
 */
$this->beginContent('//layouts/lite/main');
$this->renderSidebarClip();

$parentTitle = 'Вопрос-ответ';

if ($this->pageTitle !== $parentTitle) 
{   
    $title = 'Ответы';
    
    $this->breadcrumbs[$title] = $this->createUrl('/questions'); 
    $this->breadcrumbs[] = $this->pageTitle;
}

?>
    <div class="b-main clearfix">
        <div class="b-main_cont">
            <div class="heading-link-xxl"><?php echo $this->pageTitle; ?></div>
            <div class="b-main_col-article">
                <?=$content?>
            </div>
            <aside class="b-main_col-sidebar visible-md">
                <div class="sidebar-widget">
                    <?php $this->renderPartial('/_sidebar/ask', array());?>
                    <?php $this->renderPartial('/_sidebar/personal', array());?>
                    <?php $this->renderPartial('/_sidebar/menu', array());?>
                </div>
                <?php $this->renderPartial('/_sidebar/rating', array());?>
            </aside>
        </div>
    </div>
<?php $this->endContent(); ?>