<li>
    <table>
        <tbody>
            <tr>
                <td class="img">
                    <div>
                        <?php echo CHtml::link(CHtml::image($data->getPreviewUrl(150, 150)), array('/albums/photo', $data->url)); ?>
                        <div class="contest-send">
                            <?php $image = new Imagick($data->originalPath); ?>
                            <?php if($image->getimagewidth() < 240 || $image->getimageheight() < 240): ?>
                                <p class="error">Слишком маленький размер</p>
                            <?php else: ?>
                                <a class="btn btn-green-medium" href="javascript:;" onclick="<?php echo $this->id; ?>.selectPhoto(this, <?php echo $data->id ?>);"><span><span><?php echo $this->button_title; ?></span></span></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="rank"><td><span><?php echo Rating::model()->countByEntity($data); ?></span> баллов</td></tr>
            <?php if($data->title != ''): ?>
                <tr class="title">
                    <td align="center"><div><?php echo $data->title; ?></div></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</li>