<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript">
            window.close();
            <?php foreach ($this->params['attributes'] as $k => $v): ?>
            window.opener.console.log('123');
            if (window.opener.registerVm.hasOwnProperty('<?=$k?>'))
                window.opener.registerVm.<?=$k?>('<?=$v?>');
            window.opener.registerVm.currentStep(window.opener.registerVm.STEP_REG2);
            <?php endforeach; ?>
        </script>
    </head>
</html>