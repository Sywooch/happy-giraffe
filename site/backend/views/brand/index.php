<?php
    $model = new ProductBrand;
?>
<script type="text/javascript">
    $(function () {
        $('form.image_upload').iframePostForm({
            json: true,
            complete: function(response) {
                if (response.status == '1')
                {
                    tr.find('div.fake_file').children().first().replaceWith($('#brand_image').tmpl({url: response.url, title: response.title}));
                }
            }
        });

        $('body').delegate('#ProductBrand_brand_image', 'change', function() {
            tr = $(this).parents('tr');
            $(this).parents('form').submit();
        });

        $('body').delegate('span.add_main_ct', 'click', function () {
            $('table.common_sett').append($('#new_brand_form').tmpl());
            $('html,body').animate({scrollTop: $('#ProductBrand_brand_title').offset().top},'fast');
        });

        $('body').delegate('input[type=button].b_new_catg', 'click', function () {
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("brand/add") ?>',
                data:$(this).parents('form').serialize(),
                type:'POST',
                dataType:'JSON',
                success:function (response) {
                    if (response.status == '1') {
                        tr = $(this).parents('tr');

                        tr.replaceWith($('#new_ct').tmpl({
                            modelPk:response.modelPk,
                            modelName:response.modelName,
                            titleValue:response.attributes.brand_title
                        }));

                        $('form.image_upload').iframePostForm({
                            json: true,
                            complete: function(response) {
                                if (response.status == '1')
                                {
                                    tr.find('div.fake_file').children().first().replaceWith($('#brand_image').tmpl({url: response.url, title: response.title}));
                                }
                            }
                        });
                    }
                },
                context:$(this)
            });

            return false;
        });
    });
</script>
<script id="product_image" type="text/x-jquery-tmpl">
    <a href="#">
        <span>
            <?php echo CHtml::image('${url}', '${title}'); ?>
        </span>
    </a>
</script>
<script id="new_brand_form" type="text/x-jquery-tmpl">
    <tr>
        <td class='name_ct'>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'action' => '#',
            ));
            ?>
            <?php echo $form->textField($model, 'brand_title', array('class' => 't_new_catg')); ?>
            <?php echo CHtml::button('Ok', array('class' => 'b_new_catg')); ?>
            <?php $this->endWidget(); ?>
        </td>
        <td class='logo_ct'>
            <a href='#' class='add_logo' title='Загрузить логотип'>+</a>
        </td>
        <td class='logo_ct' colspan='3'>

        </td>
    </tr>
</script>

<?php $model = new ProductBrand() ?>
<script id="new_ct" type="text/x-jquery-tmpl">
    <tr>
        <td class="name_ct">
            <?php
            $this->widget('EditDeleteWidget', array(
                'deleteButton' => false,
                'modelName' => get_class($model),
                'modelPk' => '${modelPk}',
                'attribute' => 'brand_title',
                'attributeValue'=>'${titleValue}',
                'options' => array(
                    'edit_selector' => 'a',
                    'edit_link_class' => 'no_child',
                    'edit_link_text' => '${titleValue}',
                )
            ));?>
        </td>
        <td class="logo_ct">
            <?php $form = $this->beginWidget('CActiveForm', array(
            'action' => $this->createUrl('uploadImage'),
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
                'class' => 'image_upload',
            ),
        )); ?>
            <?php echo CHtml::hiddenField('ProductBrand[brand_id]', '${modelPk}'); ?>

            <div class="fake_file">
                <?php if ($image = ''): ?>
                <?php echo CHtml::image($image); ?>
                <?php else: ?>
                <a href='#' class='add_logo fake_file' title='Загрузить логотип'> +</a>
                <?php endif; ?>
                <?php echo CHtml::activeFileField($model, 'brand_image'); ?>
            </div>

            <?php $this->endWidget(); ?>
        </td>
        <td class="active_ct">
            <ul>
                <li><a href="#" title="Подробно о бренде">
                    <img src="/images/icons/info_catg_icon.png" alt="Подробно о бренде"/></a></li>
                <li><a href="#" title="Посмотреть в магазине">
                    <img src="/images/icons/view_shop_icon.png" alt="Посмотреть в магазине"/></a></li>
            </ul>
        </td>
        <td class="goods_ct">
            <ul>
                <li>Товаров - <a
                    href="/product/index/brand_id/${modelPk}"><?php echo '0'; ?></a>
                </li>
            </ul>
        </td>
        <td class="sell_ct">
            <ul>
                <li>
                    <ins>Оборот</ins>
                    - 23 256 789
                </li>
                <li>
                    <ins>Прибыль</ins>
                    - 8 363 123
                </li>
            </ul>
        </td>
        <td class="ad_ct">
            <ul>
                <li>
                    <?php
                    $this->widget('OnOffWidget', array(
                        'modelPk' => '${modelPk}',
                        'modelName' => get_class($model),
                        'modelActive' => '${modelActive}',
                    ));
                    ?>
                </li>
                <li>
                    <?php
                    $this->widget('DeleteWidget', array(
                        'modelPk' => '${modelPk}',
                        'modelName' => get_class($model),
                        'modelAccusativeName' => $model->accusativeName,
                        'modelIsTree' => true,
                    ));
                    ?>
                </li>
            </ul>
        </td>
    </tr>
