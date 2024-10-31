<?php
/**
 * ProsperAdsIndex Controller
 *
 * @package 
 * @subpackage 
 */
class ProsperAdsIndexController
{	
    public function __construct()
    {		
		require_once(PROSPERADS_MODEL . '/Activate.php');
		$prosperActivate = new Model_Ads_Activate();
		
		add_action('widgets_init', array($prosperActivate, 'createWidget'), 4);	
		
		register_activation_hook(PROSPERADS_PATH . PROSPERADS_FILE, array($prosperActivate, 'prosperActivate'));
		register_deactivation_hook(PROSPERADS_PATH . PROSPERADS_FILE, array($prosperActivate, 'prosperDeactivate'));

		add_action('admin_init', array($prosperActivate, 'prosperActivateRedirect'));
		add_action('admin_init', array($prosperActivate, 'prosperCustomAdd'));
		add_action('init', array($prosperActivate, 'doOutputBuffer'));	
		add_action('init', array($prosperActivate, 'init'));
	}
}
 
$prosperAdsIndex = new ProsperAdsIndexController;