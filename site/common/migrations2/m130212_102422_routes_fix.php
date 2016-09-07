<?php

class m130212_102422_routes_fix extends CDbMigration
{
    private $_table = 'routes__routes';

    public function up()
    {
        $this->addColumn($this->_table, 'active', 'tinyint(3) not null default 0');

        $sql = <<<EOD
CREATE TABLE IF NOT EXISTS `routes__rosn_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) unsigned NOT NULL,
  `name` varchar(256) NOT NULL,
  `region_id` int(10) unsigned NOT NULL,
  `distance` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `city_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`),
  KEY `region_id` (`region_id`),
  KEY `route_id` (`route_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1018944 ;

ALTER TABLE `routes__rosn_points`
  ADD CONSTRAINT `routes__rosn_points_route` FOREIGN KEY (`route_id`) REFERENCES `routes__routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `routes__rosn_points_city` FOREIGN KEY (`city_id`) REFERENCES `geo__city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `routes__rosn_points_region` FOREIGN KEY (`region_id`) REFERENCES `geo__region` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

EOD;
        $this->execute($sql);
    }

    public function down()
    {
        echo "m130212_102422_routes_fix does not support migration down.\n";
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