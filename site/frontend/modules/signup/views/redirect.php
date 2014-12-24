<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
        document.domain = document.domain;
        registerForm = window.opener.registerForm;
        <?php if ($this->params['fromLogin']): ?>
        registerForm.prototype.open();
        <?php endif; ?>
        registerForm.social(<?=CJSON::encode($this->params['attributes'])?>);
        window.close();
    </script>
</head>
</html>