<div class="b-text--center b-margin--bottom_40">
    <a id="addNewQuestionBtn" style="padding: 0" class="disabled btn btn--xl btn--default login-button" href="<?=$this->createUrl('/som/qa/default/pediatricianAddForm/')?>" data-bind="follow: {}">Задать вопрос</a>
</div>
<script type="text/javascript">
$.followBindigsInit = function(){
	$('#addNewQuestionBtn').removeClass('disabled');
};
</script>
