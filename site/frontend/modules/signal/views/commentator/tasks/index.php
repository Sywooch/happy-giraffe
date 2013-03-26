<?php
/* @var $this CommentatorController
 */

$next_post = $this->commentator->getNextComment();
$data = array(
    'comments' => array(
        'count' => $this->commentator->getCurrentDay()->comments,
        'url' => $next_post->getUrl(),
        'title' => $next_post->title,
    ),
    'blog' => $this->commentator->blogPosts(),
    'club' => $this->commentator->clubPosts(),
)?>
<?php $this->renderPartial('tasks/_editor_tasks'); ?>

<div class="block">
    <div class="block_title">
        <div class="block_title-ico block_title-ico__blog"></div>
        <div class="block_title-tx">Написать запись в блог</div>
        <div class="block_title-subtx">(min 1 запись)</div>
    </div>
    <div class="block_hold">
        <div class="task-list">
            <ul class="task-list_ul" data-bind="template: {name: 'tasks-template', data: blogTasks}"></ul>
        </div>
    </div>
</div>
<div class="block">
    <div class="block_title">
        <div class="block_title-ico block_title-ico__blog"></div>
        <div class="block_title-tx">Написать запись в клуб</div>
        <div class="block_title-subtx">(min 2 записи)</div>
    </div>
    <div class="block_hold">
        <div class="task-list">
            <ul class="task-list_ul" data-bind="template: {name: 'tasks-template', data: clubsTasks}"></ul>
        </div>
    </div>
</div>


<div class="block" data-bind="with: nextComment">
    <div class="block_title">
        <div class="block_title-ico block_title-ico__comment"></div>
        <div class="block_title-tx">Написать 100 комментариев</div>
        <div class="block_title-count">
            <div class="block_title-count-in" data-bind="style: { width: progress()}"></div>
        </div>
        <div class="block_title-count-tx" data-bind="text:count"></div>
    </div>
    <div class="block_hold">
        <div class="task-list">
            <ul class="task-list_ul">
                <li class="task-list_li clearfix">
                    <a href="" class="task-list_a" target="_blank" data-bind="text: title, attr: {href: url}"></a>
                    <a href="" class="task-list_skip" data-bind="click: skip">Пропустить</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php $this->renderPartial('tasks/_task_template'); ?>
<?php $this->renderPartial('tasks/keywords'); ?>
<script type="text/javascript">
    var panel = new CommentatorPanel(<?=CJavaScript::jsonEncode($data) ?>);
    $(function () {
        ko.applyBindings(panel)
    });
</script>