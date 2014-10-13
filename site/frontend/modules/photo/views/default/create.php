<?php
$this->pageTitle = 'Как выбрать ' ;

$this->breadcrumbs = array(
    'мои фото' => array('/photo/default/create'),
    'Создание фотоальбома',
);
?>

        <!-- Добавление -->
        <div class="postAdd">
            <div class="postAdd_hold margin-t40">
                <div class="postAdd_row">
                    <div class="postAdd_count">1</div>
                    <div class="postAdd_cont">
                        <div class="inp-valid inp-valid__abs">
                            <input type="text" placeholder="Заголовок альбома" class="itx-gray">
                            <div class="inp-valid_count">150</div>
                        </div>
                    </div>
                </div>
                <div class="postAdd_row">
                    <div class="postAdd_count">2</div>
                    <div class="postAdd_cont">
                        <div class="inp-valid inp-valid__abs">
                            <textarea rows="5" cols="40" placeholder="Описание альбома" class="itx-gray"></textarea>
                            <div class="inp-valid_count">450</div>
                        </div>
                    </div>
                </div>
                <div class="postAdd_row">
                    <div class="postAdd_count"></div>
                    <div class="postAdd_cont">
                        <div class="postAdd_btns-hold"><a href="" class="btn btn-link-gray margin-r15">Отменить</a><a href="" class="btn btn-success btn-xm disabled">Создать альбом</a></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Добавление -->
