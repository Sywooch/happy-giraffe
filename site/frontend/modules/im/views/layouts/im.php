<?php $this->beginContent('//layouts/club'); ?>
<script type="text/javascript" src="/javascripts/dklab_realplexor.js"></script>
<?php
Yii::app()->clientScript->registerScript('Realplexor-reg', '
        var user_cache = "'. MessageCache::GetCurrentUserCache() .'";
        var last_dialog = "'. ActiveDialogs::model()->getLastDialogId() .'";
        var realplexor = new Dklab_Realplexor(
            "http://'.Yii::app()->comet->host .'",
            "'. Yii::app()->comet->namespace .'"
        );

        realplexor.subscribe(user_cache, function (result, id) {
            console.log(result);
            if (result.type == '. MessageLog::TYPE_NEW_MESSAGE .') {
                if(window.ShowNewMessage)
                    ShowNewMessage(result);
            } else if (result.type == '. MessageLog::TYPE_READ .') {
                if(window.ShowAsRead)
                        ShowAsRead(result);
            }
        });
        realplexor.execute();
');
?>
<div class="main">

    <div class="main-right">

        <div id="dialogs">

            <div class="tabs">

                <div class="header">
                    <div class="container">

                        <div class="clearfix">
                            <div class="search">
                                <form>
                                    <input type="text">
                                    <button class="btn btn-green-smedium"><span><span>Найти</span></span></button>
                                </form>
                            </div>

                            <div class="title">Мои сообщения</div>
                        </div>

                        <div class="nav steps">
                            <ul>
                                <?php
                                $d = ActiveDialogs::model()->getDialogIds();
                                if (!empty($d)):?>
                                    <li class="opened<?php if (Yii::app()->controller->action->id =='dialog') echo ' active'?>">
                                        <a href="<?php echo $this->createUrl('/im/default/dialog', array('id'=>ActiveDialogs::model()->getLastDialogId())) ?>">Открытые диалоги</a></li>
                                <?php endif ?>
                                <li<?php if (Yii::app()->controller->action->id =='index') echo ' class="active"'?>><a href="<?php
                                    echo $this->createUrl('/im/default/index', array()) ?>"><span>Все диалоги</span></a></li>
                                <li<?php if (Yii::app()->controller->action->id =='new') echo ' class="active"'?>>
                                    <a href="<?php echo $this->createUrl('/im/default/new', array()) ?>"><span>Новое</span></a></li>
                                <li<?php if (Yii::app()->controller->action->id =='online') echo ' class="active"'?>>
                                    <a href="<?php echo $this->createUrl('/im/default/online', array()) ?>"><span>Кто в онлайне</span></a></li>
                                <li>
                                    <form action="<?php echo $this->createUrl('/im/default/getDialog') ?>">
                                        <input type="text" value="введите имя" class="placeholder"
                                               placeholder="введите имя" onblur="setPlaceholder(this)"
                                               onfocus="unsetPlaceholder(this)" id="find-user" name="dialog_name"/>
                                        <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                        'name' => 'search_user_autocomplete',
                                        'sourceUrl' => $this->createUrl('/im/default/ajaxSearchByName'),
                                        'value' => '',
                                        'htmlOptions' => array(
                                            'id'=>'find-user'
                                        ),
                                        'options' => array(
                                            'select' => "js: function(event, ui) {
                                                this.value = ui.item.label;
                                                $(\"#find-user\").val(ui.item.label);
                                                return false;
                                            }",
                                            ),
                                        ), true); ?>
                                        <button class="btn btn-green-small" type="submit"><span><span>Ok</span></span></button>
                                    </form>
                                </li>
                            </ul>

                        </div>

                    </div>
                </div>

                <?php echo $content ?>
            </div>

        </div>

    </div>

</div>

<div class="side-right">

    side

</div>
<?php $this->endContent(); ?>