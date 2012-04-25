<?php
$fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
        'entity' => $entity,
        'entity_id' => $entity_id
    ));
    $fileAttach->window($mode, $a);
    $this->endWidget();
?>