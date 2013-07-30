<?php
/**
 * @var User $user
 */
?><?php if ($this->isMyProfile):?>
    <div class="about-self" id="user-about">
        <h3 class="heading-small margin-b5">О себе
            <!-- ko if: canEdit() -->
            <a href="" class="a-pseudo-icon"><span class="ico-edit"></span><span class="a-pseudo-icon_tx">Редактировать</span></a>
            <!-- /ko -->
        </h3>
        <div class="about-self_ctn">

            <!-- ko if: about.length == 0 -->
            <a href="" class="a-pseudo-grayblue">Напишите пару слов о себе</a>
            <!-- /ko -->

            <!-- ko if: about.length != 0 -->
            <?=$user->about ?>
            <!-- /ko -->

        </div>
    </div>
    <script type="text/javascript">
        function UserAboutWidget(about) {
            var self = this;
            self.about = ko.observable(about);
            self.editMode = ko.observable(false);

            self.edit = function() {
                self.editMode(true);
            };

            self.canEdit = ko.computed(function () {
                return self.about.length != 0 && !self.editMode();
            });

            self.accept = function() {
                $.post('/friends/requests/decline/', { requestId : self.id }, function(response) {
                    if (response.success) {
                        self.removed(true);
                        parent.incomingRequestsCount(parent.incomingRequestsCount() - 1);
                    }
                }, 'json');
            };

            self.decline = function() {
                $.post('/friends/requests/decline/', { requestId : self.id }, function(response) {
                    if (response.success) {
                        self.removed(true);
                        parent.incomingRequestsCount(parent.incomingRequestsCount() - 1);
                    }
                }, 'json');
            }
        }

        $(function() {
            vm = new UserAboutWidget(<?=CJSON::encode($user->about)?>);
            ko.applyBindings(vm, document.getElementById('user-about'));
        });
    </script>
<?php else: ?>
    <div class="about-self">
        <h3 class="heading-small margin-b5">О себе</h3>
        <div class="about-self_ctn"><?=$user->about ?></div>
    </div>
<?php endif ?>