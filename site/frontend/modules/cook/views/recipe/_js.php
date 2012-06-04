<script type="text/javascript">
    var newIn = <?php echo CJSON::encode($this->renderPartial('_ingredient', array(
        'n' => $count,
        'form' => $form,
        'model' => $model,
        'units' => $units,
    ), true));?>;
</script>