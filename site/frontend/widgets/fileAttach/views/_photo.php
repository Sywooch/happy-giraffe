<li>
    <table>
        <tbody>
            <tr>
                <td class="img">
                    <div>
                        <?php echo CHtml::link(CHtml::image($data->getPreviewUrl(150, 150)), array('/albums/photo', 'id' => $data->id)); ?>
                        <div class="contest-send">
                            <a class="btn btn-green-medium" href="javascript:;" onclick="Attach.selectPhoto(this, <?php echo $data->id ?>);"><span><span>Добавить<br>на конкурс</span></span></a>
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