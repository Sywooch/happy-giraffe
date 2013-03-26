<a id="showKeywords" href="#popup-keywords" class="fancybox" style="display: none;"></a>
<div style="display: none;">
    <div id="popup-keywords" class="popup popup-keywords" style="display: block;">
        <div id="popup-keyword" class="popup popup-keyword" style="display: block;">
            <div class="popup_hold">

                <!-- ko with: emptyTasks -->
                <!-- ko foreach: tasks -->
                <div class="popup-keyword_i clearfix">
                    <div class="popup-keyword_btn-hold">
                        <a href="" class="btn-green popup-keyword_take" data-bind="click: take">Взять</a>
                    </div>
                    <div class="keyword" data-bind="attr: {'class': 'keyword ' + getClass() }">
                        <div class="keyword_key" data-bind="text: keyword"></div>
                        <div class="keyword_hold">
                            <div class="keyword_count" data-bind="text: keyword_wordstat">></div>
                            <div class="keyword_cat" data-bind="text: wordstatText"></div>
                        </div>
                    </div>
                </div>
                <!-- /ko -->
                <!-- /ko -->

            </div>
        </div>
    </div>
</div>