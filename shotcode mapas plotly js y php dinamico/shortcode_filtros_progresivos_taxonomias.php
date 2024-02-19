// Función para manejar la solicitud AJAX cuando se haga clic en el botón Filtrar
add_action('wp_ajax_filtrar_publicaciones', 'filtrar_publicaciones');
add_action('wp_ajax_nopriv_filtrar_publicaciones', 'filtrar_publicaciones');

function filtrar_publicaciones() {
    // Sanitizar y validar los datos de entrada
    $tipoPublicacion = isset($_POST['tipo_publicacion']) ? sanitize_text_field($_POST['tipo_publicacion']) : '';
    $fechaPublicacion = isset($_POST['fecha_publicacion']) ? sanitize_text_field($_POST['fecha_publicacion']) : '';
    $palabrasClave = isset($_POST['palabras_clave']) ? sanitize_text_field($_POST['palabras_clave']) : '';

    // Consulta para obtener los posts basados en los criterios seleccionados
    $args = array(
        'post_type' => 'publicacion', // Tipo de publicación
        'posts_per_page' => -1, // Obtener todos los posts
        'tax_query' => array(
            'relation' => 'IN', // Relación "AND" para los criterios de filtrado
            array(
                'taxonomy' => 'tipopublicacion',
                'field' => 'slug',
                'terms' => $tipoPublicacion, // El término seleccionado en el selector de tipo de publicación
                'operator' => 'IN',
            ),
            array(
                'taxonomy' => 'year',
                'field' => 'slug',
                'terms' => $fechaPublicacion ,// El término seleccionado en el selector de fecha de publicación
                'operator' => 'IN',
            ),
            array(
                'taxonomy' => 'pclave',
                'field' => 'slug',
                'terms' => $palabrasClave, // El término seleccionado en el selector de palabras clave
                'operator' => 'IN',
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
            $url_pdf = get_post_meta(get_the_ID(), 'campo-pdfs', true);
            $formatted_year = esc_html(get_the_title()); // Cambié "year" por el título del post ya que no está claro qué campo es la "fecha de publicación"

            $posts[] = array(
                'imgUrl' => $imgUrl,
                'descriptionCard' => $descriptionCard,
                'url_pdf' => $url_pdf,
                'formatted_year' => $formatted_year,
            );
        }
    }

    // Restablecer consulta original de WordPress
    wp_reset_postdata();

    // Mostrar los resultados filtrados
    $filtered_posts_html = mostrar_publicaciones_filtradas($posts);

    // Devolver los resultados en formato JSON
    echo json_encode(array('filtered_posts_html' => $filtered_posts_html));
    wp_die();
}












// Función para mostrar las publicaciones filtradas



function mostrar_publicaciones_filtradas($posts) {
    ob_start();
    ?>
    <div class="row row-cols-1 row-cols-lg-3">
        <?php foreach ($posts as $post) : ?>
            <div class="col mb-4">
                <div class="card h-100">
                    <div class="foto">
                        <a href="<?php echo esc_url($post['url_pdf']); ?>" target="_blank"><img src="<?php echo esc_url($post['imgUrl']); ?>" class="img-fluid" alt=""></a>
                    </div>
                    <div class="nombre-publicacion">
                        <h5><a href="<?php echo esc_url($post['url_pdf']); ?>" target="_blank"><?php echo esc_html($post['descriptionCard']); ?>(<?php echo esc_html($post['formatted_year']); ?>)</a></h5>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}






// Función para cargar todos los posts al cargar la página
add_action('wp_ajax_cargar_todos_los_posts', 'cargar_todos_los_posts');
add_action('wp_ajax_nopriv_cargar_todos_los_posts', 'cargar_todos_los_posts');

function cargar_todos_los_posts() {
    $args = array(
        'post_type' => 'publicacion', // Tipo de publicación
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
            $url_pdf = get_post_meta(get_the_ID(), 'campo-pdfs', true);
            $formatted_year = esc_html(get_the_title());

            $posts[] = array(
                'imgUrl' => $imgUrl,
                'descriptionCard' => $descriptionCard,
                'url_pdf' => $url_pdf,
                'formatted_year' => $formatted_year,
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
add_action('wp_ajax_get_fecha_palabras_options', 'get_fecha_palabras_options');
add_action('wp_ajax_nopriv_get_fecha_palabras_options', 'get_fecha_palabras_options');

function get_fecha_palabras_options() {
    // Sanitizar y validar los datos de entrada
    $tipoPublicacion = isset($_POST['tipo_publicacion']) ? sanitize_text_field($_POST['tipo_publicacion']) : '';
    

    if (!empty($tipoPublicacion)) {
        // Consulta para obtener los posts basados en el tipo de publicación seleccionado
        $args = array(
            'post_type' => 'publicacion', // Tipo de publicación
            'posts_per_page' => -1, // Obtener todos los posts
            'tax_query' => array(
                array(
                    'taxonomy' => 'tipopublicacion',
                    'field' => 'slug',
                    'terms' => $tipoPublicacion // El término seleccionado en el selector
                )
            )
        );

        $posts_query = new WP_Query($args);
        $fecha_options = '';
        $palabras_options = '';
        $posts = array();
        $fecha_publicaciones = array(); // Array para almacenar fechas únicas
        $palabras_claves = array();
        $fecha_options .= '<option>Seleccione una opción </option>';
        $palabras_options .= '<option>Seleccione una opción </option>';
        if ($posts_query->have_posts()) {
            while ($posts_query->have_posts()) {
                $posts_query->the_post();
                



                
                // Obtener las fechas asociadas al post (taxonomia)
                $fecha_publicacion = get_the_terms(get_the_ID(), 'year');
   
                if ($fecha_publicacion && !is_wp_error($fecha_publicacion)) {
                   
                    foreach ($fecha_publicacion as $term) {
                      
                      if(!in_array($term->slug, $fecha_publicaciones)){
                        $fecha_options .= '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                        $fecha_publicaciones[] = $term->slug;
                      }
                      
                    }
                }

                // Obtener las palabras clave asociadas al post 
                $palabras_clave = get_the_terms(get_the_ID(), 'pclave');
                if ($palabras_clave && !is_wp_error($palabras_clave)) {
                    
                    foreach ($palabras_clave as $term) {

                        if(!in_array($term->slug, $palabras_claves)){

                        $palabras_options .= '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                        $palabras_claves[] = $term->slug;

                        }
                        
                    }
                }

                // Vista de cada publicacion
                $imgUrl = get_the_post_thumbnail_url();
                $descriptionCard = get_the_excerpt();
                $url_pdf = get_post_meta(get_the_ID(), 'campo-pdfs', true);

                $year_terms = wp_get_post_terms(get_the_ID(), 'year');
                $year_term = $year_terms[0];
                $formatted_year = $year_term ? esc_html($year_term->name) : '';

                $posts[] = array(
                    'imgUrl' => $imgUrl,
                    'descriptionCard' => $descriptionCard,
                    'url_pdf' => $url_pdf,
                    'formatted_year' => $formatted_year,
                );
            }
        }

        // Restablecer consulta original de WordPress
        wp_reset_postdata();

        $options = array(
            'fecha_options' => $fecha_options,
            'palabras_options' => $palabras_options,
            'posts_html' => mostrar_publicaciones_filtradas($posts),
        );

        echo json_encode($options);
        wp_die();
    } else {
        // Devolver un mensaje de error si no se proporciona el tipo de publicación
        echo json_encode(array('error' => 'Tipo de publicación no especificado.'));
        wp_die();
    }
}

// Función para manejar la solicitud AJAX del tercer selector
add_action('wp_ajax_get_tercer_select_options', 'get_tercer_select_options');
add_action('wp_ajax_nopriv_get_tercer_select_options', 'get_tercer_select_options');

function get_tercer_select_options() {
    // Sanitizar y validar los datos de entrada
    $fecha_publicacion = isset($_POST['fecha_publicacion']) ? sanitize_text_field($_POST['fecha_publicacion']) : '';
    $tipoPublicacion = isset($_POST['tipo_publicacion']) ? sanitize_text_field($_POST['tipo_publicacion']) : '';



    if (!empty($fecha_publicacion)) {
        // Consulta para obtener los posts basados en la fecha de publicación seleccionada
        $args = array(
            'post_type' => 'publicacion', // Tipo de publicación
            'posts_per_page' => -1, // Obtener todos los posts
            'tax_query' => array(
                array(
                    'taxonomy' => 'year',
                    'field' => 'slug',
                    'terms' => $fecha_publicacion // El término seleccionado en el selector de fecha de publicación
                )
            )
        );



        if (!empty($tipoPublicacion)) {
            // Fusionar los parámetros con los existentes en $args
            $args['tax_query'][] = array(
                'taxonomy' => 'tipopublicacion',
                'field' => 'slug',
                'terms' => $tipoPublicacion // El término seleccionado en el selector
            );
        }
        











        $posts_query = new WP_Query($args);
        $palabras_options = '';
        $posts = array();

        if ($posts_query->have_posts()) {
            while ($posts_query->have_posts()) {
                $posts_query->the_post();
                
                // Obtener las palabras clave asociadas al post 
                $palabras_clave = get_the_terms(get_the_ID(), 'pclave');
                if ($palabras_clave && !is_wp_error($palabras_clave)) {
                    foreach ($palabras_clave as $term) {
                        $palabras_options .= '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                    }
                }

                // Vista de cada publicación
                $imgUrl = get_the_post_thumbnail_url();
                $descriptionCard = get_the_excerpt();
                $url_pdf = get_post_meta(get_the_ID(), 'campo-pdfs', true);
                $formatted_year = esc_html(get_the_title()); // Cambié "year" por el título del post ya que no está claro qué campo es la "fecha de publicación"

                $posts[] = array(
                    'imgUrl' => $imgUrl,
                    'descriptionCard' => $descriptionCard,
                    'url_pdf' => $url_pdf,
                    'formatted_year' => $formatted_year,
                );
            }
        }

        // Restablecer consulta original de WordPress
        wp_reset_postdata();

        $respuesta = array(
            'palabras_options' => $palabras_options,
            'posts_html' => mostrar_publicaciones_filtradas($posts),
        );

        echo json_encode($respuesta);
        wp_die();
    } else {
        // Devolver un mensaje de error si no se proporciona la fecha de publicación
        echo json_encode(array('error' => 'Fecha de publicación no especificada.'));
        wp_die();
    }
}

// Agregar el shortcode en functions.php o en un plugin
add_shortcode('filtro_publicaciones', 'filtro_publicaciones_shortcode');

function filtro_publicaciones_shortcode() {
    ob_start(); ?>
    <div class="filtros">
    <div class="container">
    <div class="col">
				<h2>Publicaciones</h2>
			    </div>
           

    <form id="filtro-publicaciones-form" class="form-row align-items-end">
        <div class="col-md-6 col-lg-3 px-3">

       

            <label for="tipo-publicacion">Tipo de Publicación:</label>
            <select name="tipo-publicacion" id="tipo-publicacion" class="custom-select">
                <option value="">Seleccione una opción</option>
                <?php
                // Obtener los términos de la taxonomía "tipo de publicación"
                $terms = get_terms(array(
                    'taxonomy' => 'tipopublicacion',
                    'hide_empty' => false, // Mostrar términos incluso si no están asociados con ningún post
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
            <label for="fecha-publicacion">Fecha de Publicación:</label>
            <select name="fecha-publicacion" id="fecha-publicacion" class="custom-select">
                <option value="">Seleccione una opción</option>
            </select>
        </div>
        <div class="col-md-6 col-lg-3 px-3">
            <label for="palabras-clave">Palabras Clave:</label>
            <select name="palabras-clave" id="palabras-clave" class="custom-select">
                <option value="">Seleccione una opción</option>
            </select>
        </div>


        <button type="button"  class="btn btn-enviar" id="filtrar-btn">Filtrar</button> <!-- Botón Filtrar -->
    </form>
</div>
    </div>

        <?php echo migas_de_pan(); ?>

    <div class="container">
<div id="resultado-publicaciones"></div>
        </div>

    <script>
        jQuery(document).ready(function($) {


            //funcion de carga instantanea

         
            $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                'action': 'cargar_todos_los_posts' // Nombre de la acción de WordPress
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

                        html += '<div class="card h-100">';
                        html += '<div class="foto">';
                        html += '<a href="' + post.url_pdf + '"><img class="img-fluid" src="' + post.imgUrl + '" alt="Imagen del post"></a>';
                        html += '</div>';
                        html += '<div class="nombre-publicacion">';
                        html += '<h5><a href="' + post.url_pdf + '">' + post.descriptionCard + post.formatted_year + '</a></h5>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    });
                    html += '</div>';

                    // Actualizar el contenido del elemento resultado-publicaciones
                    $('#resultado-publicaciones').html(html);
                } else {
                    // Si no hay posts, mostrar un mensaje
                    $('#resultado-publicaciones').html('<p>No se encontraron publicaciones.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar los posts: ' + error);
            }
        });


        
            // Función para cargar los filtros al cambiar cualquier opción
            function cargarFiltros() {
                var tipoPublicacion = $('#tipo-publicacion').val();
                var fechaPublicacion = $('#fecha-publicacion').val();
                var palabrasClave = $('#palabras-clave').val();
                
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'filtrar_publicaciones',
                        tipo_publicacion: tipoPublicacion,
                        fecha_publicacion: fechaPublicacion,
                        palabras_clave: palabrasClave
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#resultado-publicaciones').html(data.filtered_posts_html);
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
            $('#tipo-publicacion').change(function() {
                var tipoPublicacion = $(this).val();
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'get_fecha_palabras_options',
                        tipo_publicacion: tipoPublicacion
                    },
                    success: function(response) {
                        var options = JSON.parse(response);
                        // Restaurar los datos originales de los selectores
                        $('#fecha-publicacion').html(options.fecha_options);
                        $('#palabras-clave').html(options.palabras_options);
                     cargarFiltros(); // Cargar los resultados después de actualizar los selectores
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            // Función para cargar el tercer select al cambiar la fecha de publicación
            $('#fecha-publicacion').change(function() {
                var fechaSeleccionada = $(this).val();
                var tipoPublicacion = $('#tipo-publicacion').val();

                
                // Llamar al segundo AJAX para actualizar el tercer select
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'get_tercer_select_options',
                        fecha_publicacion: fechaSeleccionada,
                        tipo_publicacion: tipoPublicacion
                    },
                    success: function(response) {
                        var respuesta = JSON.parse(response);
                        // Actualizar el tercer select con la respuesta
                        $('#palabras-clave').html(respuesta.palabras_options);
                        //cargarFiltros(); // Cargar los resultados después de actualizar el selector
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>

    <?php
    return ob_get_clean();
}