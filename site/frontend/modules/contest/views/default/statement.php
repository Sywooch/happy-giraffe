<div id="takeapartPhotoContest">
					
    <div class="content-title">Я хочу участвовать в фотоконкурсе</div>

    <form>
        <div class="form">

            <a class="fancy" href="#photoPick.v2">второй вариант загрузки</a>

            <div class="a-right upload-file">
                <?php
                $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                    'model' => $model,
                ));
                    $fileAttach->button();
                $this->endWidget();
                ?>
            </div>

            <div class="row">
                <div class="row-title">Название фото</div>
                <div class="row-elements"><input type="text" value=""></div>
            </div>

            <div class="clear"></div>

            <div style="text-align:left;" class="form-bottom">
                <label><input type="checkbox"> Я согласен с</label> <a href="">Правилами конкурса</a>
                <button class="btn btn-gray-medium"><span><span>Участвовать<i class="arr-r"></i></span></span></button>
            </div>

        </div>
    </form>

</div>