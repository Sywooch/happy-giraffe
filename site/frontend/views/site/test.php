<?
class a {function a() {echo 123;}}
class b extends a {function b() {}}
$c = new b;


Yii::app()->clientScript->registerScriptFile("http://cdn.connect.mail.ru/js/loader.js");
?>
<script type="text/javascript">
    //<![CDATA[
    // этот вызов обязателен, он осуществляет непосредственную загрузку
    // кода библиотеки; рекомендуем всю работу с API вести внутри callback'а
    mailru.loader.require('api', function() {
        // инициализируем внутренние переменные
        // не забудьте поменять на ваши значения app_id и private_key
        mailru.connect.init(667969, "2eb0a20c08c2e666bb81fd97ca6838f7");
        // регистрируем обработчики событий,
        // которые будут вызываться при логине и логауте
        mailru.events.listen(mailru.connect.events.login, function(session){
            window.location.reload();
        });
        mailru.events.listen(mailru.connect.events.logout, function(){
            window.location.reload();
        });
        // проверка статуса логина, в result callback'a приходит
        // вся информация о сессии (см. следующий раздел)
        mailru.connect.getLoginStatus(function(result) {
            if (result.is_app_user != 1) {
                // пользователь не залогинен, надо показать ему кнопку логина

                // вешаем кнопку логина (пример для jquery)
                $('<a class="mrc__connectButton">вход@mail.ru</a>').appendTo('body');
                // эта функция превращает только что вставленный элемент в
                // стандартную кнопку Mail.Ru
                mailru.connect.initButton();
            } else {
                var user = null
                // все ок, можно работать

                // получаем полную информацию о текущем пользователе
                mailru.common.users.getInfo(function(result){
                    user = result[0];
                    mailru.common.friends.getExtended(function(result) {
                        console.log(result);
                    }, user.uid);
                });


            }
        });
    });
    //]]>
</script>