<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
        document.domain = document.domain;
        var registerVm = window.opener.registerVm;
        var data = <?=CJSON::encode($this->params['attributes'])?>;
        for (var i in data)
            if (registerVm.hasOwnProperty(i)) {
                if (registerVm[i] instanceof window.opener.RegisterUserAttribute) {
                    registerVm[i].val(data[i]);
                    registerVm[i].show(false);
                } else
                    registerVm[i](data[i]);
            }
        registerVm.currentStep(registerVm.STEP_EMAIL2);
        registerVm.open();
        window.close();
    </script>
</head>
</html>