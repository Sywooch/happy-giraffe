<?php
    $message = new Message;

    $this->widget('ext.ckeditor.CKEditorWidget', array(
        'model' => $message,
        'attribute' => 'text',
        'config' => array(
            'width' => 506,
            'height' => 56,
            'toolbar' => 'Chat',
            'resize_enabled' => false,
        ),
    ));
