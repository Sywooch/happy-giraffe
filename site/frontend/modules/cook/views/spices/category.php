<div id="spices">

    <div class="title">

        <h2>Приправы <span>и специи</span></h2>

    </div>

    <div class="clearfix">

        <div class="spices-in">

            <h1>Приправы и специи <?=$model->title; ?></h1>

            <div class="clearfix">
                <div class="cat-img"><img src="<?=isset($model->photo)?$model->photo->getOriginalUrl():'' ?>"/></div>

                <div class="wysiwyg-content"><?=$model->content; ?></div>
            </div>

            <div class="spices-abc clearfix">

                <div class="block-title">Приправы и специи</div>

                <ul>

                    <li>
                        <ul>
                            <?php $i = 0;$col = 1;foreach ($model->spices as $spice): ?>
                            <?php if ($i > $col * (count($model->spices)/4) ): ?>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <?php endif; ?>
                            <li>
                                <a href="<?=$this->createUrl('view', array('id' => $spice->slug)) ?>"><?=$spice->title ?></a>
                            </li>
                            <?php $i++ ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                </ul>

            </div>

        </div>

        <div class="spices-categories">
            <?php $this->renderPartial('_categories', array('model' => $model)); ?>
        </div>

    </div>

</div>