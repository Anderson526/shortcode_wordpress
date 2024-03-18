<?php
/**
 * File: 
 * 
 * @package 
 * @subpackage 
 * @since 
 * @author Anderson Chila 
 */

// Función para manejar la solicitud AJAX cuando se haga clic en el botón Filtrar
add_action('wp_ajax_filtrar_proyectos', 'filtrar_proyectos');
add_action('wp_ajax_nopriv_filtrar_proyectos', 'filtrar_proyectos');

function filtrar_proyectos() {
    // Sanitizar y validar los datos de entrada
    $tipoLineaTematica = isset($_POST['tipoLineaTematica']) ? sanitize_text_field($_POST['tipoLineaTematica']) : '';
    $fechaPublicacion = isset($_POST['fecha_publicacion']) ? sanitize_text_field($_POST['fecha_publicacion']) : '';
    $ubicacionProyecto = isset($_POST['ubicacion_proyecto']) ? sanitize_text_field($_POST['ubicacion_proyecto']) : '';

    // Consulta para obtener los posts basados en los criterios seleccionados
    $args = array(
        'post_type' => 'proyectopost', // Tipo de publicación
        'posts_per_page' => -1, // Obtener todos los posts
        'tax_query' => array(
            'relation' => 'AND', // Relación "AND" para los criterios de filtrado
            array(
                'taxonomy' => 'lineatematica',
                'field' => 'slug',
                'terms' => $tipoLineaTematica,
                'hide_empty' => true, // Incluir categorías sin entradas
            ),
            array(
                'taxonomy' => 'year',
                'field' => 'slug',
                'terms' => $fechaPublicacion,
                'hide_empty' => false, // Incluir categorías sin entradas
            ),
            array(
                'taxonomy' => 'ubicacion_proyecto',
                'field' => 'slug',
                'terms' => $ubicacionProyecto,
                'hide_empty' => false, // Incluir categorías sin entradas
            )
        )
    );

    $posts_query = new WP_Query($args);
    $posts = array();

    if ($posts_query->have_posts()) {
        while ($posts_query->have_posts()) {
            $posts_query->the_post();

            // Vista de cada publicación
            $imgUrl = get_the_post_thumbnail_url();
            $descriptionCard = get_the_excerpt();
            $title = esc_html(get_the_title());
            $post_url = get_permalink();

            $posts[] = array(
                'imgUrl' => $imgUrl,
                'descriptionCard' => $descriptionCard,
                'title' => $title,
                'post_url' => $post_url,
            );
        }
    }

    // Restablecer consulta original de WordPress
    wp_reset_postdata();

    // Mostrar los resultados filtrados
    $filtered_posts_html = mostrar_proyectos_filtrados($posts);

    // Devolver los resultados en formato JSON
    echo json_encode(array('filtered_posts_html' => $filtered_posts_html));
    wp_die();
}

// Función para mostrar las publicaciones filtradas
function mostrar_proyectos_filtrados($posts) {
    ob_start();


    ?>
<div class="row row-cols-1 row-cols-lg-3">
    <?php foreach ($posts as $post) : ?>
        <!-- cada proyecto -->
        <div class="col mb-4">
            <div class="ih-item square effect13 bottom_to_top">
                <a href="<?php echo esc_url($post['post_url']); ?>">
                    <div class="img">
                        <img src="<?php echo esc_url($post['imgUrl']); ?>" alt="img">
                        <span class="nombre-proy"><?php echo esc_html($post['title']); ?></span>
                    </div>
                    <div class="info">
                        <p><?php echo esc_html($post['title']); ?></p>
                        <div class="mt-4 px-5">
                            <a class="btn btn-outline" href="<?php echo esc_url($post['post_url']); ?>">VER DETALLES</a>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div><!-- fin row -->
  
    <?php
    return ob_get_clean();
}

// Función para cargar todos los posts al cargar la página
add_action('wp_ajax_cargar_todos_los_proyectos', 'cargar_todos_los_proyectos');
add_action('wp_ajax_nopriv_cargar_todos_los_proyectos', 'cargar_todos_los_proyectos');

function cargar_todos_los_proyectos() {

   

    $args = array(
        'post_type' => 'proyectopost', // Tipo de publicación
        'posts_per_page' => -1, // Obtener todos los posts
    );

    $posts_query = new WP_Query($args);
    $posts = array();

    if ($posts_query->have_posts()) {
        while ($posts_query->have_posts()) {
            $posts_query->the_post();

            // Obtener datos de la publicación
            $imgUrl = get_the_post_thumbnail_url();
            $descriptionCard = get_the_excerpt();
            $post_url = get_permalink();
            $title = esc_html(get_the_title());

            $posts[] = array(
                'imgUrl' => $imgUrl,
                'descriptionCard' => $descriptionCard,
                'post_url' => $post_url,
                'title' => $title,
            );
        }
    }

    // Restablecer consulta original de WordPress
    wp_reset_postdata();

    // Mostrar los resultados en formato JSON
    echo json_encode(array('all_posts' => $posts));
    wp_die();
}

