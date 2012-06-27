<?php $this->beginContent('//layouts/main');
$categories = RecipeBookDiseaseCategory::model()->findAll(array('order'=>'id'));
?>
<div id="disease">

    <div class="title">

        <h2>Справочник<span>детских болезней</span></h2>

    </div>

    <div class="clearfix">

        <div class="disease-in">
            <?php echo $content ?>

        </div>

        <div class="disease-categories">

            <ul>
                <li class="<?php if ($this->category_id == 0) echo 'active' ?>">
                    <a class="disease-cat<?php if ($this->category_id == 0) echo ' active' ?>" href="<?= $this->createUrl('default/index') ?>">
                        <i class="icon-disease-cat icon-disease-0"></i>
                        <span>Все заболевания</span>
                    </a>
                </li>
                <?php foreach ($categories as $category): ?>
                <li class="<?php if ($this->category_id == $category->id) echo 'active' ?>">
                    <a href="<?=$this->createUrl('default/category', array('id'=>$category->slug)) ?>" class="disease-cat<?php if ($this->category_id == $category->id) echo ' active' ?>">
                        <i class="icon-disease-cat icon-disease-<?=$category->id ?>"></i>
                        <span><?=$category->title ?></span>
                    </a>
                </li>
                <?php endforeach; ?>

            </ul>

        </div>

    </div>

</div>
<?php $this->endContent(); ?>