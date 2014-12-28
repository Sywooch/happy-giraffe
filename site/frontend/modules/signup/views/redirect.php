<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
        document.domain = document.domain;
        var attributes = <?=CJSON::encode($this->params['attributes'])?>;
        if (typeof window.opener.registerForm === 'undefined') {
            window.opener.require(['signup/register-form'], function (Register) {
                registerForm = new Register.viewModel();
                registerForm.social(attributes);
                registerForm.__proto__.open(registerForm);
            });
        } else {
            registerForm = window.opener.registerForm;
            <?php if ($this->params['fromLogin']): ?>
            registerForm.prototype.open(registerForm);
            <?php endif; ?>
            registerForm.social(attributes);
        }
        window.close();
    </script>
</head>
</html>