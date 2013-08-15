<?php
    $message = new Message;
?>

<div id="user-dialogs" class="clearfix">

    <div class="header">

        <div class="title">
            <span>Мои диалоги</span>
        </div>

        <div class="nav">
            <ul id="user-dialogs-nav">
                <li<?php if ($allCount == 0): ?> class="disabled"<?php endif; ?>><a onclick="Messages.setList(0);" href="javascript:void(0)">Все</a><span class="count" id="user-dialogs-allCount"><?=$allCount?></span></li>
                <li<?php if ($newCount == 0): ?> class="disabled"<?php endif; ?>><a onclick="Messages.setList(1);" href="javascript:void(0)">Новые</a><span class="count" id="user-dialogs-newCount"><?=$newCount?></span></li>
                <li<?php if ($onlineCount == 0): ?> class="disabled"<?php endif; ?>><a onclick="Messages.setList(2);" href="javascript:void(0)">Кто в онлайне</a><span class="count" id="user-dialogs-onlineCount"><?=$onlineCount?></span></li>
                <li<?php if ($friendsCount == 0): ?> class="disabled"<?php endif; ?>><a onclick="Messages.setList(3);" href="javascript:void(0)">Друзья на сайте</a><span class="count" id="user-dialogs-friendsCount"><?=$friendsCount?></span></li>
            </ul>
        </div>

        <div class="search">
            <input type="text" placeholder="Найти по имени" onkeyup="Messages.filterList($(this).val()); $(this).next().toggleClass('icon-clear', $(this).val() != '');" />
            <a href="javascript:void(0)" class="icon-search" onclick="$(this).prev().val(''); Messages.filterList('');"></a>
        </div>

        <a href="javascript:void(0)" class="close" onclick="Messages.close();">Закрыть диалоги</a>

    </div>

    <div class="contacts">

        <div class="list">

            <ul id="user-dialogs-contacts">



            </ul>

        </div>

        <?php if ($wantToChat): ?>
            <div class="wannachat clearfix">

                <div class="block-title">
                    <span>Хотят общаться</span>
                </div>

                <ul>
                    <?php foreach ($wantToChat as $u): ?>
                        <?php
                            $class = 'ava small';
                            if ($u->gender !== null) $class .= ' ' . (($u->gender) ? 'male' : 'female');
                        ?>
                        <li><?=CHtml::link(CHtml::image($u->getAvatarUrl(24)), $u->url, array('class' => $class))?></li>
                    <?php endforeach; ?>
                </ul>

            </div>
        <?php endif; ?>

    </div>

    <div class="dialog">

        <div id="user-dialogs-dialog">



        </div>

        <div class="dialog-input clearfix">

            <?=CHtml::beginForm('/im/message/', 'post', array(
                'id' => 'user-dialogs-form',
                'onsubmit' => 'Messages.sendMessage(); return false;',
            ))?>

                <div class="input"><textarea placeholder="Введите ваше сообщение" onclick="Messages.showInput();"></textarea></div>
                <div class="wysiwyg">
                    <?php
                        $this->widget('ext.ckeditor.CKEditorWidget', array(
                            'model' => $message,
                            'attribute' => 'text',
                            'config' => array(
                                'width' => 506,
                                'height' => 56,
                                'toolbar' => 'Chat',
                                'resize_enabled' => false,
                            ),
                        ));
                    ?>
                </div>

                <div class="btn"><button>Отправить сообщение</button></div>

            <?=CHtml::endForm()?>

        </div>

    </div>

</div>

<div style="display: none;">
    <div class="upload-btn">
        <?php
        $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
            'model' => $message,
        ));
        $fileAttach->button();
        $this->endWidget();
        ?>
    </div>
</div>

<script id="newTmpl" type="text/x-jquery-tmpl">
    {{if number != 0}}
    <span class="new">${number} ${noun}</span>
    {{/if}}
</script>