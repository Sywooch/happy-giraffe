<?php
/**
 * @var $this DefaultController
 * @var $month string
 * @var $commentators CommentatorWork[]
 * @author Alex Kireev <alexk984@gmail.com>
 */

$data = CommentatorTask::getTaskListForEditor();

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/' . 'script.js', CClientScript::POS_BEGIN);

?>
<div class="block">

    <?php $this->renderPartial('_month_list', array('month' => $month)); ?>

    <!-- ko if: addProcess() == 0 -->
    <div class="task-add clearfix textalign-c"<?php if ($month != date("Y-m")) echo ' style="display:none;"' ?>>
        <a href="" class="btn-green btn-big" data-bind="click: startAddTask">Добавить задачу</a>
    </div>
    <!-- /ko -->

    <!-- ko if: addProcess() == 1 -->
    <!-- ko with: newTask -->
    <div class="task-add clearfix">

        <!-- ko if: page_id() != null -->
        <div class="task-act">
            <div class="task-act_t">Что сделать?</div>
            <a href="" class="task-act_i" data-bind="click: addCommentTask">
                        <span class="task-act_ico-hold">
                            <span class="task-act_ico task-act_ico__comment"></span>
                        </span>
                <span class="task-act_tx">Добавить <br> коммент</span>
            </a>

            <div class="task-act_or"></div>

            <a href="" class="task-act_i" data-bind="click: addLikeTask">
                        <span class="task-act_ico-hold">
                            <span class="task-act_ico task-act_ico__like"></span>
                        </span>
                <span class="task-act_tx">Поставить <br> лайк</span>
            </a>
        </div>
        <!-- /ko -->

        <!-- ko if: page_id() == null -->
        <div class="task-add_itx-hold">
            <input type="text" placeholder="Введите ссылку на страницу" class="itx-bluelight task-add_itx" data-bind="value: article_url">
            <button class="task-add_btn btn-green" data-bind="click: loadPage">Ok</button>
        </div>
        <!-- /ko -->

        <!-- ko if: page_id() != null -->
        <div class="task-add_itx-hold">
            <span class="task-add_a-hold">
                <a href="" class="task-add_a" target="_blank" data-bind="text: article_title, attr:{'href': article_url}"></a>
                <a href="" class="task-add_close" data-bind="click: cancel"></a>
            </span>
        </div>
        <!-- /ko -->
    </div>
    <!-- /ko -->
    <!-- /ko -->

    <!-- ko foreach: days -->
    <div class="task-tb">
        <div class="margin-b10">
            <div class="b-date" data-bind="text: date"></div>
        </div>
        <table class="task-tb_tb">
            <tbody data-bind="foreach:tasks">
            <tr data-bind="attr: {'class': activeClass()}">
                <td class="task-tb_td-ico">
                    <div class="task-tb_ico" data-bind="attr: {'class': 'task-tb_ico '+typeClass()}"></div>
                </td>
                <td class="task-tb_td-a">
                    <a href="" target="_blank" data-bind="attr: {'href': article_url}, text:article_title"></a>
                </td>
                <td class="task-tb_td-playerbar">
                    <a href="" class="task-tb_playerbar"
                       data-bind="click: pause, attr: {'class': 'task-tb_playerbar '+statusClass()}"></a>
                </td>
                <td class="task-tb_td-count">
                    <a href="#popup-commentator-task" class="fancybox task-tb_count color-alizarin" data-bind="text: non_executors.length, click:showExecutors"></a>
                    |
                    <a href="#popup-commentator-task" class="fancybox task-tb_count color-green" data-bind="text: executors.length, click:showExecutors"></a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- /ko -->

    <div style="display: none;">
        <div id="popup-commentator-task" class="popup-commentator-task" style="display: block;">
            <div class="popup_hold tabs">
                <ul class="popup-commentator-task_tabs clearfix">
                    <li class="popup-commentator-task_tabs-li active">
                        <a href="javascript:void(0);" onclick="setTab(this, 1);" class="popup-commentator-task_tab popup-commentator-task_tab__donenone">Не выполнили (<!--ko text: non_executors().length--><!--/ko-->)</a>
                    </li>
                    <li class="popup-commentator-task_tabs-li">
                        <a href="javascript:void(0);" onclick="setTab(this, 2);" class="popup-commentator-task_tab popup-commentator-task_tab__done">Выполнили (<!--ko text: executors().length--><!--/ko-->)</a>
                    </li>
                </ul>
                <div class="popup-commentator-task_b-w tabs-container">
                    <div id="executors_list" class="popup-commentator-task_b tab-box tab-box-1" style="display: block;">
                        <!-- ko foreach: non_executors -->
                        <div class="popup-commentator-task_user">
                            <div class="user-info clearfix">
                                <a class="ava small" href="" target="_blank" data-bind="attr:{'href':getUrl()}"><img data-bind="attr:{'src':ava}"/></a>
                                <div class="user-info_details">
                                    <a class="user-info_username" href="" target="_blank" data-bind="text:name, attr:{'href':getUrl()}"></a>
                                </div>
                            </div>
                        </div>
                        <!-- /ko -->
                    </div>
                    <div id="non_executors_list" class="popup-commentator-task_b tab-box tab-box-2" style="display: none;">
                        <!-- ko foreach: executors -->
                        <div class="popup-commentator-task_user">
                            <div class="user-info clearfix">
                                <a class="ava small" href="" target="_blank" data-bind="attr:{'href':getUrl()}"><img src="" alt="" data-bind="attr:{'src':ava}"/></a>
                                <div class="user-info_details">
                                    <a class="user-info_username" href="" target="_blank" data-bind="text:name, attr:{'href':getUrl()}"></a>
                                </div>
                            </div>
                        </div>
                        <!-- /ko -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script type="text/javascript">
    var commentator_tasks = new CommentatorTasks(<?=CJavaScript::jsonEncode($data) ?>,
        <?=CJavaScript::jsonEncode(CommentatorHelper::getCommentatorsData()) ?>);
    $(function () {
        ko.applyBindings(commentator_tasks)
    });
</script>