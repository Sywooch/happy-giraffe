<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript">
            document.domain = document.domain;
            <?php if ($this->params['fromLogin']): ?>
                window.opener.$('a[href="#registerWidget"]').trigger('click');
            <?php endif; ?>

            var registerVm = window.opener.registerVm;

            var data = {};
            <?php foreach ($this->params['attributes'] as $k => $v): ?>
                data.<?=$k?> = '<?=$v?>';
            <?php endforeach; ?>
            window.opener.$.post('/signup/register/step2/', { RegisterFormStep2 : data, ajax : 'registerSocial', social : 'true' }, function(response) {
                for (var i in data)
                    if (! response.hasOwnProperty('RegisterFormStep2_' + i) && registerVm.hasOwnProperty(i)) {
                        if (registerVm[i] instanceof window.opener.RegisterUserAttribute) {
                            registerVm[i].val(data[i]);
                            registerVm[i].show(false);
                        } else
                            registerVm[i](data[i]);
                    }
                alert(data.avatar_src);
                registerVm.avatar.imgSrc(data.avatar_src);
                //window.close();
            }, 'json');
            registerVm.social(true);
            registerVm.currentStep(registerVm.STEP_REG2);
            registerVm.socialServiceName('<?=$this->params['serviceName']?>');
        </script>
    </head>
</html>