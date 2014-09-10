<?php
/**
 * @var $this PhotoController
 * @var $model \site\frontend\modules\photo\models\PhotoAlbum
 */
?>

<div class="b-main_col-hold clearfix">
    <div class="b-crumbs b-crumbs__m">
        <ul class="b-crumbs_ul">
            <li class="b-crumbs_li"><a href="" class="b-crumbs_a">Мои фото</a></li>
            <li class="b-crumbs_li b-crumbs_li__last"><span class="b-crumbs_last"> Создание альбома</span></li>
        </ul>
    </div>
    <!-- Добавление -->
    <div class="postAdd">
        <?php /** @var site\frontend\components\requirejsHelpers\ActiveForm $form */ $form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
            'id' => 'createAlbumForm',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
        )); ?>
        <div class="postAdd_hold margin-t40">
            <div class="postAdd_row">
                <div class="postAdd_count">1</div>
                <div class="postAdd_cont">
                    <div class="inp-valid inp-valid__abs">
                        <?=$form->textField($model, 'title', array('class' => 'itx-gray', 'placeholder' => $model->getAttributeLabel('title')))?>
                        <div class="inp-valid_count">150</div>
                    </div>
                </div>
            </div>
            <div class="postAdd_row">
                <div class="postAdd_count">2</div>
                <div class="postAdd_cont">
                    <div class="inp-valid inp-valid__abs">
                        <?=$form->textArea($model, 'description', array('class' => 'itx-gray', 'placeholder' => $model->getAttributeLabel('description')))?>
                        <div class="inp-valid_count">450</div>
                    </div>
                </div>
            </div>
            <div class="postAdd_row">
                <div class="postAdd_count"></div>
                <div class="postAdd_cont">
                    <div class="postAdd_btns-hold">
                        <a href="<?=Yii::app()->request->urlReferrer?>" class="btn btn-link-gray margin-r15">Отменить</a>
                        <button class="btn btn-success btn-xm disabled">Создать альбом</button>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <!-- /Добавление -->
</div>

<script type="text/javascript">
    function CreateAlbumForm() {
        var self = this;
    }

    ko.applyBindings(new CreateAlbumForm(), $('.postAdd').get(0));
</script>