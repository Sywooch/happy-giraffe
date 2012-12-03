<div class="reg-form"<?php if (isset($show) && !$show) echo ' style="display: none;"' ?>>
    <?php if (isset($account)):?>
        <button style="display: none;" class="btn-g small" onclick="ExtLinks.AddForumLogin(this)">Ok</button>
        <button class="icon-edit" onclick="ExtLinks.EditLogin(this)"></button>
        <label>Логин:</label><input id="forum-login" type="text" value="<?= $account->login ?>" disabled="disabled"><br>
        <label>Пароль:</label><input id="forum-password" type="text" value="<?= $account->password ?>" disabled="disabled">
    <?php else: ?>
        <button class="btn-g small" onclick="ExtLinks.AddForumLogin(this)">Ok</button>
        <button style="display: none;" class="icon-edit" onclick="ExtLinks.EditLogin(this)"></button>
        <label>Логин:</label><input id="forum-login" type="text" value=""><br>
        <label>Пароль:</label><input id="forum-password" type="text" value="">
    <?php endif ?>
</div>