<?php

class UserCommunitiesWidget extends UserCoreWidget
{
    public $limit = 9;
    private $_communities = array();
    private $_count = 0;

    public function init()
    {
        parent::init();
        $this->_count = count($this->user->communities);
        if ($this->_count != 0) {
            if ($this->_count <= 9)
                $this->_communities = $this->user->communities;
            else{
                $clubs = $this->user->communities;
                //выбираем случайные клубы
                while(count($this->_communities) < 9){
                    shuffle($clubs);
                    $this->_communities[] = array_pop($clubs);
                }
            }
        }
        $this->visible = ($this->isMyProfile && !empty($this->_communities)) || $this->_count >= $this->limit;
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
