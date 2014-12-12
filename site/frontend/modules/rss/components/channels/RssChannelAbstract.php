<?php

namespace site\frontend\modules\rss\components\channels;
use site\frontend\modules\rss\components\FeedGenerator;
use site\frontend\modules\rss\components\FeedRenderer;

/**
 * @author Никита
 * @date 12/12/14
 */

abstract class RssChannelAbstract
{
    /** @var \CDataProvider */
    public $dataProvider;

    public function __construct()
    {
        $this->dataProvider = $this->getDataProvider();
    }

    public function render($page)
    {
        $renderer = new FeedRenderer($this);
        $renderer->run($page);
    }

    public function isEmpty()
    {
        return $this->dataProvider->totalItemCount == 0;
    }

    public function getChannelTags()
    {
        return array();
    }

    public function getTitle()
    {
        return null;
    }

    public  function getDescription()
    {
        return null;
    }

    public function getLink()
    {
        return null;
    }

    abstract public function getDataProvider();
    abstract public function getUrl($page = 0);
} 