<?php

$cs = Yii::app()->clientScript;

$wysiwyg_js = <<<JS
    $('.wysiwyg-redactor-v').redactorHG({
        plugins: ['toolbarVerticalFixed'],
        minHeight: 410,
        autoresize: true,
        buttons: ['bold', 'italic', 'underline', 'deleted', 'h2', 'h3', 'unorderedlist', 'orderedlist', 'link_add', 'link_del', 'image', 'video', 'smile']
    });
JS;

$js = <<<JS
    var BlogFormPostViewModel = function(data) {
        var self = this;
        ko.utils.extend(self, new BlogFormViewModel(data));
    };
JS;

$js .= "ko.applyBindings(new BlogFormPostViewModel(" . CJSON::encode($json) . "), document.getElementById('popup-user-add-blog'));";

if ($cs->useAMD) 
{
    $cs->registerAMD('wysiwyg-old', array('wysiwyg_old' => 'wysiwyg_old'), $wysiwyg_js);
    $cs->registerAMD('add-post', array('ko' => 'knockout', 'ko_post' => 'ko_post'), $js);
} 
else 
{
    $cs->registerScript('wysiwyg-old', $wysiwyg_js, ClientScript::POS_READY);
    $cs->registerScript('add-post', $js, ClientScript::POS_READY);
}

?>

<?php

$action = $model->isNewRecord ? array('/blog/default/save') : array('/blog/default/save', 'id' => $model->id);

$form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
    'id'     => 'blog-form',
    'action' => $action,
    'enableAjaxValidation'   => true,
    'enableClientValidation' => true,
    'clientOptions' => [
        'validateOnSubmit' => true,
        'validateOnType'   => true,
        'validationDelay'  => 400,
    ],
)); 

echo $form->hiddenField($model, 'type_id');

?>

<script>

$('.wysiwyg-redactor-v').promise().done(function() 
{
    setTimeout(function() 
    {
    	$('#popup-user-add-blog').css('visibility', 'visible');
    }, 500);
});

</script>

<style>
    .popup-user-add-record{
        position: relative;
        width: 720px;
    }
    .wysiwyg-v .wysiwyg-toolbar-btn{
        padding-top: 0;
    }
    @media screen and (max-width: 767px){
        .popup-user-add-record{
            width: 450px;
        }
        .wysiwyg-v .redactor_editor{
            width: 100%;
            min-height: 200px !important;
            margin-left: 0 !important;
        }

        .wysiwyg-v .wysiwyg-toolbar{
            float: none;
        }
        .wysiwyg-v .redactor_toolbar{
            width: 100%;
            padding: 0 !important;
        }
        .wysiwyg-v .redactor_editor:focus{
            margin-left: 0!important;
        }
        .wysiwyg-v .redactor_toolbar li{
            float: none;
            display: inline-block;
            vertical-align: middle;
            margin: 0 15px;
            padding: 0;
        }
        .b-settings-blue{
            padding: 15px;
        }
        .b-settings-blue__article .b-settings-blue_head{
            padding-left: 0;
        }
        .b-settings__header{
            padding: 15px;
        }
    }
    @media screen and (max-width: 480px){
        .popup-user-add-record{
            width: 315px;
        }
    }
</style>

<input type="hidden" name="formKey" value="<?php echo \site\frontend\components\FormDepartmentModelsControl::getInstance()->createNewFormKey(); ?>">

<div id="popup-user-add-blog" class="popup-user-add-record" style="visibility: hidden">
	<a onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть" class="popup-transparent-close popup-transparent-close_mod"></a>
 	<div class="clearfix">
        <div class="popup_mod">
          	<div class="b-settings__header clearfix">
            	<div class="b-settings__title float-l">Добавить запись</div>
          	</div>
          	<div class="b-settings-blue b-settings-blue__article b-settings-blue_mod">
                <div class="b-settings-blue_head">
                 	<div class="b-settings-blue_row clearfix">
                    	<div class="float-l f">
                        	 <?php echo $form->textField($model, 'title', ['class' => 'itx-simple itx-simple_mod', 'placeholder' => 'Введите заголовок']); ?>
                             <?php echo $form->error($model, 'title'); ?>
                    	</div>
                  	</div>
                </div>
                <div class="wysiwyg-v wysiwyg-blue clearfix">
                	<?php $slaveModel->text = $slaveModel->forEdit->text; ?>
                	
                    <?php echo $form->textArea($slaveModel, 'text', ['class' => 'wysiwyg-redactor-v']); ?>
                    
                    <div class="margin-l59"><?php echo $form->error($slaveModel, 'text'); ?></div>
                </div>
                <div class="clearfix">
                	<button class="btn-blue btn-h46 float-r btn-inactive">Опубликовать</button>
            	</div>
          	</div>
        </div>
  	</div>
</div>

<?php $this->endWidget(); ?>