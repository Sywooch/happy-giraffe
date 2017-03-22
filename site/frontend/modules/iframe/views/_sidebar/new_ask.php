<div class="b-text--center b-col">
    <a id="addNewQuestionBtn" class="disabled btn btn--xl btn--default login-button iframe-login-button" href="<?=$this->createUrl('/iframe/default/pediatricianAddForm/')?>" data-bind="follow: {}">Задать вопрос</a>
</div>
<script type="text/javascript">
$.followBindigsInit = function(){
	$('#addNewQuestionBtn').removeClass('disabled');
};
</script>
