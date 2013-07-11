<?php

class MagentoGarden_Mgsys_Model_Feed_Updates extends MagentoGarden_Mgsys_Model_Feed_Abstract
{
	const XML_USE_HTTPS_PATH = 'mgsys/feed/use_https';
	const XML_FEED_URL_PATH = 'mgsys/feed/url';
	const XML_FREQUENCY_PATH = 'mgsys/feed/check_frequency';
    const XML_FREQUENCY_ENABLE = 'mgsys/feed/enabled';
    const XML_LAST_UPDATE_PATH = 'mgsys/feed/last_update';
	
	/**
     * Retrieve feed url
     *
     * @return string
     */
    public function getFeedUrl()
    {
        if (is_null($this->_feedUrl)) {
            $this->_feedUrl = (Mage::getStoreConfigFlag(self::XML_USE_HTTPS_PATH) ? 'https://' : 'http://')
                              . Mage::getStoreConfig(self::XML_FEED_URL_PATH);
        }
        return $this->_feedUrl;
    }

    /**
     * Checks feed
     * @return
     */
    public function check()
    {
        if ((time() - Mage::app()->loadCache('mgsys_all_updates_feed_lastcheck')) > Mage::getStoreConfig(self::XML_FREQUENCY_PATH)) {
        	// Mage::log('Mgsys: check notification');
            $this->refresh();
        }
    }

    public function refresh()
    {
        $feedData = array();

        try {

            $Node = $this->getFeedData();
			
            if (!$Node) return false;
			
            foreach ($Node->children() as $item) {
                $feedData[] = array(
                    'severity' => 3,
                    'date_added' => $this->getDate((string)$item->date),
                    'title' => (string)$item->title,
                    'description' => (string)$item->content,
                    'url' => (string)$item->url,
                );
            }

            $adminnotificationModel = Mage::getModel('adminnotification/inbox');
            if ($feedData && is_object($adminnotificationModel)) {
                $adminnotificationModel->parse(($feedData));
            }

            Mage::app()->saveCache(time(), 'mgsys_all_updates_feed_lastcheck');
            return true;
        } catch (Exception $E) {
            return false;
        }
    }
}