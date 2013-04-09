<div class="box homepage-blogs">

    <div class="title">Блоги <span>мам и пап</span></div>

    <ul>
        <?php foreach ($models as $model): ?>
        <li>
            <div class="clearfix">
                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $model->contentAuthor,
                'size' => 'small',
                'sendButton' => false,
                'location' => false,
            )); ?>
            </div>
            <b><?=CHtml::link($model->title, $model->url)?></b>
            <div class="img">
                <?php
                $image = $model->getContentImage(200);
                if ($image)
                    echo CHtml::link(CHtml::image($image, $model->title), $model->url);
                else
                    echo '<p>' . $model->getContentText(250) . '</p>';
                ?>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>

</div>