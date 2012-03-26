<div class="add-nav default-nav clearfix">
    <div class="content-title">Добавить в блог:</div>
    <ul>
        <li class="active"><a href="">Запись</a></li>
        <li><a href="">Видео</a></li>
    </ul>
</div>

<div class="main">
    <div class="main-in">

        <?php $form = $this->beginWidget('CActiveForm'); ?>
            <div class="form row-form clearfix">

                <?php if ($model->type_id == 1): ?>
                    <div class="row clearfix">
                        <div class="row-title">Заголовок:</div>
                        <div class="row-elements">
                            <?php echo $form->textField($model, 'name', array('class' => 'w-400')); ?>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="row-title">Текст:</div>
                        <div class="row-elements">
                            <img src="/images/editor.gif" />
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($model->type_id == 2): ?>
                    <div class="row clearfix">
                        <div class="row-title">Заголовок:</div>
                        <div class="row-elements">
                            <input type="text" class="w-400"/>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="row-title">Ссылка на видео:</div>
                        <div class="row-elements">
                            <input type="text" class="w-400"/>
                            <div class="row-note">
                                <div class="tale"></div>
                                <p><span class="mdash">&mdash;</span>Вы можете разместить видео с YouTube и RuTube</p>
                            </div>

                        </div>
                    </div>

                    <div class="row clearfix test-video w-400">
                        <div class="row-title">
                            <div class="img">
                                <img src="http://i2.ytimg.com/vi/1H8s0Xthr-8/default.jpg" />
                                <a href="" class="remove"></a>
                            </div>
                            Проверить ролик? <a href="" class="btn btn-green-small"><span><span>ДА</span></span></a>
                            <p class="small w-200">В случае, если ссылка добавилась некорректно, вы сможете изменить ее до добавления</p>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="row-title">Комментарий к видео:</div>
                        <div class="row-elements">
                            <img src="/images/editor.gif" />
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row clearfix">
                    <div class="row-title">Рубрика:</div>
                    <div class="row-elements">
                        <div class="select-box">
                            <select class="chzn w-200">
                                <option>Рубрика 1</option>
                                <option>Рубрика 2</option>
                                <option>Рубрика 3</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row row-buttons">
                    <button class="btn btn-gray-medium"><span><span>Отменить</span></span></button>
                    <button class="btn btn-yellow-medium"><span><span>Предпросмотр</span></span></button>
                    <button class="btn btn-green-medium"><span><span>Добавить</span></span></button>
                </div>

            </div>
        <?php $this->endWidget(); ?>

    </div>
</div>

<div class="side-left">

    <center><img src="/images/img_blog_add.png" /></center>

</div>