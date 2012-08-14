<?php if ($humor): ?>
    <div class="box activity-smile">

        <div class="title">Улыбнись <span>вместе с нами</span> <img src="/images/activity_smile_smile.png" /></div>

        <div class="img">
            <?=CHtml::image($humor->photo->getPreviewUrl(428, 285, Image::WIDTH))?>
        </div>

        <div class="options">
            <?php $this->widget('application.widgets.voteWidget.VoteWidget', array(
                'model'=>$humor,
                'template' => '
                    <a class="option{active2}" vote="2">
                        <span class="text"><span>Ха-ха-ха!</span></span>
                        <span class="value">{vote2}</span>
                    </a>

                    <a class="option{active1}" vote="1">
                        <span class="text"><span>Ха!</span></span>
                        <span class="value">{vote1}</span>
                    </a>

                    <a class="option{active0}" vote="0">
                        <span class="text"><span>:(</span></span>
                        <span class="value">{vote0}</span>
                    </a>
                ',
                'links' => array('.red','.green'),
                'result' => array(
                    0 => array('.option:nth-child(3) > span.value', '.lolok'),
                    1 => array('.option:nth-child(2) > span.value', '.lolok'),
                    2 => array('.option:nth-child(1) > span.value', '.lolok'),
                ),
                'main_selector' => '.options'
            )); ?>
            <?php if (!Yii::app()->user->isGuest && Yii::app()->authManager->checkAccess('manageActivity', Yii::app()->user->id)): ?>
                <br/>
                <br/>
                <?php
                    $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                        'model' => new Humor(),
                    ));
                    $fileAttach->button();
                    $this->endWidget();
                ?>
            <?php endif; ?>
        </div>

    </div>
<?php endif; ?>