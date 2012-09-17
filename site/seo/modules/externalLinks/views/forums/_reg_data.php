<div class="reg-form">
    <button <?php if (isset($account)) echo 'style="display: none;"'?> class="btn-g small" onclick="ExtLinks.AddForumLogin(this)">Ok</button>
    <button <?php if (!isset($account)) echo 'style="display: none;"'?> class="icon-edit" onclick="ExtLinks.EditLogin(this)"></button>
    <label>Логин:</label><input id="forum-login" type="text" value="<?php if (isset($account)) echo $account->login ?>"><br>
    <label>Пароль:</label><input id="forum-password" type="text" value="<?php if (isset($account)) echo $account->password ?>"><br>
</div>