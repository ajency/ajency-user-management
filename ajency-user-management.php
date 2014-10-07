<?php
/**
 * Ajency User Management
 *
 * Everything from registration, forgot password, user activation, role and capabilities, user level backups, restores etc...
 *
 * @package   ajency-user-management
 * @author    Team Ajency <team@ajency.in>
 * @license   GPL-2.0+
 * @link      http://ajency.in
 * @copyright 10-1-2014 Ajency.in
 *
 * @wordpress-plugin
 * Plugin Name: Ajency User Management
 * Plugin URI:  http://ajency.in
 * Description: Everything from registration, forgot password, user activation, role and
 * 				capabilities, user level backups, restores etc...
 * Version:     0.1.0
 * Author:      Team Ajency
 * Author URI:  http://ajency.in
 * Text Domain: ajency-user-management-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if (!defined("WPINC")) {
	die;
}

//include all files

//include classes
require_once(plugin_dir_path(__FILE__) . "classes/rolecreator.class.php");
require_once(plugin_dir_path(__FILE__) . "classes/roleupdater.class.php");

//API files
require_once(plugin_dir_path(__FILE__) . "api/aj-system-roles.php");
require_once(plugin_dir_path(__FILE__) . "api/apis.php");

require_once(plugin_dir_path(__FILE__) . "AjencyUserManagement.php");

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook(__FILE__, array("AjencyUserManagement", "activate"));
register_deactivation_hook(__FILE__, array("AjencyUserManagement", "deactivate"));

AjencyUserManagement::get_instance();
