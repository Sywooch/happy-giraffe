<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript">
            document.domain = document.domain;
            <?php if ($this->params['fromLogin']): ?>
                window.opener.$('a[href="#registerWidget"]').trigger('click');
            <?php endif; ?>
            window.close();
            var registerVm = window.opener.registerVm;
            <?php foreach ($this->params['attributes'] as $k => $v): ?>
                if (registerVm.hasOwnProperty('<?=$k?>'))
                    registerVm.<?=$k?>('<?=$v?>');
            <?php endforeach; ?>
            registerVm.social(true);
            registerVm.currentStep(registerVm.STEP_REG2);
        </script>
    </head>
</html>