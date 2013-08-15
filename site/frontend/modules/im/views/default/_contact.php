<li data-userid="<?=$contact->id?>" data-unread="<?=($contact->userDialog) ? $contact->userDialog->dialog->unreadMessagesCount : 0?>" onclick="Messages.setDialog(<?=$contact->id?>);">

    <span class="ava small"><?=$contact->getAvatarUrl(24) ? CHtml::image($contact->getAvatarUrl(24)):''?></span>

    <div class="in">

        <span class="icon-status status-<?=$contact->online == 1 ? 'online' : 'offline'?>"></span>

        <span class="username"><?=$contact->fullName?></span>

        <span class="unread"></span>

    </div>

</li>