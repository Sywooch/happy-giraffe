<input type="hidden" value="" class="baby-id">
<div class="data clearfix">
    <div class="d-text">Имя <?=$i ?>-го ребенка:</div>

    <div class="name">
        <div class="text" style="display:none;"></div>
        <div class="input">
            <input type="text">
            <button class="btn btn-green-small" onclick="Family.saveBabyName(this);"><span><span>Ok</span></span></button>
        </div>
        <a href="javascript:void(0);" onclick="Family.editBabyName(this)" class="edit" style="display:none;"><span class="tip">Редактировать имя</span></a>
    </div>

    <div style="display:none;" class="hide-on-start">
        <a href="javascript:void(0);" onclick="Family.saveBabyGender(this, 1)" class="gender male"><span class="tip">Мальчик</span></a>
        <a href="javascript:void(0);" onclick="Family.saveBabyGender(this, 0)" class="gender female"><span class="tip">Девочка</span></a>

        <div style="display:none;" class="hide-on-start">
            <div class="age">

            </div>
            <div class="date">
                <a href="javascript:void(0);" onclick="Family.editDate(this);" class="date"><span class="tip">Укажите дату рождения</span></a>
                <div class="datepicker" style="display:none;">
                    <div class="tale"></div>
                    <?php echo CHtml::dropDownList('Baby_d_'.$i, '', array(''=>' ')+HDate::Days(), array(
                    'class'=>'chzn w-50 date',
                    'data-placeholder'=>' '
                )) ?>
                    &nbsp;
                    <?php echo CHtml::dropDownList('Baby_m_'.$i, '', array(''=>' ')+HDate::ruMonths(), array(
                    'class'=>'chzn w-100 month',
                    'data-placeholder'=>' '
                )) ?>
                    &nbsp;
                    <?php echo CHtml::dropDownList('Baby_y_'.$i, '', array(''=>' ')+HDate::Range(date('Y')-16, date('Y') - 100), array(
                    'class'=>'chzn w-50 year',
                    'data-placeholder'=>' '
                )) ?>
                    &nbsp;
                    <button class="btn btn-green-small" onclick="Family.saveBabyDate(this)"><span><span>Ok</span></span></button>
                </div>
            </div>

            <a href="javascript:void(0);" onclick="Family.editBabyNotice(this)" class="comment" ><span class="tip">Расскажите о нем</span></a>
            <a href="javascript:void(0);" class="photo"><span class="tip">Добавить 4 фото</span></a>
        </div>

    </div>
</div>

<div class="comment" style="display:none;">
    <div class="input">
        <div class="tale"></div>
        <textarea></textarea>
        <button class="btn btn-green-small" onclick="Family.saveBabyNotice(this)"><span><span>Ok</span></span></button>
    </div>
    <div class="text"><span class="text"></span> <a href="javascript:void(0);" onclick="Family.editBabyNotice(this)" class="edit"><span class="tip">Редактировать комментарий</span></a></div>
</div>

<div class="photos" style="display:none;">
    <ul>
        <li>
            <img src="/images/example/ex3.jpg">
            <a href="" class="remove"></a>
        </li>
        <li>
            <img src="/images/example/ex4.jpg">
            <a href="" class="remove"></a>
        </li>
        <li class="add">
            <a href="">
                <i class="icon"></i>
                <span>Загрузить еще<br> 2 фотографии</span>
            </a>
        </li>
    </ul>
</div>