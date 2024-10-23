<?php
/**
 * File: Terraemetabox/include/save-custom-field.php
 * 
 * Almacena los campos personalizados creados en las cajas personalizada
 * 
 * @package Lacigf
 * @subpackage Lacigf
 * @since Lacigf V 1.0
 * 
 * @param int $post_id Post ID.
 *
 * @return bool|int
 * 
 */
/**
 * 1. Almacena los campos adicionados en las cajas personalizadas
 **/
add_action('save_post', 'lacigf_guardar_meta_box');
function lacigf_guardar_meta_box($post_id)
{
  if ($parent_id = wp_is_post_revision($post_id)) {
    $post_id = $parent_id;
  }
  $fields =
    [
      'fecha-evento',
      'lugar-evento',
      'campo_enlace_evento',
      'nombre-panelista',
      'cargo-panelista',
	  'organizacion-panelista',
	   'campo_pais_panelistas',
	  'campo_categoria_panelista',
      'order-novedad',
      'content-map',
	  'url-evento',
	  'url-evento-aliados',
	  'fecha-agenda',


	  
    ];
  foreach ($fields as $field) {
    if (array_key_exists($field, $_POST)) {
      update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
    }
  }
}

