<?php
/**
 * ProsperAdmin Controller
 *
 * @package 
 * @subpackage 
 */
class ProsperAdsAdminController
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
		add_action('admin_menu', array($this, 'registerSettingsPage' ), 5);
		add_action( 'network_admin_menu', array( $this, 'registerNetworkSettingsPage' ) );
		
		require_once(PROSPERADS_MODEL . '/Admin.php');
		$prosperAdmin = new Model_Ads_Admin();
		
		add_action( 'admin_init', array( $prosperAdmin, 'optionsInit' ) );
		add_action( 'admin_enqueue_scripts', array( $prosperAdmin, 'prosperAdminCss' ));	
		add_action( 'init', array( $prosperAdmin, 'init' ), 20 );
		add_filter( 'plugin_action_links', array( $prosperAdmin, 'addActionLink' ), 10, 2 );
	}
		
	/**
	 * Register the menu item and its sub menu's.
	 *
	 * @global array $submenu used to change the label on the first item.
	 */
	public function registerSettingsPage() 
	{
		add_menu_page(__('ProsperAds Settings', 'prosperent-suite'), __( 'ProsperAds', 'prosperent-suite' ), 'manage_options', 'prosperads_general', array( $this, 'generalPage' ), PROSPERADS_IMG . '/prosperentWhite.png' );	
		add_submenu_page('prosperads_general', __( 'ProsperAds', 'prosperent-suite' ), __( 'ProsperAds', 'prosperent-suite' ), 'manage_options', 'prosper_prosperAds', array( $this, 'performancePage' ) );
		add_submenu_page('prosperads_general', __( 'Advanced Options', 'prosperent-suite' ), __( 'Advanced', 'prosperent-suite' ), 'manage_options', 'prosperads_advanced', array( $this, 'advancedPage' ));
		
		global $submenu;
		if (isset($submenu['prosperads_general']))
			$submenu['prosperads_general'][0][0] = __('General Settings', 'prosperent-suite' );
		
	}	
		
	/**
	 * Register the settings page for the Network settings.
	 */
	function registerNetworkSettingsPage() 
	{
		add_menu_page( __('ProsperAds Settings', 'prosperent-suite'), __( 'Prosperent', 'prosperent-suite' ), 'delete_users', 'prosperads_general', array( $this, 'networkConfigPage' ), PROSPERADS_IMG . '/prosperentWhite.png' );
	}
		
	/**
	 * Loads the form for the network configuration page.
	 */
	function networkConfigPage() 
	{
		require_once(PROSPERADS_VIEW . '/prosperadmin/network-phtml.php' );
	}
	
	/**
	 * Loads the form for the general settings page.
	 */
	public function generalPage() 
	{
		if ( isset( $_GET['page'] ) && 'prosperads_general' == $_GET['page'] )
			require_once( PROSPERADS_VIEW . '/prosperadmin/general-phtml.php' );
	}	
	
	/**
	 * Loads the form for the performance ads page.
	 */
	public function performancePage() 
	{
		if ( isset( $_GET['page'] ) && 'prosper_prosperAds' == $_GET['page'] )
			require_once( PROSPERADS_VIEW . '/prosperadmin/ads-phtml.php' );
	}

	/**
	 * Loads the form for the product search page.
	 */
	public function advancedPage() 
	{	
		if ( isset( $_GET['page'] ) && 'prosperads_advanced' == $_GET['page'] )
			require_once( PROSPERADS_VIEW . '/prosperadmin/advanced-phtml.php' );
	}	
}
 
$prosperAdsAdmin = new ProsperAdsAdminController;