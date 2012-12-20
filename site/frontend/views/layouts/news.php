<?php $this->beginContent('//layouts/main'); ?>

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

            <?php
                $items = array();

                $items[] = array(
                    'label' => 'Все новости',
                    'url' => array('community/list', 'community_id' => $this->community->id),
                    'template' => '<span>{menu}</span><div class="count">' . $this->community->count . '</div>',
                    'active' => ! (in_array($this->action->id, array('contacts', 'authors'))) && $this->rubric_id === null,
                );

                foreach ($this->community->rubrics as $rubric) {
                    $params = array('rubric_id' => $rubric->id);
                    if ($this->action->id == 'view')
                        $params['content_type_slug'] = null;

                    $items[] = array(
                        'label' => $rubric->title,
                        'url' => $this->getUrl($params),
                        'template' => '<span>{menu}</span><div class="count">' . $rubric->contentsCount . '</div>',
                        'active' => ! (in_array($this->action->id, array('contacts', 'authors'))) && $rubric->id == $this->rubric_id,
                    );
                }

                $this->widget('zii.widgets.CMenu', array(
                    'items' => $items,
                ));
            ?>

            <hr class="hr">
            <?php
                $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '<span>{menu}</span>',
                    'items' => array(
                        array(
                            'label' => 'О нас',
                            'url' => array('community/contacts'),
                            'active' => $this->action->id == 'contacts',
                        ),
//                        array(
//                            'label' => 'Авторы',
//                            'url' => array('community/authors'),
//                            'active' => $this->action->id == 'authors',
//                        ),
                    ),
                ));
            ?>

        </div>

    </div>
</div>

<?php $this->endContent(); ?>