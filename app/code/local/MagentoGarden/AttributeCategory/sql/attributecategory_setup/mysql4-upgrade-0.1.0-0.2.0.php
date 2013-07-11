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

ALTER TABLE `mg_ac_images` ADD `enabled` INT NOT NULL AFTER `image`;

");

$installer->endSetup(); 