<div class="popup" id="interestsEdit">
    <a onclick="$.fancybox.close();" class="popup-close" href="javascript:void(0);">закрыть</a>
    <div class="title">Ваши интересы</div>
    <div class="clearfix">
        <div class="nav">
            <ul>
                <?php foreach($categories as $index => $category): ?>
                    <li<?php echo $index == 0 ? ' class="active"' : '' ?>>
                        <a href="javascript:;" onclick="Interest.changeCategory(this);"><?php echo $category->name; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="interests-list">
            <?php foreach($categories as $index => $category): ?>
                <ul<?php echo $index == 0 ? ' class="active"' : '' ?>>
                    <?php foreach($category->interests as $interest): ?>
                        <li>
                            <label class="interest <?php echo $category->css_class; ?>"><?php echo $interest->name; ?></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="bottom">
        <button class="btn btn-green-medium"><span><span>Сохранить</span></span></button>
    </div>

</div>