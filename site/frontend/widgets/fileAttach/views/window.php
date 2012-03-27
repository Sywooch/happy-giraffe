<div class="popup" id="photoPick">
    <a onclick="$.fancybox.close();" class="popup-close" href="javascript:void(0);">закрыть</a>
    <div class="title"><?php echo $this->title; ?></div>
    <div class="nav">
        <ul id="file_attach_menu">
            <li class="active">
                <?php echo CHtml::link('С компьютера', array('/albums/attach', 'entity' => $this->entity, 'entity_id' => $this->entity_id, 'mode' => 'browse'), array(
                    'onclick' => 'return Attach.changeView(this);'
                )); ?>
            </li>
            <li>
                <?php echo CHtml::link('Из моих альбомов', array('/albums/attach', 'entity' => $this->entity, 'entity_id' => $this->entity_id, 'mode' => 'albums'), array(
                    'onclick' => 'return Attach.changeView(this);'
                )); ?>
            </li>
        </ul>
    </div>
    <div id="attach_content">
        <?php $this->render('_browse'); ?>
    </div>
</div>