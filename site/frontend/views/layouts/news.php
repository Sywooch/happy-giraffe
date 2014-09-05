<?php $this->beginContent('//layouts/main'); ?>

<div class="content-cols clearfix">

    <div class="col-1">

        <div class="margin-t20"></div>
        <?php if (Yii::app()->authManager->checkAccess('news', Yii::app()->user->id)): ?>
            <div class="club-fast-add">
                <?=HHtml::link('<span><span>Добавить</span></span>', $this->getUrl(array('content_type_slug' => null), 'community/add'), array('class' => 'btn btn-green'), true)?>
            </div>
        <?php endif; ?>
        <div class="banner-box">
            <img src="/images/banner_09.png" />
        </div>
        
        <!-- club-topics-list-new -->
        <div class=" menu-simple">

            <?php
                $items = array();

                $items[] = array(
                    'linkOptions'=> array('class' => 'menu-simple_a'),
                    'label' => 'Все новости',
                    'url' => array('/community/default/forum', 'forum_id' => $this->forum->id),
                    'template' => '{menu}',//'<span>{menu}</span>',     <div class="count">' . $this->community->count . '</div>',
                    'active' => ! (in_array($this->action->id, array('contacts', 'authors'))) && $this->rubric_id === null,
                );

                foreach ($this->forum->rubrics as $rubric) {
                    $params = array('rubric_id' => $rubric->id);
                    if ($this->action->id == 'view')
                        $params['content_type_slug'] = null;

                    $items[] = array(
                        'label' => $rubric->title,
                        'url' => $this->getUrl($params),
                        'template' => '{menu}',//'<span>{menu}</span>',    <div class="count">' . $rubric->contentsCount . '</div>',
                        'active' => ! (in_array($this->action->id, array('contacts', 'authors'))) && $rubric->id == $this->rubric_id,
                        'linkOptions'=> array('class' => 'menu-simple_a'),
                    );
                }

                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array( 'class' => 'menu-simple_ul'),
                    'itemCssClass' => 'menu-simple_li',
                    'items' => $items,
                ));
            ?>

            <hr class="hr">
            <?php
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array( 'class' => 'menu-simple_ul'),
                    'itemCssClass' => 'menu-simple_li',
                    'itemTemplate' => '{menu}',
                    'items' => array(
                        array(
                            'label' => 'О нас',
                            'url' => array('/community/default/contacts'),
                            'active' => $this->action->id == 'contacts',
                            'linkOptions'=> array('class' => 'menu-simple_a'),
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
    <div class="col-23-middle ">
        <!-- <div class="main-in"> -->

            <?=$content?>

        <!-- </div> -->
    </div>
</div>

<?php $this->endContent(); ?>