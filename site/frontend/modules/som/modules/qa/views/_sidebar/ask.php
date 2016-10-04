<div class="textalign-c">
    <a id="addNewQuestionBtn" class="disabled btn green-btn btn-xl login-button" href="<?=$this->createUrl('/som/qa/default/questionAddForm/')?>" data-bind="follow: {}">Задать вопрос</a>
</div>
<script type="text/javascript">
$.followBindigsInit = function(){
	$('#addNewQuestionBtn').removeClass('disabled');
};
</script>
