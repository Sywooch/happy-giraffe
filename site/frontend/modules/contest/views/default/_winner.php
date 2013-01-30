<li class="contest-winners_list_item">
    <?php
        $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
            'user' => $data->work->author,
            'location' => false,
            'friendButton' => true,
        ));
    ?>

    <div class="contest-winners_place place-<?=$data->place?>">
        <?php if ($isConsolationPrize): ?>
            <div class="text" style="font-size: 18px;">Поощрительный приз</div>
        <?php else: ?>
            <?php if ($data->place <= 3): ?>
                <div class="cup"></div>
            <?php endif; ?>
            <div class="digit"><?=$data->place?></div>
            <div class="text">место</div>
        <?php endif; ?>
    </div>
    <div class="contest-winners_prize">
        <span><?=$prize['title']?></span> <br />
        <strong><?=$prize['model']?></strong>
    </div>

    <!-- Галлерея без js masonry (imagesLoaded) расставляющего фото по местам  -->
    <div class="gallery-photos-new clearfix">

        <ul>
            <?php $this->renderPartial('_work', array('data' => $data->work)); ?>

        </ul>

    </div>
</li>