<?php
/*
 * Plugin Name: Campos personalizados Terrae
 * Plugin URI: https://www.colnodo.apc.org/
 * Description: Adicionar campos personalizadas para los tipos de entrada personalizada
 * Author: COLNODO - Anderson Chila
 * Author URI:  https://www.colnodo.apc.org/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version: 1.0.0
 * Requires PHP: 7.4
 * 
 * @package ESD
 * @subpackage ESD
 * @since ESD V 1.0
 */
	
defined( 'ABSPATH' ) || die();
 
define( 'METABOX_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'METABOX_PLUGIN_FILE', __FILE__ );
define( 'METABOX_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'METABOX_PLUGIN_VERSION', '1.1.0' );

require_once METABOX_PLUGIN_DIR . 'include/create-metabox.php';
require_once METABOX_PLUGIN_DIR . 'include/save-custom-field.php';
require_once METABOX_PLUGIN_DIR . 'include/show-frontend.php';

