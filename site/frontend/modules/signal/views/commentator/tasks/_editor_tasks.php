<div class="block block__pink">
    <div class="block_title">
        <div class="block_title-ico block_title-ico__editor-tasks"></div>
        <div class="block_title-tx">Задачи от редактора</div>
    </div>
    <div class="block_hold">
        <div class="editor-tasks">
            <ul class="editor-tasks_ul" data-bind="foreach: editorTasks">
                <li class="editor-tasks_li">
                    <div class="editor-tasks_hold" data-bind="css: {'editor-tasks_hold__done': closed}">
                        <div class="editor-tasks_ico" data-bind="attr: {'class': 'editor-tasks_ico ' + typeClass() }"></div>
                        <a href="" class="editor-tasks_a" data-bind="text: article_title, attr: {href: article_url}" target="_blank"></a>
                        <!-- ko if: closed() != 1 -->
                        <div class="editor-tasks_new">Новая</div>
                        <!-- /ko -->
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>