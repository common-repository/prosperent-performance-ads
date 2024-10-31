<?php
require_once(PROSPERADS_MODEL . '/Base.php');
/**
 * Base Abstract Model
 *
 * @package Model
 */
class Model_Ads_Activate extends Model_Ads_Base
{
	protected $_options;
	
	public function prosperActivate()
	{
		$this->_options = $this->getOptions();
		
		$this->prosperDefaultOptions();		
		$this->prosperOptionActivateAdd();
	}
	
	public function prosperDeactivate()
	{		
		return;
	}
	
	public function prosperOptionActivateAdd() 
	{
		add_option('prosperAdsActivationRedirect', true);
	}

	public function prosperActivateRedirect() 
	{
		if (get_option('prosperAdsActivationRedirect', false)) 
		{
			delete_option('prosperAdsActivationRedirect');
			if(!isset($_GET['activate-multi']))
			{
				wp_redirect( admin_url( 'admin.php?page=prosperads_general' ) );
			}
		}
	}
	
	public function prosperDefaultOptions()
	{
		if (!is_array(get_option('prosperSuite')))
		{
			$opt = array(
				'Target' => 1
			);	
			update_option('prosperSuite', $opt);
		}

		if (!is_array(get_option('prosper_performAds')))
		{
			$opt = array(
				'Enable_PA'   => 1,
				'Remove_Tags' => ''
			);		
			update_option( 'prosper_performAds', $opt );
		}
	}
}
