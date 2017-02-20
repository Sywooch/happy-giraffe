<!-- ko if: $data.isSpecialistAnswer -->
<li class="questions_item clearfix">
    <div class="clearfix">
        <div class="questions-modification__avatar awatar-wrapper awatar-wrapper--theme-pediator pediator-answer__left--style">
            <a class="awatar-wrapper__link ava__b-pink" data-bind="href: user.profileUrl, css: 'ava__' + ((user.gender == '1') ? 'male' : 'female')">
                <img alt="" src="" class="awatar-wrapper__img" data-bind="src: user.avatarUrl">
            </a>
        </div>
        <div class="pediator-answer__right pediator-answer__right-active">
            <div class="box-wrapper__user box-wrapper__user-mod margin-b0">
                <a class="box-wrapper__link" data-bind="text: user.fullName, href: user.profileUrl"></a>
                <time datetime="" class="tx-date" data-bind="attr: { datetime: moment.unix(dtimeCreate).format('YYYY-MM-DD') }, moment: dtimeCreate"></time>
            </div>
            <div class="box-wrapper__user margin-b0">
                <span class="display-ib font__color--crimson margin-t2 margin-b3" data-bind="text: user.specialistInfo.title"></span>
            </div>
            <div class="box-wrapper__header box-header">
                <p class="box-header__text height-auto" data-bind="html: text, visible: ! isRemoved()"></p>
                <div class="answers-list_item_text-block_text" data-bind="visible: isRemoved()">
                    <a data-bind="click: restore">Восстановить</a>
                </div>
            </div>
        </div>
        <div class="pediator-answer__right pediator-answer__right--theme-pediator">
            <div class="box-wrapper__footer clearfix">
                <div class="answers-list_item_like-block usefull margin-l0" data-bind="click: $parent.vote.bind($parent, $data), css: { usefull: isVoted }, visible: canVote">
                    <div class="answers-list_item_like-block_like"></div>
                    <div class="like_counter">Спасибо <span data-bind="text: votesCount"></span></div>
                </div>
                <!-- ko if: !$data.hasChild -->
                <span class="js-answers__qustions answers__qustions answers__qustions--ico" data-bind="click: $parent.beginEdit, visible: $parent.additionalAvailable">Еще вопрос</span>
                <!-- ko if: beingEdited -->
                <form class="pediator-answer margin-t20">
						<textarea
                            id="js-answer-form_textarea"
                            placeholder="Введите ваш ответ"
                            class="answer-form_textarea"
                            data-bind="wswgHG: { config: {
		                            minHeight: 88,
		                            plugins: ['imageCustom', 'smilesModal', 'videoModal'],
		                            class: '1232',
		                            toolbarExternal: '#add-post-toolbar-2',
		                            callbacks: {
		                                
		                            }
		                        }, attr: $parent.answerText}"
                        >
			        	</textarea>
                    <div class="pediator-answer__footer clearfix">
                        <div class="pediator-answer__footer--item pediator-answer__footer--left">
                            <div id="add-post-toolbar-2"></div>
                        </div>
                        <div class="pediator-answer__footer--item pediator-answer__footer--right margin-t7">
                            <span class="btn btn-ms btn-secondary margin-r10" data-bind="click: $parent.cancelEdit">Отменить</span>
                            <span class="btn btn-ms green-btn" data-bind="click: $parent.addAnswer">Сохранить</span>
                        </div>
                    </div>
                </form>
                <!-- /ko -->
                <!-- /ko -->
            </div>
            <!-- ko if: $data.hasChild -->
            <div class="pediator-answer__full float-l" data-bind="template: {foreach: $parent.additionalAnswer($data.id), name: 'additional'}"></div>
            <!-- /ko -->
        </div>
    </div>
</li>
<!-- /ko -->
<!-- ko ifnot: $data.isSpecialistAnswer -->
<li class="answers-list_item" data-bind="visible: ! isRemoved() || ($parent.currentUser() && ($parent.currentUser().id == $data.authorId))">
    <a class="ava ava__middle" data-bind="href: user.profileUrl, css: 'ava__' + ((user.gender == '1') ? 'male' : 'female')">
        <img alt="" src="" class="ava_img" data-bind="src: user.avatarUrl">
    </a>
    <div class="username">
        <a data-bind="text: user.fullName, href: user.profileUrl"></a>
        <time datetime="" class="tx-date" data-bind="attr: { datetime: moment.unix(dtimeCreate).format('YYYY-MM-DD') }, moment: dtimeCreate"></time>
    </div>
    <div class="answers-list_item_text-block" data-bind="attr: { style: (user.specialistInfo && user.specialistInfo.title) ? 'background-color: #feebf6; border-radius: 7px;' : '' }">
        <div class="answers-list_item_text-block_text" data-bind="html: text, visible: ! isRemoved()">
        
        </div>
        <div class="answers-list_item_text-block_text" data-bind="visible: isRemoved()">
            <a data-bind="click: restore">Восстановить</a>
        </div>
    </div>
    <div class="clearfix"></div>
    
    <div class="answers-list_item_like-block usefull" data-bind="click: $parent.vote.bind($parent, $data), css: { usefull: isVoted }, visible: canVote">
        <div class="answers-list_item_like-block_like"></div>
        <!-- ko ifnot: categoryId == pediatricianCategoryId -->
        <div class="like_counter">Полезный ответ <span data-bind="text: votesCount, visible: votesCount() > 0"></span></div>
        <!-- /ko -->
        <!-- ko if: categoryId == pediatricianCategoryId -->
        <div class="like_counter">Спасибо <span data-bind="text: votesCount, visible: votesCount() > 0"></span></div>
        <!-- /ko -->
    </div>
    
    <div class="comments_footer" data-bind="visible: ! isRemoved() && (canEdit || canRemove)">
        <!-- b-control-->
        <div class="b-control">
            <div class="b-control_i b-control_i__delete" data-bind="click: remove, visible: canRemove"><span class="b-control_ico"></span><span class="b-control_tx">Удалить</span>
            </div>
            <div class="b-control_i b-control_i__edit" data-bind="click: $parent.beginEdit, visible: canEdit"><span class="b-control_ico"></span><span class="b-control_tx">Редактировать</span>
            </div>
        </div>
        <!-- /b-control-->
    </div>
    
    <!-- ko if: beingEdited -->
    <div class="comments_i clearfix">
        <div class="comments_ava">
            <a class="ava ava__middle ava__small-sm-mid" data-bind="href: $parent.currentUser().profileUrl">
                <img alt="" class="ava_img" data-bind="src: $parent.currentUser().avatarUrl">
            </a>
        </div>
        <div class="comments_frame">
            <div class="redactor-control">
                <div class="redactor-control_toolbar clearfix"></div>
                <div class="redactor-control_hold">
                    <textarea cols="40" name="redactor" rows="1" autofocus="autofocus" class="redactor" data-bind="wswgHG: { config : $parent.editorConfig, attr : editText }"></textarea>
                </div>
            </div>
        </div>
        <div class="btn btn-success btn-s" data-bind="click: $parent.edit.bind($parent, $data)">Редактировать</div>
    </div>
    <!-- /ko -->
</li>
<!-- /ko -->