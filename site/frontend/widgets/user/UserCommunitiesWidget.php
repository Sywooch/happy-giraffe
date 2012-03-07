<?php

class UserCommunitiesWidget extends UserCoreWidget
{
    public $limit;
    private $_communities = array();
    private $_count = 0;

    public function init()
    {
        parent::init();
        $this->_count = $this->user->communitiesCount;
        if ($this->_count != 0) {
            $this->_communities = $this->user->getRelated('communities', false, array(
                'limit' => $this->limit,
                'order' => 'RAND()',
            ));
        }
        $this->visible = !empty($this->_communities);
    }

    public function run()
    {
        if ($this->visible) {
            $this->render(get_class($this), array(
                'user' => $this->user,
                'communities' => $this->_communities,
                'count' => $this->_count,
            ));
        }
    }
}
