<div class="col-1">
    <ul class="menu-list menu-list__favorites margin-t10">
        <li class="menu-list_li">
            <a href="<?=$this->createUrl('site/page', array('view' => 'advertiser'))?>" class="menu-list_i<?php if ($this->action->requestedView == 'advertiser'): ?> active<?php endif; ?>">
                <span class="menu-list_tx">Реклама на сайте</span>
            </a>
        </li>
        <li class="menu-list_li">
            <a href="<?=$this->createUrl('site/page', array('view' => 'abuse'))?>" class="menu-list_i<?php if ($this->action->requestedView == 'abuse'): ?> active<?php endif; ?>">
                <span class="menu-list_tx">Правообладателям</span>
            </a>
        </li>
        <li class="menu-list_li">
            <span class="menu-list_i disabled">
                <span class="menu-list_tx">Наши контакты</span>
            </span>
        </li>
    </ul>
</div>