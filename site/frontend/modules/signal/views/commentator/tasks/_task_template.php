<script type="text/html" id="tasks-template">
    <!-- ko foreach: tasks -->
    <li class="task-list_li clearfix">
        <!-- ko if: !isClosed() -->
        <div class="task-list-add">
            <div class="task-list-add_hold">
                <div class="keyword" data-bind="attr: {'class': 'keyword ' + getClass() }">
                    <div class="keyword_key" data-bind="text: keyword"></div>
                    <div class="keyword_hold">
                        <div class="keyword_count" data-bind="text: keyword_wordstat"></div>
                        <div class="keyword_cat" data-bind="text: wordstatText"></div>
                    </div>
                    <a href="" class="keyword_close" data-bind="click: CancelTask"></a>
                </div>
                <a href="" class="task-list-add_refresh" data-bind="click: replaceTask"></a>
            </div>
            <div class="task-list-add_input">
                <input type="text" name="" id="" class="itx-bluelight task-list-add_itx" placeholder="Введите ссылку на запись" data-bind="value: article_url">
                <button class="btn-green" data-bind="click: confirm">Ok</button>
            </div>
        </div>
        <!-- /ko -->
        <!-- ko if: isClosed() -->
        <a href="" class="task-list_a" data-bind="text: article_title, attr: {href: article_url}" target="_blank"></a>
        <div class="keyword keyword__small" data-bind="attr: {'class': 'keyword keyword__small ' + getClass() }">
            <div class="keyword_key" data-bind="text: keyword"></div>
            <div class="keyword_hold">
                <div class="keyword_count" data-bind="text: keyword_wordstat"></div>
                <div class="keyword_cat" data-bind="text: wordstatText"></div>
            </div>
        </div>
        <!-- /ko -->
    </li>
    <!-- /ko -->
    <!-- ko if: HintIsVisible() -->
    <li class="task-list_li clearfix">
        <a href="" class="task-list_take-hint" data-bind="click: showEmptyTasks">
            <span class="task-list_take-hint-tx">Взять подсказку</span>
        </a>
    </li>
    <!-- /ko -->
</script>