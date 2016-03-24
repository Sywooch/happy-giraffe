<div class="questions-categories">
    <?php $this->widget('site\frontend\modules\som\modules\qa\widgets\categories\MyQuestionsMenu', array(
        'userId' => Yii::app()->user->id,
        'categoryId' => $categoryId,
    )); ?>
</div>