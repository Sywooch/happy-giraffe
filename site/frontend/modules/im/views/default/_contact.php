<li data-userid="<?=$contact->id?>">

    <span class="ava small"><?=$contact->getAva('small') ? CHtml::image($contact->getAva('small')):''?></span>

    <div class="in">

        <span class="icon-status status-<?=$contact->online == 1 ? 'online' : 'offline'?>"></span>

        <span class="username"><?=$contact->fullName?></span>

    </div>

</li>