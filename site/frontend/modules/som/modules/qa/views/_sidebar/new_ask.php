<div class="b-text--center b-margin--bottom_40">
    <a id="addNewQuestionBtn" class="disabled btn btn--xl btn--default login-button" href="<?=$this->createUrl('/som/qa/default/questionAddForm/')?>" data-bind="follow: {}">Задать вопрос</a>
</div>
<script type="text/javascript">
$.followBindigsInit = function(){
	$('#addNewQuestionBtn').removeClass('disabled');
};
</script>
