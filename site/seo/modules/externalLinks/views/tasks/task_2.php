<?php
/** @var $task ELTask
 */
?>
<div class="tasks-list">

    <ul>
        <li>
            <div class="task-title">Поставьте комментарий на форуме
                <a target="_blank" href="http://<?=$task->site->url?>">
                    <span class="hl">http://<?=$task->site->url?></span>
                </a>
            </div>
        </li>
        <?php if (empty($task->site->account)): ?>
        <li>
            <div class="task-title">Внесите данные регистрации</div>
            <div class="reg-form">
                <button class="btn-g small" onclick="ExtLinks.AddForumLogin(this, <?=$task->site_id?>)">Ok</button>
                <label>Логин:</label><input id="forum-login" type="text"><br>
                <label>Пароль:</label><input id="forum-password" type="text"><br>
            </div>
        </li>
        <?php else: ?>
        <li>
            <a href="javascript:;" class="pseudo" onclick="$(this).next().toggle()">Показать данные</a>

            <div class="reg-form" style="display: none;">
                <label>Логин:</label><input type="text" value="<?=$task->site->account->login ?>"><br>
                <label>Пароль:</label><input type="text" value="<?=$task->site->account->password ?>"><br>
            </div>
        </li>
        <?php endif ?>
    </ul>

</div>

<div class="form">

    <div class="row row-btn-done">

        <button class="btn-g" onclick="ExtLinks.Executed(<?=$task->id ?>)">Выполнено</button>
        <div class="problem">
            <a href="javascript:void(0);" class="pseudo" onclick="$(this).next().toggle()">Возникла проблема</a>

            <div class="problem-in" style="display: none;">
                <a href="javascript:;" class="btn-g small" onclick="ExtLinks.Problem(<?=$task->id ?>)">Ok</a>

                <?php if (empty($task->site->account)): ?>
                    <a href="javascript:;" class="radio" onclick="ExtLinks.checkProblem(this, 2)">Письмо не пришло</a>
                    <a href="javascript:;" class="radio" onclick="ExtLinks.checkProblem(this, 1)">Невозможно
                    зарегистрироваться</a>
                <?php else: ?>
                    <a href="javascript:;" class="radio" onclick="ExtLinks.checkProblem(this, 1)">Аккаунт заблокировали</a>
                    <a href="javascript:;" class="radio" onclick="ExtLinks.checkProblem(this, 2)">Сайт недоступен</a>
                <?php endif ?>

            </div>
            <div class="problem-in" style="display: none;">
                <a href="javascript:;" class="btn-g small" onclick="ExtLinks.Problem(<?=$task->id ?>)">Ok</a>
            </div>
        </div>

    </div>

</div>