<?php
/**
 * File: Terraemetabox/include/create-metabox.php
 * 
 * Adiciona las cajas donde se visualizan los campos personalizados en los tipos de publicaciones
 * 
 * @package Terrae
 * @subpackage Terrae
 * @since Terrae V 1.0
 */
 /**
  * 1. Registra las cajas personalizadas para los nuevos campos requeridos en el sitio web. Define:
  * Posición de la caja en el momento de añadir un nuevo ítem
  * Tipo de entrada donde se visualiza la caja
  * Función que configura los nuevos campos
  **/


add_action( 'add_meta_boxes', 'terrae_register_meta_boxes' );
function terrae_register_meta_boxes() {
	
	//metabox cifras
		add_meta_box( 'meta_box_cifras', __( 'Numero de cifras', 'terrae' ), 'Terrae_numeroDeCifras', 'cifra', 'normal', 'high' );
	//metabox hipervinculo aliados 
		add_meta_box( 'meta_box_aliados', __( 'hipervinculo aliados', 'terrae' ), 'Terrae_hipervinculoAliados', 'aliados', 'normal', 'high' );
	//metabox cargo de integrante de equipo
		add_meta_box( 'meta_box_integrantes', __( 'cargo integrante', 'terrae' ), 'Terrae_cargoIntegrante', 'equipo', 'normal', 'high' );
	
	
	//metabox fecha fundador
		add_meta_box( 'meta_box_fechaFundador', __( 'fecha fundador', 'terrae' ), 'Terrae_fechaFundador', 'fundador', 'normal', 'high' );	
	
	//metabox fundador collapse informacion

		add_meta_box( 'meta_box_collapseInfoFundador', __( 'collapse informacion', 'terrae' ), 'Terrae_collapseInformacion', 'fundador', 'normal', 'high' );	
	
	//metabox archivo adjunto publicacion 

	add_meta_box( 'meta_box_pdf', __( 'Espacio para que anexe documento PDF', 'terrae' ), 'Terrae_publicacionPdf', 'publicacion', 'normal', 'high' );
	
	
	
	
	
	
	
	//metabox select categoria 
		add_meta_box( 'meta_box_categoriaProyecto', __( 'Línea estratégica a la que pertenece', 'terrae' ), 'Terrae_categoriaProyecto', 'proyectot', 'normal', 'high' );
	
	//metabox select encabezado
	
	
		add_meta_box( 'meta_box_categoriaencabezado', __( 'categoria encabezado', 'terrae' ), 'Terrae_categoriaProyecto', 'encabezado', 'normal', 'high' );
	
	
	
	
	
	//seccion 4 pdf y 4 textos 
	
		add_meta_box( 'meta_box_pdf_proyectopost', __( 'Espacio para que anexe documento PDF', 'terrae' ), 'Terrae_proyectoPostpdf', 'proyectopost', 'normal', 'high' );
	
	
		//documentos esal
	
		add_meta_box( 'meta_box_pdf_esal', __( 'Espacio para que anexe documento PDF', 'terrae' ), 'Terrae_esalpdf', 'Esaldoc', 'normal', 'high' );
	
	
	
	//metabox imagen adicional
		
	//add_meta_box( 'meta_box_img_proyecto', __( 'imagen proyecto post', 'terrae' ), 'Terrae_imgProyecto', 'proyectopost', 'normal', 'high' );
	
	
}

/**
  * 2. Adiciona las campos a las cajas definidas anteriormente
  */ 
 //2.1. Adiciona el campo de enlace del Enlace para conocer mas en la caja meta_box_conocemas











 //2.2. Adiciona el campo de autor en la caja meta_box_testimonio



 function Terrae_numeroDeCifras ( $post ) {
	$valor_actual = get_post_meta( get_the_ID(), 'campo-cifras', true );
	$html = '<div class="editor-post-link">';
	$html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
	$html .= '<div 	class="components-base-control__field css-1kyqli5 e1puf3u2">';
	$html .= '<label class="components-base-control__label css-4dk55l e1puf3u1" for="campo-enlace-autortestimonio" >'. esc_html__('Cifras', 'terrae') .'</label>';
	$html .= '<input type="text" name="campo-cifras" placeholder="ingrese las cifras" size="50" id="campo-cifras" class="components-text-control__input" value="'. esc_attr($valor_actual) .'" required/>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '<p>Escriba las cifras</p>';
	$html .= '</div>';
	echo $html;
	 
} 




