<?php
/**
 * Base Abstract Model
 *
 * @package Model
 */
abstract class Model_Ads_Base
{
	protected $_options;
	
	protected $_version;
	
	public $widget;
	
	public function init()
	{
		$this->_options = $this->getOptions();
		$this->_version = $this->getVersion();
	
		if ($this->_options['Api_Key'] && strlen($this->_options['Api_Key']) == 32)
		{ 		
			add_action('wp_head', array($this, 'prosperHeaderScript'));
			require_once(PROSPERADS_INCLUDE . '/ProsperAdController.php');				
		}
		else
		{
			add_action( 'admin_notices', array($this, 'prosperBadSettings' ));
		}	
	}
	
	public function getVersion()
	{
		if ( ! function_exists( 'get_plugins' ) )
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			
		$pluginFolder = get_plugins('/' . PROSPERADS_FOLDER);				
		return $pluginFolder[PROSPERADS_FILE]['Version'];
	}

	/**
	 * Retrieve all the options
	 *
	 * @return array of options
	 */
	public function getOptions($option = null)
	{
		if (!isset($this->_options))
		{
			$this->_options = array();
			foreach ($this->getProsperOptionsArray() as $opt)
			{ 
				$this->_options = array_merge($this->_options, (array) get_option($opt));
			}
		}

		return $this->_options;
	}
	
	public function setWidget($widget)
	{
		$this->widget = (string) $widget;
        return $this;
	}
	
	public function getWidget()
	{
		return $this->widget;
	}
	
	public function createWidget()
	{
		$widgets = array();
		$widgets[] = 'ProsperAdsWidget';		
				
		foreach ($widgets as $widget)
		{
			require_once(PROSPERADS_WIDGET . '/' . $widget . '.php');
			register_widget($widget);
		}		
	}
		
	public function prosperBadSettings()
	{			
		if ( isset( $_GET['page'] ) && 'prosperads_general' == $_GET['page'] )
		{
			$url = admin_url( 'admin.php?page=prosperads_general' );
			echo '<div class="error" style="padding:6px 0;">';
			echo _e( '<span style="font-size:14px; padding-left:10px;">Your <strong>API Key</strong> is either incorrect or missing. </span></br>', 'my-text-domain' );
			echo _e('<span style="font-size:14px; padding-left:10px;">Please enter your <strong>Prosperent API Key</strong>.</span></br>', 'my-text-domain' ); 
			echo _e('<span style="font-size:14px; padding-left:10px;">Go to the Prosperent Suite <a href="' . $url . '">General Settings</a> and follow the directions to get your API Key.</span>', 'my-text-domain' );
			echo '</div>';		
		}
	}	
	
	/**
	 * Retrieve an array of all the options the plugin uses. It can't use only one due to limitations of the options API.
	 *
	 * @return array of options.
	 */
	public function getProsperOptionsArray()
	{
		$optarr = array('prosperSuite', 'prosper_performAds', 'prosper_advanced');
        return apply_filters( 'prosper_options', $optarr );
	}
	
	public function shortCodeExtract($atts, $shortcode)
	{	
		return shortcode_atts(array(
			'q'      => '', // query
			'utt'    => 0, // use Title as Topics
			'utg'    => 0, // use Tags as Topics
			'h'      => 90, // height
			'w'      => 'auto',	// width	
			'c'      => 0, // use coupons, deprecated
			'b'      => '', // brand
			'm'      => '', // merchant
			'l'      => 1, // limit
			'cl'     => '', // comparison limit, deprecated
			'ct'     => 'US', // country
			'id'     => '',  // product/catalog id	
			'gtm'    => 0, // go to merchant
			'v'      => 'list', // view
			'w'	     => '', // width
			'ws'     => 'px', // width style (px, em, %)
			'css'    => '', // additional css
			'state'  => '', // state
			'city'   => '', // city 
			'z'	 	 => '', // zipCode
			'ft'  	 => 'fetchProducts', // fetch method
			'sale'   => 0, // on sale products only
			'gimgsz' => 200	 // grid image size		
		), $atts, $shortcode);
	}
	
	/**
	 * Flush the rewrite rules.
	 */
	public function prosperFlushRules()
	{
		flush_rewrite_rules();
	}	
	
	public function prosperCustomAdd()
	{
		// Add only in Rich Editor mode
		if (get_user_option('rich_editing') == 'true')
		{
			add_filter('mce_external_plugins', array($this, 'prosperTinyRegister'));
			add_filter('mce_buttons', array($this, 'prosperTinyAdd'));
		}
	}
	
	public function prosperTinyRegister($plugin_array)
	{		
		if (get_bloginfo('version') >= 3.9)
		{
			$plugin_array['prosperads'] = PROSPERADS_JS . '/prosperent3.9.min.js?ver=' . $this->_version;
		}
		else
		{
			$plugin_array['prosperads'] = PROSPERADS_JS . '/prosperent.min.js?ver=' . $this->_version;
		}
		return $plugin_array;
	}	
	
	public function prosperTinyAdd($buttons)
	{
		array_push( $buttons, '|', 'prosperads');
		return $buttons;
	}
	
	public function qTagsProsper($id, $display, $arg1, $arg2)
	{
		?>
		<script type="text/javascript">
			QTags.addButton(<?php echo "'" . $id . "', '" . $display . "', '" . $arg1 . "', '" . $arg2 . "'"; ?>);
		</script>
		<?php
	}
	
	public function doOutputBuffer()
	{
		ob_start();
	}
	
	public function prosperHeaderScript()
	{				
		echo '<script type="text/javascript">var _prosperent={"campaign_id":"' . $this->_options['Api_Key'] . '", "pa_active":' . ($this->_options['Enable_PA'] ? 1 : 0) . ', "platform":"wordpress"};</script><script async type="text/javascript" src="http://prosperent.com/js/prosperent.js"></script>';
	}
}
