<script type="text/javascript">
    <?php foreach ($reg_data as $attribute => $value): ?>
        opener.window.Register.SetAttribute('<?=$attribute ?>', '<?=$value ?>');
    <?php endforeach; ?>
    opener.window.Register.showStep2('', '<?=$type ?>');
    self.close();
</script>