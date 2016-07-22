<?php $this->beginContent('//layouts/lite/main'); ?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <div class="b-main_col-article">
            <?= $content ?>
        </div>
        <aside class="b-main_col-sidebar visible-md">
            <div class="side-block rubrics">
                <div class="side-block_tx">Рубрики</div>
                <ul>
                    <?php foreach (CActiveRecord::model($this->modelName)->types as $id => $label): ?>
                        <li class="rubrics_li">
                            <?=HHtml::link($label, $this->getTypeUrl($id), array('class' => 'rubrics_a'), true) ?>
                            <div class="rubrics_count"><span class="rubrics_count_tx"><?=isset($this->counts[$id]) ? $this->counts[$id] : 0 ?></span></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php $this->renderPartial('application.modules.community.views.default._users2'); ?>

            <?php /* Убираем поиск
              <div class="sidebar-search sidebar-search__gray clearfix">
              <?=CHtml::beginForm(array('search'), 'get')?>
              <input type="text" placeholder="Поиск из <?=CookRecipe::model()->count()?> рецептов" class="sidebar-search_itx" name="query">
              <button class="sidebar-search_btn"></button>
              <?=CHtml::endForm()?>
              </div> */ ?>
        </aside>
    </div>
</div>

<?php $this->endContent(); ?>