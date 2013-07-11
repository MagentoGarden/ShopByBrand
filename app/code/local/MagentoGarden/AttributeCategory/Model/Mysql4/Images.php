<?php
/**
 * MagentoGarden
 *
 * @category    model
 * @package     magentogarden_attributecategory
 * @copyright   Copyright (c) 2012 MagentoGarden Inc. (http://www.magentogarden.com)
 * @version		1.0
 * @author		MagentoGarden (coder@magentogarden.com)
 */

class MagentoGarden_AttributeCategory_Model_Mysql4_Images extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the attributecategory_id refers to the key field in your database table.
        $this->_init('attributecategory/mg_ac_images', 'entity_id');
    }
}