function Terrae_hipervinculoAliados( $post ) {
    $valor_actual = get_post_meta( get_the_ID(), 'campo-hipervinculoAliados', true );
    $html = '<div class="editor-post-link">';
    $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
    $html .= '<div class="components-base-control__field css-1kyqli5 e1puf3u2">';
    $html .= '<label class="components-base-control__label css-4dk55l e1puf3u1" for="campo-hipervinculoAliado">'. esc_html__('aliados', 'terrae') .'</label>';
    $html .= '<input type="text" name="campo-hipervinculoAliados" placeholder="Ingrese el enlace de la pagina del aliado" size="50" id="campo-hipervinculoAliado" class="components-text-control__input" value="'. esc_attr($valor_actual) .'" required/>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<p>ingrese el hipervinculo de la pagina del aliado</p>';
    $html .= '</div>';
    echo $html;
}
 


function Terrae_cargoIntegrante( $post ) {
    $valor_actual = get_post_meta( get_the_ID(), 'campo-cargoIntegrante', true );
    $html = '<div class="editor-post-link">';
    $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
    $html .= '<div class="components-base-control__field css-1kyqli5 e1puf3u2">';
    $html .= '<label class="components-base-control__label css-4dk55l e1puf3u1" for="campo-cargoIntegrante">'. esc_html__('equipo', 'terrae') .'</label>';
    $html .= '<input type="text" name="campo-cargoIntegrante" placeholder="Ingrese el cargo" size="50" id="campo-cargoIntegrante" class="components-text-control__input" value="'. esc_attr($valor_actual) .'" required/>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<p>el cargo del integrante del equipo</p>';
    $html .= '</div>';
    echo $html;
}
 




function Terrae_fechaFundador( $post ) {
    $valor_actual = get_post_meta( get_the_ID(), 'campo-fechaFundador', true );
    $html = '<div class="editor-post-link">';
    $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
    $html .= '<div class="components-base-control__field css-1kyqli5 e1puf3u2">';
    $html .= '<label class="components-base-control__label css-4dk55l e1puf3u1" for="campo-fechaFundador">'. esc_html__('fecha', 'terrae') .'</label>';
    $html .= '<input type="text" name="campo-fechaFundador" placeholder="Ingrese la fecha" size="50" id="campo-fechaFundador" class="components-text-control__input" value="'. esc_attr($valor_actual) .'" required/>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<p>Fecha de actividad del fundador</p>';
    $html .= '</div>';
    echo $html;
}


function Terrae_collapseInformacion($post) {
    $valor_actual = get_post_meta(get_the_ID(), 'campo-collapseInfoFund', true);
    $html = '<div class="editor-post-link">';
    $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
    $html .= '<div class="components-base-control__field css-1kyqli5 e1puf3u2">';
    $html .= '<label class="components-base-control__label css-4dk55l e1puf3u1" for="campo-collapseInfoFund">' . esc_html__('fecha', 'terrae') . '</label>';
    $html .= '<textarea name="campo-collapseInfoFund" placeholder="ingrese la descripcion del collapse" id="campo-collapseInfoFund" class="components-text-control__input" required>' . esc_textarea($valor_actual) . '</textarea>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<p>informacion extra del fundador</p>';
    $html .= '</div>';
    echo $html;
}









//categorias de proyectos



function Terrae_categoriaProyecto( $post ) {
    $valor_actual = get_post_meta( get_the_ID(), 'campo-categoryProyecto', true );
    $html = '<div class="editor-post-link">';
    $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
    $html .= '<div class="components-base-control__field css-1kyqli5 e1puf3u2">';
    $html .= '<label class="components-base-control__label css-4dk55l e1puf3u1" for="campo-categoryProyecto">'. esc_html__('Línea estratégica', 'terrae') .'</label>';

    // Crear el campo select
    $html .= '<select name="campo-categoryProyecto" id="campo-categoryProyecto" class="components-text-control__input" required>';
    
    // Generar las opciones del select
 
   $options = array(
        '10' => 'Gobernanza ambiental',
        '20' => 'Ciencia digna y conocimiento',
        '30' => 'Arraigo y empoderamiento'
    );

    foreach ($options as $value => $label) {
        $selected = ($value == $valor_actual) ? 'selected' : '';
        $html .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
    }
	
	
	

    $html .= '</select>';
    $html .= '</div>';
    $html .= '</div>';
   
    $html .= '</div>';
    echo $html;
}




//pdf only

function Terrae_publicacionPdf( $post ) {
	$valor_actual = get_post_meta( get_the_ID(), 'campo-pdfs', true );
	$html = '<div class="inside">';
	$html .= '<p>Seleccione un archivo PDF de la biblioteca de medios, sino encuentra el archivo seleccione la opción subir archivos y seleccionelo de su computador.</p>';
	$html .= '<label class="post-attributes-label" for="campo-pdfs" >'. esc_html__('Archivo adjunto', 'terrae') .'</label>';
	$html .= '<input type="text" name="campo-pdfs" id="campo-pdfs" value="'. esc_attr($valor_actual) .'" class="post-attributes-input" />';
	$html .=  '<a href="" class="campo_recurso_pdf button-secondary">'. esc_html__('Subir archivo PDF', 'terrae') .'</a>';
	$html .= '</div>';
    echo $html;	
}

