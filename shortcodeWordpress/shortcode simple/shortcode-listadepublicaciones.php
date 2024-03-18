<?php
/**
 * File: 
 *
 * @package 
 * @subpackage 
 * @since 
 * @author Anderson Chila 
 */


 function terrae_shortcodeListaProyecto(){


	$output = '';

	$output .= '<div class="filtros">';
	$output .= '<div class="container">';
	$output .= '<div class="col">
				<h2>Publicaciones</h2>
			    </div>';
	$output .= '<form id="filtro-categoria-form-publicaciones" class="form-row align-items-end">';
	$output .= '<div class="col-md-6 col-lg-3 px-3">
				<label class="mt-2">Tipo de publicación</label>';
    $output .= '<select id="filtro-categoria-publicaciones" class="custom-select">';
    $output .= '<option value="">Todas las categorías</option>';

	
	
	
	$categorias_tpublicacion = get_categories(array(
		'taxonomy' => 'tipopublicacion', // Nombre de la taxonomía personalizada
		'hide_empty' => false, // Incluir categorías sin entradas
	));
	

foreach($categorias_tpublicacion as $categoria_tpublicacion){

    $output .= '<option value="' . esc_attr($categoria_tpublicacion->slug) . '">' . esc_html($categoria_tpublicacion->name) . '</option>';

}

$output .= '</select></div>';
	
	
	
	//year

	$categorias_year = get_categories(array(
		'taxonomy' => 'year', // Nombre de la taxonomía personalizada
		'hide_empty' => false, // Incluir categorías sin entradas
	));
	
	
if(!empty($categorias_year)){
	
	$output .= '<div class="col-md-6 col-lg-3 px-3">
				<label class="mt-2">Fecha de publicación</label>';

	$output .= '<select id="filtro-categoria_year-publicaciones"  class="custom-select">';
	$output .= '<option value="">Todas las categorías</option>';


	foreach($categorias_year as $categoria_year){

		$output .= '<option value="' . esc_attr($categoria_year->slug) . '">' . esc_html($categoria_year->name) . '</option>';

	}

	$output .= '</select></div>';
}
	
	
		//palabras clave

	$categorias_pclave = get_categories(array(
		'taxonomy' => 'pclave', // Nombre de la taxonomía personalizada
		'hide_empty' => false, // Incluir categorías sin entradas
	));
	
	
	$output .= '<div class="col-md-6 col-lg-3 px-3">
				<label class="mt-2">Palabras clave</label>';

	$output .= '<select id="filtro-categoria_pclave-publicaciones"  class="custom-select">';
	$output .= '<option value="">Todas las categorías</option>';


	foreach($categorias_pclave as $categoria_pclave){

		$output .= '<option value="' . esc_attr($categoria_pclave->slug) . '">' . esc_html($categoria_pclave->name) . '</option>';

	}

	$output .= '</select></div>';

	
	
	
	//sent btn
	
$output .= '<div class="col-md-6 col-lg-3 px-3"><button id="sent-button" class="btn btn-enviar" type="submit">FILTRAR</button></div>';
	//$output .= '<input type="submit" class="btn btn-enviar" value="Filtrar">';
	$output .= '</form>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '<div class="container position-relative">
				<div class="flecha1"></div>';
	ob_start();
	migas_de_pan();
	// Capturamos el contenido del buffer y lo almacenamos en una variable
	$migas_de_pan_output = ob_get_clean();

	$output .= $migas_de_pan_output;
	$output.='</div>';
		


return $output;

 }
 add_shortcode('listadoPublicaciones', 'terrae_shortcodeListaProyecto');



// Define la función para filtrar las publicaciones
function filtro_publicaciones_post() {
    $categoria_publicaciones = $_POST['categoriaPublicaciones']; 
    $filtro_year_publicaciones = $_POST['filtro_yearPublicaiones'];
    $filtro_pclave_publicaciones = $_POST['filtro_pclavepublicaciones'];

    $args = array(
        'post_type' => 'publicacion', // Tipo de publicación
        'posts_per_page' => -1, // Mostrar todas las publicaciones
        'order' => 'DESC', // Orden descendente
    );

    if (!empty($categoria_publicaciones)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'tipopublicacion',
            'field' => 'slug',
            'terms' => $categoria_publicaciones,
            'operator' => 'IN',
        );
    }

    if (!empty($filtro_year_publicaciones)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'year',
            'field' => 'slug',
            'terms' => $filtro_year_publicaciones,
            'operator' => 'IN',
        );
    }

    if (!empty($filtro_pclave_publicaciones)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'pclave',
            'field' => 'slug',
            'terms' => $filtro_pclave_publicaciones,
            'operator' => 'IN',
        );
    }

    $query = new WP_Query($args);

    $posts = array();

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $imgUrl = get_the_post_thumbnail_url();
            $descriptionCard = get_the_excerpt();
            $url_pdf = get_post_meta(get_the_ID(), 'campo-pdfs', true);

            $year_terms = wp_get_post_terms(get_the_ID(), 'year');
            $year_term = $year_terms[0];
            $formatted_year = esc_html($year_term->name);

            $posts[] = array(
                'imgUrl' => $imgUrl,
                'descriptionCard' => $descriptionCard,
                'url_pdf' => $url_pdf,
                'formatted_year' => $formatted_year,
            );
        endwhile;

        // Ordenar el array de publicaciones por año de forma descendente
        usort($posts, function($a, $b) {
            return strcmp($b['formatted_year'], $a['formatted_year']);
        });

        ?>
        <div class="row row-cols-1 row-cols-lg-3">
            <?php foreach ($posts as $post) : ?>
                <div class="col mb-4">
                    <div class="card h-100">
                        <div class="foto">
                            <a href="<?php echo $post['url_pdf']; ?>" target="_blank"><img src="<?php echo $post['imgUrl']; ?>" class="img-fluid" alt=""></a>
                        </div>
                        <div class="nombre-publicacion">
                            <h5><a href="<?php echo $post['url_pdf']; ?>" target="_blank"><?php echo $post['descriptionCard']; ?>(<?php echo $post['formatted_year']; ?>)</a></h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        wp_reset_postdata();
    else :
        echo "<p class='mb-5'>No hay publicaciones por el momento</p>";
    endif;

    die();
}




add_action('wp_ajax_custom_post_filter_publicaciones_ajax', 'filtro_publicaciones_post'); 
add_action('wp_ajax_nopriv_custom_post_filter_publicaciones_ajax', 'filtro_publicaciones_post');