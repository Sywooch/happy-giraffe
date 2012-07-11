<?php $this->beginContent('//layouts/main');

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript
    ->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD)
    ->registerCssFile('/stylesheets/baby.css');
$this->meta_description = 'Познакомьтесь с нашим новым сервисом, который называется Народная медицина: рецепты наших пользователей. Здесь вы можете найти проверенные народные рецепты от разных болезней и поделиться своими';
?>
<div id="baby">
    <div class="inner">
    <div class="content-box clearfix">
        <div class="baby_recipes_service">
            <ul class="handbook_changes_u">
                <li<?php if (Yii::app()->controller->index == true) echo ' class="current_t"' ?>><a href="<?php echo $this->createUrl('index') ?>">Главная</a>
                </li>
                <li><a id="disease-alphabet" href="#"><span>Болезни по алфавиту</span></a></li>
                <li><a id="disease-type" href="#"><span>Болезни по типу</span></a></li>
            </ul>
            <div class="handbook_alfa_popup" id="popup" style="display: none;">

            </div>
        </div>
    </div>
    <?php echo $content ?>
    </div>
</div>
<?php $this->endContent(); ?>