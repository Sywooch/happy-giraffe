<?php
$this->beginContent('//layouts/lite/main');
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <?php
        echo $content;
        ?>
        <aside class="b-main_col-sidebar visible-md">
            <?php $this->beginWidget('AdsWidget', array('dummyTag' => 'adfox')); ?>
            <div class="bnr-base">
                <div id="adfox_1488276558162881"></div>
                <script type="text/javascript">
                    require(['AdFox'], function() {
                        window.Ya.adfoxCode.create({
                            ownerId: 211012,
                            containerId: 'adfox_1488276558162881',
                            params: {
                                pp: 'dey',
                                ps: 'bkqy',
                                p2: 'etcx'
                            }
                        });
                    });
                </script>
            </div>
            <?php $this->endWidget(); ?>

        </aside>
    </div>
</div>
<?php
$this->endContent();
