<?php
/*
Plugin Name: ProsperAds
Description: Place ProsperAds inside widgets and content.
Version: 1.5
Author: Prosperent Brandon
Author URI: http://prosperent.com
Plugin URI: http://community.prosperent.com/forumdisplay.php?35-Wordpress-Plugin-Suite
License: GPLv3

    Copyright 2012  Prosperent Brandon  (email : brandon@prosperent.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Default caching time for products (in seconds)
if (!defined( 'PROSPERADS_CACHE_PRODS'))
    define( 'PROSPERADS_CACHE_PRODS', 604800 );
// Default caching time for trends and coupons (in seconds)
if (!defined( 'PROSPERADS_CACHE_COUPS'))
    define( 'PROSPERADS_CACHE_COUPS', 3600 );

if (!defined( 'WP_CONTENT_DIR'))
    define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if (!defined('PROSPERADS_URL'))
    define('PROSPERADS_URL', plugin_dir_url(__FILE__));
if (!defined('PROSPERADS_PATH'))
    define('PROSPERADS_PATH', plugin_dir_path(__FILE__));
if (!defined('PROSPERADS_BASENAME'))
    define('PROSPERADS_BASENAME', plugin_basename(__FILE__));
if (!defined('PROSPERADS_FOLDER'))
    define('PROSPERADS_FOLDER', plugin_basename(dirname(__FILE__)));
if (!defined('PROSPERADS_FILE'))
    define('PROSPERADS_FILE', basename((__FILE__)));
if (!defined('PROSPERADS_CACHE'))
	define('PROSPERADS_CACHE', WP_CONTENT_DIR . '/prosperent_cache');
if (!defined('PROSPERADS_INCLUDE'))
	define('PROSPERADS_INCLUDE', PROSPERADS_PATH . 'includes');
if (!defined('PROSPERADS_MODEL'))
	define('PROSPERADS_MODEL', PROSPERADS_INCLUDE . '/models');
if (!defined('PROSPERADS_WIDGET'))
	define('PROSPERADS_WIDGET', PROSPERADS_INCLUDE . '/widgets');
if (!defined('PROSPERADS_VIEW'))
	define('PROSPERADS_VIEW', PROSPERADS_INCLUDE . '/views');
if (!defined('PROSPERADS_IMG'))
	define('PROSPERADS_IMG', PROSPERADS_URL . 'includes/img');
if (!defined('PROSPERADS_JS'))
	define('PROSPERADS_JS', PROSPERADS_URL . 'includes/js');
if (!defined('PROSPERADS_CSS'))
	define('PROSPERADS_CSS', PROSPERADS_URL . 'includes/css');
if (!defined('PROSPERADS_THEME'))
	define('PROSPERADS_THEME', WP_CONTENT_DIR . '/prosperent-themes');

//error_reporting(0);   
	
require_once(PROSPERADS_INCLUDE . '/ProsperIndexController.php');

if(is_admin())
{
	require_once(PROSPERADS_INCLUDE . '/ProsperAdminController.php');
}

