<div class="main">

    <div class="main-in">

        <div class="content-title-new content-title-left"><?=($category_id === null) ? 'Полезные сервисы для всей семьи' : 'Сервисы ' . mb_strtolower($services[0]->title, 'UTF-8')?></div>

        <div class="services-list">

            <?php foreach ($services as $category): ?>
                <?php if ($category->services): ?>
                    <?php if ($category_id === null): ?><div class="block-title">Сервисы <?=mb_strtolower($category->title, 'UTF-8')?></div><?php endif; ?>

                    <ul>
                        <?php foreach ($category->services as $service): ?>
                            <li>
                                <?php if ($service->photo): ?>
                                    <div class="img"><?=CHtml::link(CHtml::image($service->photo->getPreviewUrl(104, null, Image::WIDTH)), $service->url)?></div>
                                <?php endif; ?>
                                <div class="text">
                                    <div class="item-title"><?=CHtml::link($service->title, $service->url)?></div>
                                    <p><?=$service->description?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>

    </div>

</div>

<div class="side-left">

    <br/><br/><br/><br/>

    <div class="club-topics-list-new">

        <?php
            $items = array();
            $items[] = array(
                'label' => 'Все сервисы',
                'url' => array('site/services'),
                'template' => '<span>{menu}</span><div class="count">' . Service::model()->count('`show`=1') . '</div>',
                'active' => $category_id === null,
            );

            foreach ($categories as $c) {
                $items[] = array(
                    'label' => $c->title,
                    'url' => array('site/services', 'category_id' => $c->id),
                    'template' => '<span>{menu}</span><div class="count">' . $c->servicesCount . '</div>',
                    'visible' => $c->servicesCount > 0,
                );
            }
        ?>

        <?php
            $this->widget('zii.widgets.CMenu', array(
                'items' => $items,
            ));
        ?>

    </div>

</div>