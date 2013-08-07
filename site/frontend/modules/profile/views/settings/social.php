<div class="margin-b30 clearfix">
    Свяжите свой профиль с вашими аккаунтами на других сайтах. <br>Это позволит входить на сайт, используя любой из привязанных аккаунтов.
</div>
<!-- Пока нет связаных соц. сетей, таблицы тоже нет -->
<?php Yii::app()->eauth->renderWidget(array('mode' => 'profile', 'action' => 'site/login')); ?>
<table class="form-settings_table">
    <thead>
    <tr>
        <th class="form-settings_th textalign-l">Социальная сеть</th>
        <th class="form-settings_th"> Имя</th>
        <th class="form-settings_th">Удалить профиль</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="form-settings_td textalign-l">
                                        <span class="custom-like">
                                            <span class="custom-like_icon odkl"></span>
                                        </span>
            <span>Одноклассники</span>
        </td>
        <td class="form-settings_td"><a href="" title="">Александр Кувыркин</a></td>
        <td class="form-settings_td">
            <a href="" class="a-pseudo-icon">
                <span class="ico-close2"></span>
                <span class="a-pseudo-icon_tx">Удалить</span>
            </a>
        </td>
    </tr>
    <tr>
        <td class="form-settings_td textalign-l">
                                        <span class="custom-like">
                                            <span class="custom-like_icon vk"></span>
                                        </span>
            <span>Вконтакте</span>
        </td>
        <td class="form-settings_td"><a href="" title="">Александр Кувыркин</a></td>
        <td class="form-settings_td">
            <a href="" class="a-pseudo-icon">
                <span class="ico-close2"></span>
                <span class="a-pseudo-icon_tx">Удалить</span>
            </a>
        </td>
    </tr>
    <tr>
        <td class="form-settings_td textalign-l">
                                        <span class="custom-like">
                                            <span class="custom-like_icon fb"></span>
                                        </span>
            <span>Facebook</span>
        </td>
        <td class="form-settings_td"><a href="" title="">Александр Кувыркин</a></td>
        <td class="form-settings_td">
            <a href="" class="a-pseudo-icon">
                <span class="ico-close2"></span>
                <span class="a-pseudo-icon_tx">Удалить</span>
            </a>
        </td>
    </tr>
    <tr>
        <td class="form-settings_td textalign-l">
                                        <span class="custom-like">
                                            <span class="custom-like_icon tw"></span>
                                        </span>
            <span>Twitter</span>
        </td>
        <td class="form-settings_td"><a href="" title="">Александр Кувыркин</a></td>
        <td class="form-settings_td">
            <a href="" class="a-pseudo-icon">
                <span class="ico-close2"></span>
                <span class="a-pseudo-icon_tx">Удалить</span>
            </a>
        </td>
    </tr>
    </tbody>
</table>

<div class="form-settings_t">Добавить профиль</div>

<div class="margin-b30 clearfix">
    <a href="" class="b-social-big">
        <span class="b-social-big_ico odkl"></span>
    </a>
    <a href="" class="b-social-big">
        <span class="b-social-big_ico vk"></span>
    </a>
    <a href="" class="b-social-big">
        <span class="b-social-big_ico fb"></span>
    </a>
    <a href="" class="b-social-big">
        <span class="b-social-big_ico tw"></span>
    </a>
</div>