add_action( 'admin_enqueue_scripts', 'terrae_pdf' );
function terrae_pdf() {	
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
	wp_enqueue_script( 'archivo-meta-box', METABOX_PLUGIN_URL . 'js/archivo_meta_box.js', array('jquery'), '1.0.0', true );
	
}






//4 pdf y descripcion.

function Terrae_proyectoPostpdf( $post ) {
    $html = '<div class="inside">';

    for ($i = 1; $i <= 4; $i++) {
        $campo_name = 'campo-pdfs-' . $i;
        $valor_actual = get_post_meta( get_the_ID(), $campo_name, true );

        $html .= '<p>Seleccione un archivo PDF para el campo ' . $i . ' de la biblioteca de medios, o suba un archivo desde su computadora.</p>';
        
        // Label and input for the PDF file
        $html .= '<label class="post-attributes-label" for="' . esc_attr($campo_name) . '">'. esc_html__('Archivo adjunto', 'terrae') . ' ' . $i . '</label>';
        $html .= '<input type="text" name="' . esc_attr($campo_name) . '" id="' . esc_attr($campo_name) . '" value="' . esc_attr($valor_actual) . '" class="post-attributes-input" />';
        $html .=  '<a href="" class="campo_recurso_pdf2 button-secondary" name="' . esc_attr($campo_name) . '">'. esc_html__('Subir archivo PDF', 'terrae') . ' ' . $i . '</a>';

        // Label and input for the PDF description
        $descripcion_name = 'descripcion-pdfs-' . $i;
        $descripcion_valor_actual = get_post_meta( get_the_ID(), $descripcion_name, true );
        $html .= '<label class="post-attributes-label" for="' . esc_attr($descripcion_name) . '">'. esc_html__('Descripción del PDF', 'terrae') . ' ' . $i . '</label>';
        $html .= '<input type="text" name="' . esc_attr($descripcion_name) . '" id="' . esc_attr($descripcion_name) . '" value="' . esc_attr($descripcion_valor_actual) . '" class="post-attributes-input" />';
    }

    $html .= '</div>';
    echo $html;
	
	
}



add_action( 'admin_enqueue_scripts', 'terrae_pdf_proyecto' );
function terrae_pdf_proyecto() {	
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
	wp_enqueue_script( 'archivo-meta-box-2', METABOX_PLUGIN_URL . 'js/archivo_meta_box2.js', array('jquery'), '1.0.0', true );

}







function Terrae_esalpdf( $post ) {
    $html = '<div class="inside">';

    for ($i = 1; $i <= 12; $i++) {
        $campo_name = 'campo-pdfs-esal-' . $i;
        $valor_actual = get_post_meta( get_the_ID(), $campo_name, true );

        $html .= '<p>Seleccione un archivo PDF para el campo ' . $i . ' de la biblioteca de medios, o suba un archivo desde su computadora.</p>';
        
        // Label and input for the PDF file
        $html .= '<label class="post-attributes-label" for="' . esc_attr($campo_name) . '">'. esc_html__('Archivo adjunto', 'terrae') . ' ' . $i . '</label>';
        $html .= '<input type="text" name="' . esc_attr($campo_name) . '" id="' . esc_attr($campo_name) . '" value="' . esc_attr($valor_actual) . '" class="post-attributes-input" />';
        $html .=  '<a href="" class="campo_recurso_pdf2 button-secondary" name="' . esc_attr($campo_name) . '">'. esc_html__('Subir archivo PDF', 'terrae') . ' ' . $i . '</a>';

        // Label and input for the PDF description
        $descripcion_name = 'descripcion-pdfs-esal-' . $i;
        $descripcion_valor_actual = get_post_meta( get_the_ID(), $descripcion_name, true );
        $html .= '<label class="post-attributes-label" for="' . esc_attr($descripcion_name) . '">'. esc_html__('Descripción del PDF', 'terrae') . ' ' . $i . '</label>';
        $html .= '<input type="text" name="' . esc_attr($descripcion_name) . '" id="' . esc_attr($descripcion_name) . '" value="' . esc_attr($descripcion_valor_actual) . '" class="post-attributes-input" />';
    }

    $html .= '</div>';
    echo $html;
	
	
}



add_action( 'admin_enqueue_scripts', 'terrae_pdf_proyecto' );
function terrae_pdf_esal() {	
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
	wp_enqueue_script( 'archivo-meta-box-2', METABOX_PLUGIN_URL . 'js/archivo_meta_box2.js', array('jquery'), '1.0.0', true );

}




