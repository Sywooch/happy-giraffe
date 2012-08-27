<li data-userid="<?=$contact->id?>" onclick="Messages.setDialog(<?=$contact->id?>);">

    <span class="ava small"><?=$contact->getAva('small') ? CHtml::image($contact->getAva('small')):''?></span>

    <div class="in">

        <span class="icon-status status-<?=$contact->online == 1 ? 'online' : 'offline'?>"></span>

        <span class="username"><?=$contact->fullName?></span>

        <?php if ($contact->userDialog && $contact->userDialog->dialog->unreadMessagesCount != 0): ?><span class="new"><?=$contact->userDialog->dialog->unreadMessagesCount?> <?=HDate::GenerateNoun(array('новое', 'новых', 'новых'), $contact->userDialog->dialog->unreadMessagesCount)?></span><?php endif; ?>

    </div>

</li>