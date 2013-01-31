<?php
/**
 * Author: alexk984
 * Date: 31.01.13
 */

$folders = KeywordFolder::getMyFolders();
$favouriteFolder = KeywordFolder::getFavourites();
$strikeOutFolder = KeywordFolder::getStrikeOutFolder();
?>
<ul class="folders">
    <li><a href="">Найдено <span></span></a></li>
    <li><a href="">Что еще искали <span></span></a></li>
    <li>
        <a href="" data-bind="click: showFavourites">Избранное</a>
        <span data-bind="text: favouritesCount"></span>
    </li>
    <li>
        <ul data-bind="foreach: folders" style="margin: 10px 0;">
            <li data-bind="class: color">
                <a class="more" href="" data-bind="text: name">Папка</a>&nbsp;
                <span data-bind="text: count"></span>
            </li>
        </ul>
    </li>
    <li>
        <a href="">Вычеркнутые</a>
        <span data-bind="text: strikedCount"></span>
    </li>
    <li>
        <a href="">Корзина</a>
        <span data-bind="text: removedCount"></span>
    </li>
</ul>



<script type="text/javascript">
    var folders = [
    <?php foreach ($folders as $folder): ?>
        {name:"<?=$folder->name ?>", color:"<?=$folder->color ?>", count: <?=$folder->keywordsCount() ?>},
        <?php endforeach; ?>
    ];

    var SidebarModel = function (folders) {
        this.folders = ko.observableArray(folders);

        this.favouritesCount = <?=$favouriteFolder->keywordsCount() ?>;
        this.strikedCount = <?=$strikeOutFolder->keywordsCount() ?>;
        this.removedCount = <?=KeywordsBlacklist::keywordsCount() ?>;

        this.keywords = [];

        this.showFavourites = function () {
            $.post('/keywords/default/favourites/', {page:1}, function (response) {
                if (response.status) {
                    SidebarModel.keywords = ko.observableArray(response.keywords);
                    //console.log(SidebarModel.keywords);
                }
            }, 'json');
        };
    }

    ko.applyBindings(new SidebarModel(folders));
</script>