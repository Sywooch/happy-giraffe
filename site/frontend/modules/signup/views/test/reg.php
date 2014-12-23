<div id="href">
    <a  data-bind="register: {}">Регистрация</a><br>
    <a  data-bind="login: {}">Вход</a>
</div>

<script type="text/javascript">
    require(['knockout', 'signup/bindings'], function(ko) {
        ko.applyBindings({}, document.getElementById('href'));
    });
</script>