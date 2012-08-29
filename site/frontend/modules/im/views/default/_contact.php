<li data-userid="<?=$contact->id?>" data-unread="<?=$contact->userDialog->dialog->unreadMessagesCount?>" onclick="Messages.setDialog(<?=$contact->id?>);">

    <span class="ava small"><?=$contact->getAva('small') ? CHtml::image($contact->getAva('small')):''?></span>

    <div class="in">

        <span class="icon-status status-<?=$contact->online == 1 ? 'online' : 'offline'?>"></span>

        <span class="username"><?=$contact->fullName?></span>

        <span class="unread"></span>

    </div>

</li>