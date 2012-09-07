<div class="family-member" style="display:none;" id="baby-<?=$i?>">

    <input type="hidden" value="" class="baby-id">

    <div class="member-title"><?=$i?>-<?=HDate::govnokod($i)?> ребенок:</div>

    <div class="data clearfix">
        <div class="d-text">Имя ребенка:</div>
        <div class="name">
            <div class="text" style="display:none;"></div>
            <div class="input">
                <input type="text">
                <button class="btn btn-green-small" onclick="Family.saveBabyName(this);"><span><span>Ok</span></span></button>
            </div>
            <a href="javascript:void(0);" onclick="Family.editBabyName(this)" class="edit tooltip" style="display:none;" title="Редактировать имя"></a>
        </div>
    </div>
</div>