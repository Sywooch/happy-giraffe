<div id="spices">

    <div class="title">

        <h2>Приправы <span>и специи</span></h2>

    </div>

    <div class="clearfix">

        <div class="spices-in">

            <h1>Приправы и специи <?=$model->title; ?></h1>

            <div class="clearfix">
                <div class="cat-img"><img src="<?=isset($model->photo) ? $model->photo->getPreviewUrl(370, 500, Image::WIDTH) : '' ?>"/></div>

                <div class="wysiwyg-content"><?=$model->content; ?></div>
            </div>

            <div class="spices-abc clearfix">

                <div class="block-title">Приправы и специи</div>

                <?php
                $qnty = count($model->spices);
                $per_column = ceil($qnty / 4);
                $i = 1;
                ?>
                <ul>
                    <li>
                        <ul>
                            <?php
                            foreach ($model->spices as $spice) {
                                ?>

                                <li><a href="<?=$this->createUrl('view', array('id' => $spice->slug));?>"><?=$spice->title;?></a></li>

                                <?php
                                if (($i % $per_column) == 0)
                                    echo "</ul></li><li><ul>";
                                $i++;
                            }
                            ?>
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