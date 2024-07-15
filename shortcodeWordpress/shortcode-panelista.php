<?php
/**
 * 
 * File: LacigfCustomPostType/include/shortcode-panelista.php
 * Creación del ShortCode panelistas
 * @package Lacigf
 * @subpackage Lacigf
 * @since Lacigf V 1.0
 * 
 */

add_shortcode('panelistas', 'shortcode_panelista_perfil');

function shortcode_panelista_perfil( $atts, $content = null ){
    $atts = shortcode_atts(
        array(
            'categoria' => '',
        ),
        $atts,
        'panelistas'
    );

    ob_start();

    $args = array(
        'post_type' => array('panelista'),
        'post_status' => array('publish'),
        'nopaging' => false,
        'order' => 'DESC',
        'orderby' => 'date',
        'tax_query' => array(
            array(
                'taxonomy' => 'categoria', 
                'field'    => 'slug',
                'terms'    => $atts['categoria'],
            ),
        ),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()): ?>
        <div class="card-columns panelistas mt-4">
        <?php 
        while ($query->have_posts()):
            $query->the_post(); 
            $img = get_the_post_thumbnail_url();
            $image_id = get_post_thumbnail_id();
            $alternativeText = get_post_meta($image_id, '_wp_attachment_image_alt', true);
            $nombre = get_post_meta(get_the_ID(), 'nombre-panelista', true);
            $cargo = get_post_meta(get_the_ID(), 'cargo-panelista', true);
            $excerpt =  get_the_excerpt();
        ?>

            <div class="card">
                <img class="img-thumbnail foto-panelista mx-auto d-block mt-3" src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($alternativeText); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo esc_html($nombre); ?></h5>
                    <h6 class="organizacion"><?php echo esc_html($cargo); ?></h6>
                    <a data-toggle="collapse" href="#NombreApellido1" role="button" aria-expanded="false" aria-controls="NombreApellido1"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/mas-info.png'); ?>" alt="<?php echo esc_attr($alternativeText); ?>" class="img-fluid"></a>
                    <div class="collapse" id="NombreApellido1">   
                        <p class="card-text"><?php echo esc_html($excerpt); ?></p>
                    </div> 
                </div>
            </div>

        <?php endwhile; ?>
        </div>
    <?php endif;

    wp_reset_postdata();

    return ob_get_clean();
}

function create_taxonomy_category(){
	$label = array(
		'name'              => _x('Categorías', 'taxonomy general name'),
		'singular_name'     => _x('Categoría', 'taxonomy singular name'),
		'search_items'      => __('Buscar Categorías'),
		'all_items'         => __('Todas las Categorías'),
		'parent_item'       => __('Categoría Padre'),
		'parent_item_colon' => __('Categoría Padre:'),
		'edit_item'         => __('Editar Categoría'),
		'update_item'       => __('Actualizar Categoría'),
		'add_new_item'      => __('Añadir Nueva Categoría'),
		'new_item_name'     => __('Nombre de la Nueva Categoría'),
		'menu_name'         => __('Categorías'),

	);
	$args = array(
		'hierarchical'      => true, 
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array('slug' => 'categoria'),	
	);
	register_taxonomy('categoria', array('panelista'), $args);
}

add_action('init', 'create_taxonomy_category', 0);

	?>