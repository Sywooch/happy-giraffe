<?php $this->beginContent('//layouts/community'); ?>

<div class="content-cols clearfix">
    <div class="col-1">

        <?php $this->renderPartial('application.modules.community.views.default._users2'); ?>

        <div class="sidebar-search sidebar-search__gray clearfix">
            <?=CHtml::beginForm(array('search'), 'get')?>
            <input type="text" placeholder="Поиск из <?=CookRecipe::model()->count()?> рецептов" class="sidebar-search_itx" name="query">
            <button class="sidebar-search_btn"></button>
            <?=CHtml::endForm()?>
        </div>

        <div class="menu-simple">
            <ul class="menu-simple_ul">
                <?php foreach (CActiveRecord::model($this->modelName)->types as $id => $label): ?>
                    <li class="menu-simple_li<?php if ($this->currentType == $id): ?> active<?php endif; ?>">
                        <?=HHtml::link($label, $this->getTypeUrl($id), array('class' => 'menu-simple_a'), true)?>
                        <div class="menu-simple_count"><?=isset($this->counts[$id]) ? $this->counts[$id] : 0?></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php if ($this->action->id == 'view'): ?>
            <div class="banner">
                <script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Giraffe - new -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:240px;height:400px"
                     data-ad-client="ca-pub-3807022659655617"
                     data-ad-slot="4550457687"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-23-middle ">


        <div class="clearfix margin-r20 margin-b20">
            <a href="<?=$this->createUrl('/cook/recipe/add')?>" class="btn-blue btn-h46 float-r">Добавить рецепт</a>
        </div>
        <div class="col-gray">

            <?=$content?>

        </div>
    </div>
</div>

<?php $this->endContent(); ?>