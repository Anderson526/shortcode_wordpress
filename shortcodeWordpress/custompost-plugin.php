<?php
/**
 * Tipo de publicaciones Personalizadas
 * 
 * Plugin Name: Tipo de publicaciones personalizadas para el sitio de Terrae
 * Plugin URI: https://colnodo.apc.org
 * Autor: COLNODO - Anderson Chila
 * Description: Configuración de los tipos de publicaciones personalizadas.
 * 
 * Version: 1.0
 *
 * @package terrae
 * @subpackage terrae
 * @since terrae
 */

defined('ABSPATH') || die();
define('PLUGIN_DIR', plugin_dir_path(__FILE__));
/** 
 * Adiciona los filtros predeterminados en the_content para que podamos extraer contenido formateado con get_post_meta
 */
add_filter('meta_content', 'wptexturize');
add_filter('meta_content', 'convert_smilies');
add_filter('meta_content', 'convert_chars');
add_filter('meta_content', 'wpautop');
add_filter('meta_content', 'shortcode_unautop');
add_filter('meta_content', 'prepend_attachment');

function terrae_custom_post_type()
{
	require_once PLUGIN_DIR . 'include/create-novedades.php';
	require_once PLUGIN_DIR . 'include/create-aliados.php';
	require_once PLUGIN_DIR . 'include/create-eventos.php';
	require_once PLUGIN_DIR . 'include/create-lacigfEventos.php';
	require_once PLUGIN_DIR . 'include/create-panelista.php';
}
add_action('init', 'terrae_custom_post_type');

/** 
 * Creación de la taxonomía para los tipos de publicaciones personalizadas de acuerdo con 
 * la necesidad de clasificación de información en el sitio web Terrae
 */
require_once PLUGIN_DIR . 'include/taxonomy-terrae.php';
/*
 * Configuración de shortcode para mostrar información específica de las publicaciones realizadas
 * en las diferentes secciones en el sitio web
 */

require_once PLUGIN_DIR . 'include/shortcode-listaPublicaciones.php';
require_once PLUGIN_DIR . 'include/shortcode-eventos.php';
require_once PLUGIN_DIR . 'include/shortcode-aliadosCarousel.php';
require_once PLUGIN_DIR . 'include/shortcode-navAncla.php';
require_once PLUGIN_DIR . 'include/shortcode-boxEventLacigf.php';

require_once PLUGIN_DIR . 'include/shortcode-panelista.php';


function enlazar_archivo_js()
{
	// Obtén la URL base de tu plugin
	$plugin_url = plugin_dir_url(__FILE__);

	// Enlaza el archivo JavaScript desde la carpeta 'js' de tu plugin
	wp_enqueue_script('filtro-js', $plugin_url . 'js/filterCategoriesAjax.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enlazar_archivo_js');







?>