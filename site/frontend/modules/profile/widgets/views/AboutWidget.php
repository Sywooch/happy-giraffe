<?php
/**
 * @var User $user
 */
?><?php if ($this->isMyProfile):?>
    <div class="about-self" id="user-about">
        <h3 class="heading-small margin-b5">О себе
            <!-- ko if: canEdit() -->
            <a href="" class="a-pseudo-icon"><span class="ico-edit"></span><span class="a-pseudo-icon_tx" data-bind="click: edit">Редактировать</span></a>
            <!-- /ko -->
        </h3>
        <div class="about-self_ctn">

            <!-- ko if: !editMode() -->
                <!-- ko if: about().length == 0 -->
                <a href="" class="a-pseudo-grayblue" data-bind="click: edit">Напишите пару слов о себе</a>
                <!-- /ko -->

                <!-- ko if: about().length != 0 -->
                    <!--ko text: about--><?=$user->about ?><!--/ko-->
                <!-- /ko -->
            <!-- /ko -->

            <!-- ko if: editMode() -->

            <textarea name="" id="" cols="30" rows="" class="about-self_textarea" placeholder="Введите текст" data-bind="value: new_about"></textarea>
            <div class="clearfix">
                <a href="" class="btn-blue margin-r10" data-bind="click: accept">Добавить</a>
                <a href="" class="btn-gray-light" data-bind="click: decline">Отменить</a>
            </div>

            <!-- /ko -->

        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            vm = new UserAboutWidget(<?=CJSON::encode((string)$user->about)?>);
            ko.applyBindings(vm, document.getElementById('user-about'));
        });
    </script>
<?php else: ?>
    <div class="about-self">
        <h3 class="heading-small margin-b5">О себе</h3>
        <div class="about-self_ctn"><?=$user->about ?></div>
    </div>
<?php endif ?>