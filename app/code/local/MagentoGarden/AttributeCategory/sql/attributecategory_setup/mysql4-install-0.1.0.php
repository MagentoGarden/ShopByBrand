<?php
/**
 * MagentoGarden
 *
 * @category    install
 * @package     magentogarden_attributecategory
 * @copyright   Copyright (c) 2012 MagentoGarden Inc. (http://www.magentogarden.com)
 * @version		1.0
 * @author		MagentoGarden (coder@magentogarden.com)
 */

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('mg_ac_images')};
CREATE TABLE {$this->getTable('mg_ac_images')} (
  `entity_id` int(11) unsigned NOT NULL auto_increment,
  `attribute_id` int(11) unsigned NOT NULL,
  `option_id` int(11) unsigned NOT NULL,
  `image` varchar(255) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('mg_ac_attribute')};
CREATE TABLE {$this->getTable('mg_ac_attribute')} (
  `entity_id` int(11) unsigned NOT NULL auto_increment,
  `attribute_id` int(11) unsigned NOT NULL,
  `enabled` int(11) unsigned NOT NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 