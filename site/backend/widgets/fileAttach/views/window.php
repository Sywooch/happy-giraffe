<div class="popup" id="photoPick">
    <a onclick="$.fancybox.close();" class="popup-close" href="javascript:void(0);">закрыть</a>
    <div class="title"><?php echo $this->title; ?></div>
    <?php if(!$this->disableNavigation): ?>
        <div class="nav default-nav ajax-nav">
            <ul id="file_attach_menu">
                <li class="active">
                    <?php echo CHtml::link('С компьютера', array('/albums/attach', 'entity' => $this->entity, 'entity_id' => $this->entity_id, 'mode' => 'browse'), array(
                        'onclick' => 'return ' . $this->id . '.changeView(this);'
                    )); ?>
                </li>
                <li>
                    <?php echo CHtml::link('Из моих альбомов', array('/albums/attach', 'entity' => $this->entity, 'entity_id' => $this->entity_id, 'mode' => 'albums'), array(
                        'onclick' => 'return ' . $this->id . '.changeView(this);'
                    )); ?>
                </li>
            </ul>
        </div>
    <?php endif; ?>
    <div id="attach_content">
        <?php $this->render('_browse'); ?>
    </div>
</div>
    <script type="text/javascript">
        currentAttach = window['<?=$this->id?>'];
    </script>