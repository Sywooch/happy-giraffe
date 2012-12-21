<?php if($this->vote): ?>
<span>Ваша оценка:</span>
<div class="rating setRating" onmouseout="setRatingOut(this);">
    <span onmouseover="setRatingHover(this, 1);" onclick="setRating(this,1);"></span>
    <span onmouseover="setRatingHover(this, 2);" onclick="setRating(this,2);"></span>
    <span onmouseover="setRatingHover(this, 3);" onclick="setRating(this,3);"></span>
    <span onmouseover="setRatingHover(this, 4);" onclick="setRating(this,4);"></span>
    <span onmouseover="setRatingHover(this, 5);" onclick="setRating(this,5);"></span>
    <?php echo $form->hiddenField($comment_model, 'rating'); ?>
</div>
<br/>
<?php endif; ?>