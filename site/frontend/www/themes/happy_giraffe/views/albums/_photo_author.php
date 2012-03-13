<li id="album_photo_<?php echo $data->id; ?>">
    <table>
        <tr>
            <td class="img">
                <div>
                    <?php echo CHtml::link(CHtml::image($data->getPreviewUrl(180, 180)), array('/albums/photo', 'id' => $data->id)); ?>
                    <?php $this->widget('site.frontend.widgets.removeWidget.RemoveWidget', array(
                        'model' => $data,
                        'callback' => 'Album.removePhoto',
                        'author' => !Yii::app()->user->isGuest && Yii::app()->user->id == $data->author_id
                    )); ?>
                </div>
            </td>
        </tr>
        <tr class="title editing">
            <td align="center">
                <div<?php echo !$data->isNewRecord && $data->title != '' ? ' style="display:none;"' : ''; ?>>
                    <input type="hidden" name="Photo[fsn][]" value="<?php echo $data->fs_name; ?>" />
                    <input type="hidden" name="Photo[id][]" value="<?php echo $data->id; ?>" />
                    <input type="text" name="Photo[title][]" value="<?php echo $data->title; ?>" />
                    <button class="btn btn-green-small" onclick="return Album.savePhoto(this);"><span><span>Ок</span></span></button>
                </div>
                <div<?php echo $data->isNewRecord && $data->title == '' ? ' style="display:none;"' : ''; ?>>
                    <span><?php echo $data->title; ?></span>
                    <?php echo CHtml::link('', array('/albums/editPhotoTitle', 'id' => $data->id), array(
                        'class' => 'edit',
                        'onclick' => 'return Album.editPhoto(this);'
                    )); ?>
                </div>
            </td>
        </tr>
    </table>
</li>