// Función para manejar la solicitud AJAX
add_action('wp_ajax_get_ubicacion_fecha_options', 'get_ubicacion_fecha_options');
add_action('wp_ajax_nopriv_get_ubicacion_fecha_options', 'get_ubicacion_fecha_options');

function get_ubicacion_fecha_options() {
    // Sanitizar y validar los datos de entrada
    $tipoLineaTematica = isset($_POST['tipoLineaTematica']) ? sanitize_text_field($_POST['tipoLineaTematica']) : '';

    if (!empty($tipoLineaTematica)) {
        // Consulta para obtener los posts basados en el tipo de publicación seleccionado
        $args = array(
            'post_type' => 'proyectopost', // Tipo de publicación
            'posts_per_page' => -1, // Obtener todos los posts
            'tax_query' => array(
                array(
                    'taxonomy' => 'lineatematica',
                    'field' => 'slug',
                    'terms' => $tipoLineaTematica, // El término seleccionado en el selector
                    'hide_empty' => false, // Incluir categorías sin entradas
                )
            )
        );

        $posts_query = new WP_Query($args);
        $fecha_options = '';
        $ubicacion_options = '';

        if ($posts_query->have_posts()) {
            while ($posts_query->have_posts()) {
                $posts_query->the_post();

                // Obtener las palabras clave asociadas al post 
                $ubicacion = get_the_terms(get_the_ID(), 'ubicacion_proyecto');
                if ($ubicacion && !is_wp_error($ubicacion)) {
                    foreach ($ubicacion as $term) {
                        $ubicacion_options .= '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                    }
                }

                // Obtener las fechas asociadas al post (taxonomia)
                $fecha_publicaciones = get_the_terms(get_the_ID(), 'year');
                if ($fecha_publicaciones && !is_wp_error($fecha_publicaciones)) {
                    foreach ($fecha_publicaciones as $term) {
                        $fecha_options .= '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                    }
                }
            }
        }

        // Restablecer consulta original de WordPress
        wp_reset_postdata();

        $options = array(
            'fecha_options' => $fecha_options,
            'ubicacion_options' => $ubicacion_options,
        );

        echo json_encode($options);
        wp_die();
    } else {
        // Devolver un mensaje de error si no se proporciona el tipo de publicación
        echo json_encode(array('error' => 'Tipo de proyecto no especificado.'));
        wp_die();
    }
}

// Función para manejar la solicitud AJAX del tercer selector
add_action('wp_ajax_get_tercer_select_option', 'get_tercer_select_option');
add_action('wp_ajax_nopriv_get_tercer_select_option', 'get_tercer_select_option');

function get_tercer_select_option() {
    // Sanitizar y validar los datos de entrada
    $fecha_publicacion = isset($_POST['fecha_publicacion']) ? sanitize_text_field($_POST['fecha_publicacion']) : '';

    if (!empty($fecha_publicacion)) {
        // Consulta para obtener los posts basados en la fecha de publicación seleccionada
        $args = array(
            'post_type' => 'proyectopost', // Tipo de publicación
            'posts_per_page' => -1, // Obtener todos los posts
            'tax_query' => array(
                array(
                    'taxonomy' => 'year',
                    'field' => 'slug',
                    'terms' => $fecha_publicacion, // El término seleccionado en el selector de fecha de publicación
                    'hide_empty' => false, // Incluir categorías sin entradas
                )
            )
        );

        $posts_query = new WP_Query($args);
        $ubicacion_options = '';

        if ($posts_query->have_posts()) {
            while ($posts_query->have_posts()) {
                $posts_query->the_post();

                // Obtener las palabras clave asociadas al post
                $ubicacion = get_the_terms(get_the_ID(), 'ubicacion_proyecto');
                if ($ubicacion && !is_wp_error($ubicacion)) {
                    foreach ($ubicacion as $term) {
                        $ubicacion_options .= '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                    }
                }
            }
        }

        // Restablecer consulta original de WordPress
        wp_reset_postdata();

        // Enviar opciones como respuesta
        echo json_encode(array('ubicacion_options' => $ubicacion_options));
        wp_die();
    } else {
        // Devolver un mensaje de error si no se proporciona la fecha de publicación
        echo json_encode(array('error' => 'Fecha de publicación no especificada.'));
        wp_die();
    }
}

// Agregar el shortcode en functions.php o en un plugin
add_shortcode('filtro_proyectos', 'filtro_proyectos_shortcode');

function filtro_proyectos_shortcode() {
    ob_start();
    ?>
    <div class="filtros">
        <div class="container">
            <div class="col">
                <h2>Proyectos</h2>
            </div>
            <form id="filtro-publicaciones-form" class="form-row align-items-end">
                <div class="col-md-6 col-lg-3 px-3">
                    <label for="linea-tematica">Linea tematica:</label>
                    <select name="linea-tematica" id="linea-tematica" class="custom-select">
                        <option value="">Seleccione una opción</option>
                        <?php
                        // Obtener los términos de la taxonomía "tipo de publicación"
                        $terms = get_terms(array(
                            'taxonomy' => 'lineatematica',
                            'hide_empty' => true, // Mostrar términos incluso si no están asociados con ningún post
                        ));
                        // Si hay términos, mostrar opciones en el selector
                        if (!empty($terms)) {
                            foreach ($terms as $term) {
                                echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3 px-3">
                    <label for="fecha-publicacion">Fecha publicacion:</label>
                    <select name="fecha-publicacion" id="fecha-publicacion" class="custom-select">
                        <option value="">Seleccione una opción</option>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3 px-3">
                    <label for="ubicacion-proyecto">Ubicación proyecto:</label>
                    <select name="ubicacion-proyecto" id="ubicacion-proyecto" class="custom-select">
                        <option value="">Seleccione una opción</option>
                    </select>
                </div>

                <div class="col-md-6 col-lg-3 px-3 pt-2">
                <button type="button" class="btn btn-enviar" id="filtrar-btn">Filtrar</button> <!-- Botón Filtrar -->
                </div>
            </form>
        </div>
    </div>
    <?php echo migas_de_pan(); ?>
    <div class="container">
        <div id="resultado-proyectos"></div>
    </div>
    <script>
        jQuery(document).ready(function($) {

         //funcion de carga instantanea

         
         $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                'action': 'cargar_todos_los_proyectos' // Nombre de la acción de WordPress
            },
            success: function(response) {
                // Manejar la respuesta
                var posts = JSON.parse(response);
                if (posts.all_posts.length > 0) {
                    // Construir el HTML para los posts
                    var html = '';
                 
                    html += '<div class="row row-cols-1 row-cols-lg-3">';
                    posts.all_posts.forEach(function(post) {
                        // Agregar cada post al HTML
                     html += '<div class="col mb-4">';
                                html += '<div class="ih-item square effect13 bottom_to_top">';
                                html += '<a href="' + post.post_url + '">';
                                html += '<div class="img">';
                                html += '<img src="' + post.imgUrl + '" alt="img">';
                                html += '<span class="nombre-proy">' + post.title + '</span>';
                                html += '</div>';
                                html += '<div class="info">';
                                html += '<p>' + post.title + '</p>';
                                html += '<div class="mt-4 px-5">';
                                html += '<span class="btn btn-outline" href="' + post.post_url + '">VER DETALLES</span>';
                                html += '</div>';
                                html += '</div>';
                                html += '</a>';
                                html += '</div>';
                                html += '</div>';
                    });
                    html += '</div>';

                    // Actualizar el contenido del elemento resultado-proyectos
                    $('#resultado-proyectos').html(html);
                } else {
                    // Si no hay posts, mostrar un mensaje
                    $('#resultado-proyectos').html('<p>No se encontraron publicaciones.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar los posts: ' + error);
            }
        });

            // Función para cargar filtros al cambiar cualquier opción
            function cargarFiltros() {
                var lineaTematica = $('#linea-tematica').val();
                var fechaPublicacion = $('#fecha-publicacion').val();
                var ubicacionProyecto = $('#ubicacion-proyecto').val();
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'filtrar_proyectos',
                        tipoLineaTematica: lineaTematica,
                        fecha_publicacion: fechaPublicacion,
                        ubicacion_proyecto: ubicacionProyecto
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#resultado-proyectos').html(data.filtered_posts_html);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
            // Cargar filtros al hacer clic en el botón Filtrar
            $('#filtrar-btn').click(function() {
                cargarFiltros();
            });
            // Función para cargar el segundo y tercer select al cambiar el primer select
            $('#linea-tematica').change(function() {
                var tipoLineaTematica = $(this).val();
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'get_ubicacion_fecha_options',
                        tipoLineaTematica: tipoLineaTematica
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#fecha-publicacion').html(data.fecha_options);
                        $('#ubicacion-proyecto').html(data.ubicacion_options);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
            // Función para cargar el tercer select al cambiar el segundo select
            $('#fecha-publicacion').change(function() {
                var fechaPublicacion = $(this).val();
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'get_tercer_select_option',
                        fecha_publicacion: fechaPublicacion
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#ubicacion-proyecto').html(data.ubicacion_options);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
            // Cargar todos los proyectos al cargar la página
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'cargar_todos_los_proyectos'
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $('#resultado-proyectos').html(data.all_posts);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
