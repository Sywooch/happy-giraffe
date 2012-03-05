<?php $this->beginContent('//layouts/main'); ?>

    <div class="section-banner">
        <img src="/images/section_banner_01.png" />
    </div>

    <div class="clearfix">
        <div class="main">
            <div class="main-in">

                <div class="club-fast-nav">

                    <?php
                        $this->widget('zii.widgets.CMenu', array(
                            'items'=>array(
                                array(
                                    'label' => 'Все',
                                    'url' => $this->getUrl(array('content_type_slug' => null)),
                                    'active' => $this->content_type_slug === null,
                                ),
                                array(
                                    'label' => 'Статью',
                                    'url' => $this->getUrl(array('content_type_slug' => 'post')),
                                    'active' => $this->content_type_slug == 'post',
                                ),
                                array(
                                    'label' => 'Путешествие',
                                    'url' => $this->getUrl(array('content_type_slug' => 'travel')),
                                    'active' => $this->content_type_slug == 'travel',
                                    'visible' => $this->community->id == 21,
                                ),
                                array(
                                    'label' => 'Видео',
                                    'url' => $this->getUrl(array('content_type_slug' => 'video')),
                                    'active' => $this->content_type_slug == 'video',
                                ),
                            ),
                        ));
                    ?>

                    <a href="#joinClub" class="club-join-btn fancy">Вступить в клуб</a>

                </div>

                <?php echo $content; ?>

            </div>
        </div>

        <div class="side-left">

            <div class="club-fast-add">
                <a href="" class="btn btn-green"><span><span>Добавить</span></span></a>
                <?php
                    $this->widget('zii.widgets.CMenu', array(
                        'items'=>array(
                            array(
                                'label' => 'Статью',
                                'url' => $this->getUrl(array('content_type_slug' => 'post'), 'community/add'),
                            ),
                            array(
                                'label' => 'Путешествие',
                                'url' => array('community/addTravel'),
                                'visible' => $this->community->id == 21,
                            ),
                            array(
                                'label' => 'Видео',
                                'url' => $this->getUrl(array('content_type_slug' => 'video'), 'community/add'),
                            ),
                        ),
                    ));
                ?>
            </div>

            <div class="club-topics-list">
                <?php
                    $items = array();
                    foreach ($this->community->rubrics as $r) {
                        $items[] = array(
                            'label' => $r->name,
                            'url' => $this->getUrl(array('rubric_id' => $r->id)),
                            'active' => $r->id == $this->rubric_id,
                        );
                    }

                    $this->widget('zii.widgets.CMenu', array(
                            'items' => $items,
                        )
                    );
                ?>
                <form>
                    <input type="text" />
                    <button class="btn btn-green-small"><span><span>Ок</span></span></button>
                </form>
                <a href="" class="add"><i class="icon"></i></a>
            </div>

        </div>
    </div>

    <div class="push"></div>

<?php $this->endContent(); ?>