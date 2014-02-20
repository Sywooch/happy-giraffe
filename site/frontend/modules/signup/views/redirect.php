<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript">
            window.close();
            var registerVm = window.opener.registerVm;
            <?php foreach ($this->params['attributes'] as $k => $v): ?>
            if (registerVm.hasOwnProperty('<?=$k?>'))
                registerVm.<?=$k?>('<?=$v?>');
            registerVm.currentStep(window.opener.registerVm.STEP_REG2);
            <?php endforeach; ?>
        </script>
    </head>
</html>