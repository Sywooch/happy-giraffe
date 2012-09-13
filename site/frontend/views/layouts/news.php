<?php $this->beginContent('//layouts/main'); ?>

<?php
    $this->widget('zii.widgets.CBreadcrumbs', array(
        'links' => $this->breadcrumbs,
        'separator' => ' &gt; ',
        'htmlOptions' => array(
            'id' => 'crumbs',
            'class' => null,
        ),
    ));
?>

<div class="clearfix">
    <div class="main">
        <div class="main-in">

            <?=$content?>

        </div>
    </div>

    <div class="side-left">

        <?php if (Yii::app()->authManager->checkAccess('news', Yii::app()->user->id)): ?>
            <div class="club-fast-add">
                <?=HHtml::link('<span><span>Добавить</span></span>', $this->getUrl(array('content_type_slug' => null), 'community/add'), array('class' => 'btn btn-green'), true)?>
            </div>
        <?php endif; ?>

        <div class="banner-box">
            <img src="/images/banner_09.png" />
        </div>

        <div class="club-topics-list-new">

            <div class="block-title">Рубрики</div>

            <?php
                $items = array();

                $items[] = array(
                    'label' => 'Все новости',
                    'url' => array('community/list', 'community_id' => $this->community->id),
                    'template' => '<span>{menu}</span><div class="count">' . $this->community->count . '</div>',
                    'active' => $this->rubric_id === null,
                );

                foreach ($this->community->rubrics as $rubric) {
                    $params = array('rubric_id' => $rubric->id);
                    if ($this->action->id == 'view')
                        $params['content_type_slug'] = null;

                    $items[] = array(
                        'label' => $rubric->title,
                        'url' => $this->getUrl($params),
                        'template' => '<span>{menu}</span><div class="count">' . $rubric->contentsCount . '</div>',
                        'active' => $rubric->id == $this->rubric_id,
                    );
                }

                $this->widget('zii.widgets.CMenu', array(
                    'items' => $items,
                ));
            ?>

        </div>

    </div>
</div>

<div class="push"></div>

<?php $this->endContent(); ?>