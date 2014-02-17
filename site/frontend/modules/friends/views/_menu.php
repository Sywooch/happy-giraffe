<!-- side-menu-->
<div class="side-menu side-menu__friend">
    <div class="side-menu_hold">
        <div class="side-menu_t side-menu_t__friends"></div>
        <ul class="side-menu_ul">
            <li class="side-menu_li side-menu_li__find">
                <a href="<?=$this->createUrl('/friends/search')?>" data-bind="css: { active : activeTab() == -1 }" class="side-menu_i">
                    <span class="side-menu_i-hold">
                        <span class="side-menu_ico side-menu_ico__find"></span>
                        <span class="side-menu_tx">Найти друзей</span>
                    </span>
                </a>
            </li>
            <li class="side-menu_li" data-bind="css: { active : activeTab() == 0, disabled: friendsCount() == 0 }">
                <a href="" class="side-menu_i" data-bind="click: function(data, event) { if (friendsCount() > 0) selectTab(0, data, event) }">
                    <span class="side-menu_i-hold">
                        <span class="side-menu_ico side-menu_ico__online-friend"></span>
                        <span class="side-menu_tx">Все</span>
                    </span>
                    <span class="verticalalign-m-help"></span>
                </a>
            </li>
            <li class="side-menu_li" data-bind="css: { active : activeTab() == 1, disabled : friendsOnlineCount() == 0 }">
                <a href="" class="side-menu_i" data-bind="click: function(data, event) { if (friendsOnlineCount() > 0) selectTab(1, data, event) }">
                    <span class="side-menu_i-hold">
                        <span class="side-menu_ico side-menu_ico__online"></span>
                        <span class="side-menu_tx">Кто онлайн</span>
                        <span class="side-menu_count-sub" data-bind="text: friendsOnlineCount()"></span>
                    </span>
                    <span class="verticalalign-m-help"></span>
                </a>
            </li>
            <li class="side-menu_li" data-bind="css: { active : activeTab() > 1 }">
                <a href="" class="side-menu_i" data-bind="click: function(data, event) { if (incomingRequestsCount() > 0) selectTab(2, data, event); else if (outgoingRequestsCount() > 0) selectTab(3, data, event); }">
                    <span class="side-menu_i-hold">
                        <span class="side-menu_ico side-menu_ico__friend-add"></span>
                        <span class="side-menu_tx">Давай дружить</span>
                        <span class="side-menu_count" data-bind="text: incomingRequestsCount, visible: incomingRequestsCount() > 0"></span>
                    </span>
                    <span class="verticalalign-m-help"></span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- /side-menu-->