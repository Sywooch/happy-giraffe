<?php $this->render('list', array('dataProvider' => $dataProvider, 'type'=>$type, 'comment_model' => $comment_model)); ?>
<script type="text/javascript">
    var cke_instance = '<?= $this->commentModel; ?>_text';
</script>
