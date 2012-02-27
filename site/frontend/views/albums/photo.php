<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.jcarousel.js'); ?>
<div id="gallery">
    <div class="header">
        <div class="clearfix">
            <div class="user">
                <div class="ava"><img src="/images/ava.png"/></div>
                <p><span>Анастасия</span><br/>Россия, Ярославль</p>
            </div>
            <div class="back-link">&larr; <a href="">В анкету</a></div>
        </div>
    </div>
    <div id="photo">
        <div class="title"><?php echo $photo->file_name; ?></div>
        <div class="big-photo">
            <div class="img">
                <?php echo CHtml::image($photo->getPreviewUrl(400, 750)); ?>
            </div>
            <a href="" class="prev disabled"></a>
            <a href="" class="next"></a>
        </div>
        <div class="jcarousel-container gallery-photos">
            <div id="photo-thumbs" class="jcarousel">
                <ul>
                    <?php foreach($photo->album->photos as $item): ?>
                        <li<?php echo $item->id == $photo->id ? ' class="active"' : '' ?>>
                            <table>
                                <tr>
                                    <td class="img">
                                        <div>
                                            <?php echo CHtml::link(CHtml::image($item->getPreviewUrl(180, 180)), array('photo', 'id' => $item->id)); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="title">
                                    <td align="center">
                                        <div><?php echo $item->file_name ?></div>
                                    </td>
                                </tr>
                            </table>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <a href="javascript:void(0);" class="jcarousel-prev prev disabled");"></a>
            <a href="javascript:void(0);" class="jcarousel-next next");"></a>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('.gallery-photos').jcarousel();
    });
</script>