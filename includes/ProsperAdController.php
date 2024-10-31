<?php
/**
 * ProsperAd Controller
 *
 * @package 
 * @subpackage 
 */
class ProsperAdsController
{	
    /**
     * the class constructor
     *
     * @package 
     * @subpackage 
     *
     */
    public function __construct()
    {		
		require_once(PROSPERADS_MODEL . '/Ad.php');
		$prosperAd = new Model_Ads_Ad();

		add_shortcode('perform_ad', array($prosperAd, 'performAdShortCode'));		
		
		if (is_admin())
		{
			add_action('admin_print_footer_scripts', array($prosperAd, 'qTagsAd'));	
		}
    }
}
 
$perfAds = new ProsperAdsController;