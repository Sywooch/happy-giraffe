<?php

class m120417_085817_rename_community extends CDbMigration
{
	public function up()
	{
        $this->renameTable('club_community','community__communities');
        $this->renameTable('club_community_content','community__contents');
        $this->renameTable('club_community_content_type','community__content_types');
        $this->renameTable('club_community_photos','community__photos');
        $this->renameTable('club_community_photo_post','community__photo_posts');
        $this->renameTable('club_community_post','community__posts');
        $this->renameTable('club_community_rubric','community__rubrics');
        $this->renameTable('club_community_travel','community__travels');
        $this->renameTable('club_community_travel_image','community__travel_images');
        $this->renameTable('club_community_travel_waypoint','community__travel_waypoints');
        $this->renameTable('club_community_video','community__videos');
	}

	public function down()
	{
		echo "m120417_085817_rename_community does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}