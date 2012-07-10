<?php if (!Yii::app()->user->isGuest && !$c->isFromBlog && Yii::app()->user->model->checkAuthItem('transfer post')):?>
    <script id="transfer_post" type="text/x-jquery-tmpl">
        <div id="movePost" class="popup-confirm popup">
            <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close tooltip" title="Закрыть"></a>

            <div class="confirm-before">
                <form>
                    <div class="move-post">
                        <?php echo CHtml::hiddenField('id', '', array('id' => 'active_post_id')) ?>
                        Выберите клуб и рубрику:<br>
                        <?php echo CHtml::dropDownList('community_id', $c->rubric->community_id, CHtml::listData(Community::model()->findAll(), 'id', 'title'),
                        array(
                            'class' => 'chzn',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajax/rubrics'),
                                'success' => 'function(data){
    							    $("#rubric_id").html(data);
    							    $("#rubric_id").trigger("liszt:updated");
                                }',
                            ),
                            'disabled' => Yii::app()->user->checkAccess('transfer post') ? '' : 'disabled',
                        )
                    ); ?>

                        <?php echo CHtml::dropDownList('rubric_id', $c->rubric_id, CHtml::listData(($c->rubric->community!== null)?$c->rubric->community->rubrics:array(), 'id', 'title'),
                        array(
                            'prompt' => 'Выберите рубрику',
                            'disabled' => Yii::app()->user->checkAccess('transfer post') ? '' : 'disabled',
                            'class' => 'chzn'
                        )
                    ); ?>
                    </div>
                    <div class="bottom">
                        <a href="javascript:void(0);" class="btn btn-gray-medium" onclick="$.fancybox.close();"><span><span>Отменить</span></span></a>
                        <button class="btn btn-green-medium"><span><span>Переместить</span></span></button>
                    </div>
                </form>
            </div>
            <div class="confirm-after">
                <p>Запись успешно пермещена!</p>
            </div>
        </div>
    </script>
<?php endif ?>