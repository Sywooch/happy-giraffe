<li id="album_photo_<?php echo $data->id; ?>">
    <table>
        <tr>
            <td class="img">
                <div>
                    <?php echo CHtml::link(CHtml::image($data->getPreviewUrl(150, 150, Image::WIDTH)), $data->url); ?>
                    <?php if($data->album->isNotSystem): ?>
                        <?php $this->widget('site.frontend.widgets.removeWidget.RemoveWidget', array(
                            'model' => $data,
                            'callback' => 'Album.removePhoto',
                            'author' => !Yii::app()->user->isGuest && Yii::app()->user->id == $data->author_id
                        )); ?>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <tr class="title">
            <td align="center">
                <div<?php echo $data->isNewRecord && $data->title == '' ? ' style="display:none;"' : ''; ?>>
                    <span><?php echo $data->title != '' ? CHtml::encode($data->title) : '&nbsp;'; ?></span>
                </div>
            </td>
        </tr>
    </table>
</li>