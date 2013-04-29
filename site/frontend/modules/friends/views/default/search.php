<?php
    Yii::app()->clientScript
        ->registerScriptFile('/javascripts/knockout-2.2.1.js')
        ->registerScriptFile('/javascripts/ko_friendsSearch.js')
    ;
?>

<div class="content-cols">
    <div class="col-1">
        <h2 class="col-1_t"> Найти друзей
            <div class="col-1_sub-t"><a href="" class="">Мои друзья</a></div>
        </h2>
        <div class="aside-filter">
            <?=CHtml::beginForm(array('friends/default/search'), 'get', array('id' => 'findFriendsForm', 'onclick' => 'findFriends()'))?>
                <div class="aside-filter_search clearfix">
                    <input type="text" name="query" class="aside-filter_search-itx" placeholder="Введите имя и/или фамилию" data-bind="value: query, valueUpdate: 'keyup'">
                    <button class="aside-filter_search-btn" data-bind="css: { active : query() != '' }, click: clearQuery"></button>
                </div>
                <div class="aside-filter_sepor"></div>
                <div class="aside-filter_row">
                    <div class="aside-filter_t">Местоположение</div>
                    <input type="radio" name="location" id="location1" class="aside-filter_radio" checked>
                    <label for="location1" class="aside-filter_label-radio">везде</label>
                    <input type="radio" name="location" id="location2" class="aside-filter_radio">
                    <label for="location2" class="aside-filter_label-radio">указать где</label>
                </div>
                <div class="aside-filter_sepor"></div>
                <div class="aside-filter_row">
                    <div class="aside-filter_t">Пол</div>
                    <input type="radio" name="b-radio2" id="radio3" class="aside-filter_radio" checked>
                    <label for="radio3" class="aside-filter_label-radio">
                        все
                    </label>
                    <input type="radio" name="b-radio2" id="radio4" class="aside-filter_radio" checked>
                    <label for="radio4" class="aside-filter_label-radio">
                        <span class="ico-male"></span>
                    </label>
                    <input type="radio" name="b-radio2" id="radio5" class="aside-filter_radio">
                    <label for="radio5" class="aside-filter_label-radio">
                        <span class="ico-female"></span>
                    </label>
                </div>
                <div class="aside-filter_sepor"></div>
                <div class="aside-filter_row margin-b20">
                    <div class="aside-filter_t">Возраст</div>
                    <div class="aside-filter_label">от</div>
                    <div class="chzn-bluelight chzn-textalign-c w-75">
                        <select class="chzn">
                            <option selected="selected">0</option>
                            <option>1</option>
                            <option>2</option>
                            <option>32</option>
                            <option>32</option>
                            <option>32</option>
                            <option>32</option>
                            <option>132</option>
                            <option>132</option>
                            <option>132</option>
                        </select>
                    </div>
                    <div class="aside-filter_label">до</div>
                    <div class="chzn-bluelight chzn-textalign-c w-75">
                        <select class="chzn">
                            <option selected="selected">0</option>
                            <option>1</option>
                            <option>2</option>
                            <option>32</option>
                            <option>32</option>
                            <option>32</option>
                            <option selected='selected'>32</option>
                            <option>132</option>
                            <option>132</option>
                            <option>132</option>
                        </select>
                    </div>
                </div>
                <div class="aside-filter_sepor"></div>
                <div class="aside-filter_row  margin-b20">
                    <div class="aside-filter_t">Семейное положение</div>
                    <div class="chzn-bluelight">
                        <select class="chzn">
                            <option selected="selected">женат / замужем</option>
                            <option>женат / замужем</option>
                            <option>женат / замужем</option>
                            <option>женат / замужем</option>
                        </select>
                    </div>
                </div>
                <div class="aside-filter_sepor"></div>
                <div class="aside-filter_row">
                    <div class="aside-filter_t">Дети</div>
                    <div class="margin-b10 clearfix">
                        <input type="radio" name="b-radio3" id="radio6" class="aside-filter_radio" checked>
                        <label for="radio6" class="aside-filter_label-radio">не имеет значения</label>
                    </div>
                    <div class="margin-b10 clearfix">
                        <input type="radio" name="b-radio3" id="radio7" class="aside-filter_radio">
                        <label for="radio7" class="aside-filter_label-radio">срок беременности (недели)</label>
                        <div class="aside-filter_toggle">
                            <div class="aside-filter_label">от</div>
                            <div class="chzn-bluelight chzn-textalign-c w-75">
                                <select class="chzn">
                                    <option selected="selected">0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>32</option>
                                    <option>32</option>
                                    <option>32</option>
                                    <option>32</option>
                                    <option>132</option>
                                    <option>132</option>
                                    <option>132</option>
                                </select>
                            </div>
                            <div class="aside-filter_label">до</div>
                            <div class="chzn-bluelight chzn-textalign-c w-75">
                                <select class="chzn">
                                    <option selected="selected">0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>32</option>
                                    <option>32</option>
                                    <option>32</option>
                                    <option selected='selected'>32</option>
                                    <option>132</option>
                                    <option>132</option>
                                    <option>132</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="margin-b10 clearfix">
                        <input type="radio" name="b-radio3" id="radio8" class="aside-filter_radio">
                        <label for="radio8" class="aside-filter_label-radio">возраст ребенка (лет)</label>
                        <div class="aside-filter_toggle">
                            <div class="chzn-bluelight chzn-textalign-c w-75">
                                <select class="chzn">
                                    <option selected="selected">0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>32</option>
                                    <option>32</option>
                                    <option>32</option>
                                    <option>32</option>
                                    <option>132</option>
                                    <option>132</option>
                                    <option>132</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="margin-b10 clearfix">
                        <input type="radio" name="b-radio3" id="radio9" class="aside-filter_radio">
                        <label for="radio9" class="aside-filter_label-radio">многодетная семья</label>
                        <div class="aside-filter_toggle">
                            <div class="chzn-bluelight chzn-textalign-c w-75">
                                <select class="chzn">
                                    <option selected="selected">0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>32</option>
                                    <option>32</option>
                                    <option>32</option>
                                    <option>32</option>
                                    <option>132</option>
                                    <option>132</option>
                                    <option>132</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="aside-filter_sepor"></div>
                <div class="aside-filter_row clearfix">
                    <button class="aside-filter_reset"><span class="aside-filter_reset-tx">Сбросить параметры</span></button>
                    <button class="btn-h46 btn-gold float-r">Найти</button>
                </div>
            <?=CHtml::endForm()?>
        </div>
    </div>

    <div class="col-23 clearfix">

        <div class="friends-list">
            <?php
                $this->widget('zii.widgets.CListView', array(
                    'id' => 'friendsList',
                    'dataProvider' => $dp,
                    'itemView' => '_friend',
                    'template' => "{items}\n{pager}",
                    'pager' => array(
                        'class' => 'application.components.InfinitePager.InfinitePager',
                        'selector' => '#friendsList .items',
                        'options' => array(
                            'behavior' => 'local',
                            'binder' => new CJavaScriptExpression("$('.layout-container')"),
                            'itemSelector' => '.friends-list_i',
                            'loading' => array(
                                'selector' => '.friends-list',
                            ),
                        ),
                    ),
                ));
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        vm = new FriendsSearchViewModel();
        ko.applyBindings(vm);
    });
</script>