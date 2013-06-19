<?php
/**
 * @var BlogContent $model
 */

$this->widget('ImperaviRedactorWidget', array(
    'name' => 'text',
    'plugins' => array(
        'widget' => array(
            'js' => array('widget.js'),
        ),
        'smiles' => array(
            'js' => array('smiles.js'),
            'css' => array('smiles.css'),
        ),
        'cuttable' => array(
            'js' => array('cuttable.js'),
            'css' => array('cuttable.css'),
        ),
        'albumPhoto' => array(
            'js' => array('albumPhoto.js'),
            'css' => array('albumPhoto.css'),
        ),
    ),
));
?>
<div style="display: none;">
    <div class="upload-btn">
        <?php
        $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
            'model' => $model,
        ));
        $fileAttach->button();
        $this->endWidget();
        ?>
    </div>
</div>