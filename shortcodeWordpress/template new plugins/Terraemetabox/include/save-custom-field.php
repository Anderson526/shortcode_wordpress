<?php
/**
 * File: Terraemetabox/include/save-custom-field.php
 * 
 * Almacena los campos personalizados creados en las cajas personalizada
 * 
 * @package Terrae
 * @subpackage Terrae
 * @since Terrae V 1.0
 * 
 * @param int $post_id Post ID.
 *
 * @return bool|int
 * 
 */
 /**
  * 1. Almacena los campos adicionados en las cajas personalizadas
  **/
add_action( 'save_post', 'Terrae_guardar_meta_box' );
function Terrae_guardar_meta_box( $post_id ) {
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
    $fields = 
		[
		'campo-cifras',
		'campo-hipervinculoAliados',
		'campo-cargoIntegrante',
		'campo-fechaFundador',
		'campo-collapseInfoFund',
		'campo-pdfs',
		'campo-categoryProyecto',
		'imagen_personalizada',
		'campo-pdfs-1',
		'campo-pdfs-2',
		'campo-pdfs-3',
		'campo-pdfs-4',
		'descripcion-pdfs-1',
		'descripcion-pdfs-2',
		'descripcion-pdfs-3',
		'descripcion-pdfs-4',
		'campo-pdfs-esal-1',
		'campo-pdfs-esal-2',
		'campo-pdfs-esal-3',
		'campo-pdfs-esal-4',
		'campo-pdfs-esal-5',
		'campo-pdfs-esal-6',
		'campo-pdfs-esal-7',
		'campo-pdfs-esal-8',
		'campo-pdfs-esal-9',
		'campo-pdfs-esal-10',
		'campo-pdfs-esal-11',
		'campo-pdfs-esal-12',
		'descripcion-pdfs-esal-1',
		'descripcion-pdfs-esal-2',
		'descripcion-pdfs-esal-3',
		'descripcion-pdfs-esal-4',
		'descripcion-pdfs-esal-5',
		'descripcion-pdfs-esal-6',
		'descripcion-pdfs-esal-7',
		'descripcion-pdfs-esal-8',
		'descripcion-pdfs-esal-9',
		'descripcion-pdfs-esal-10',
		'descripcion-pdfs-esal-11',
		'descripcion-pdfs-esal-12',
		
		
		];
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_POST ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
        }
     }
}




 