</script>


<div class="centered">
    <h1>Брэнды</h1>

    <div class="search_ct">
        <?php echo CHtml::beginForm(array('brand/index'), 'get'); ?>
        <p>
            <label for="findText">Поиск брэнда</label>
            <input id="findText" type="text" class="search_catg" name='query' value="<?php echo $query ?>"/>
            <input type="button" class="search_subm" value="Найти" onclick="submit();"/>
        </p>
        <?php echo CHtml::endForm(); ?>
    </div>
    <!-- .much_catg -->
    <div class="clear"></div>
    <!-- .clear -->
</div>

<div class="alphabet">
    <p<?php if (empty($query)) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('brand/index', array()) ?>">Все</a></p>
    <ul>
        <?php $alp = array('А','Б','В','Г','Д','Е','Ж','З','И','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х',
        'Ц','Ч','Э','Ю','Я'); ?>
        <?php foreach ($alp as $letter): ?>
        <li<?php if ($query == $letter) echo ' class="active"' ?>><a href="<?php
            echo $this->createUrl('brand/index', array('query'=>$letter)) ?>"><?php echo $letter ?></a></li>
        <?php endforeach; ?>
    </ul>
    <ul>
        <?php $alp = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U',
        'V','W','X','Y','Z'); ?>
        <?php foreach ($alp as $letter): ?>
        <li<?php if ($query == $letter) echo ' class="active"' ?>><a href="<?php
            echo $this->createUrl('brand/index', array('query'=>$letter)) ?>"><?php echo $letter ?></a></li>
        <?php endforeach; ?>
    </ul>
    <div class="clear"></div>
</div>

<!-- .centered -->
<div class="sett_block">
    <table class="common_sett brands">
        <tr>
            <th class="name_ct">
                <span>Название бренда</span>
                <span class="add_main_ct" title="Добавить бренд">+</span>
            </th>
            <th class="logo_ct">Логотип</th>
            <th class="active_ct">Действие</th>
            <th class="goods_ct">Товары</th>
            <th class="sell_ct">
                <span>Продажи <ins>(руб.)</ins></span>
                <ul>
                    <li><a href="#" class="active">д</a></li>
                    <li>|</li>
                    <li><a href="#">н</a></li>
                    <li>|</li>
                    <li><a href="#">м</a></li>
                    <li>|</li>
                    <li><a href="#">г</a></li>
                </ul>
            </th>
            <th class="ad_ct"></th>
        </tr>
        <?php foreach ($brands as $b): ?>
        <?php $this->renderPartial('_tr', array('model' => $b)); ?>
        <?php endforeach; ?>
    </table>
</div>
<!-- .sett_block -->

<?php if ($pages->pageCount > 1): ?>
<div class="pagination pagination-center clearfix">
			<span class="text">
				Показано: <?php echo $pages->currentPage * $pages->pageSize + 1; ?>
                -<?php echo ($pages->currentPage + 1) * $pages->pageSize; ?> из <?php echo $pages->itemCount; ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Страницы:
			</span>
    <?php $this->widget('LinkPager', array(
    'pages' => $pages,
)); ?>
</div>
<?php endif; ?>