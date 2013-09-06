<?php
/**
 * insert Description
 * 
 * @author Alex Kireev <alexk984@gmail.com>
 */

class ServiceController extends HController
{
    public $service_id = 8;
    public $layout = '//layouts/community2';
    public $club;
    public $service;

    public function init()
    {
        $this->service = Service::model()->findByPk($this->service_id);
        $this->club = CommunityClub::model()->findByPk($this->service->community_id);

        parent::init();
    }

}