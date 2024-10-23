<?php
/**
 * File: ESDCustomPostType/include/shortcode-agenda.php
 * 
 * Shortcode para la lista de novedades
 * @author Anderson Chila P
 * @package lacigf
 * @subpackage lacigf
 * @since lacigf V 1.0
 */

// Shortcode agenda estructuras
function shortcode_agenda_inicio($atts, $content = null)
{
    // Obtener los atributos del shortcode, si es necesario
    $atts = shortcode_atts(array(
        'item_limit' => -1,
    ), $atts);

    // Realizar la consulta de publicaciones
    $args = array(
        'post_type' => 'Agenda',
        'posts_per_page' => $atts['item_limit'],
    );

    $query = new WP_Query($args);




    if ($query->have_posts()):
        $cont = 0;
        $dias = array();

        while ($query->have_posts() && $cont < $atts['item_limit']):
            $query->the_post();


            $current_post_id = get_the_ID();
            echo $current_post_id;


            // Obtener la fecha de cada sesión
            $fecha_sesion = get_post_meta(get_the_ID(), 'fecha-agenda', true);
            // Obtener la hora de la agenda
            $hora_agenda = get_post_meta(get_the_ID(), 'hora-agenda', true);
            // Obtener la actividad
            $actividad_agenda = get_post_meta(get_the_ID(), 'actividad-agenda', true);

            // Agrupar por fecha
            if (!isset($dias[$fecha_sesion])) {
                $dias[$fecha_sesion] = array();
            }

            // Almacenar los datos en la estructura de días
            $dias[$fecha_sesion][] = array(
                'hora' => $hora_agenda,
                'actividad' => $actividad_agenda,
                'id' => get_the_ID()
            );

            $cont++;



            ob_start();
            ?>
            <div class="mb-4">
                <h3 class="text-center">Día <?php echo get_the_title(); ?></h3>
                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <div class="table-responsive agenda">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Hora</th>
                                        <th scope="col">Actividad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($hora_agenda) === count($actividad_agenda)): ?>
                                        <?php for ($i = 0; $i < count($hora_agenda); $i++): ?>
                                            <tr>
                                                <td><?php echo esc_html($hora_agenda[$i]); ?></td>
                                                <td>
                                                    <?php
                                                    echo esc_html($actividad_agenda[$i]);
                                                    // Recuperar y mostrar los nuevos campos
                                




                                                    for ($j = 0; $j < 3; $j++) {
                                                        // Construir el índice para recuperar los metadatos
                                                        $current_post_id = get_the_ID();
                                                        $categoria = get_post_meta($current_post_id, "categoria_{$i}_{$j}", true);
                                                        $titulo_sesion = get_post_meta($current_post_id, "titulo_sesion_{$i}_{$j}", true);
                                                        $id_modal = get_post_meta($current_post_id, "id_modal_{$i}_{$j}", true);
                                                        $descripcion = get_post_meta($current_post_id, "descripcion_{$i}_{$j}", true);
                                                        $tema = get_post_meta($current_post_id, "tema_{$i}_{$j}", true);
                                                        $objetivo = get_post_meta($current_post_id, "objetivo_{$i}_{$j}", true);
                                                        $proponente = get_post_meta($current_post_id, "proponente_{$i}_{$j}", true);
                                                        $tipo_sesion = get_post_meta($current_post_id, "tipo_sesion_{$i}_{$j}", true);





                                                        echo '<div class="my-2">
                                                        <div class="row">
                                                            <div class="col-3 col-md-2 px-1">
                                                                <a href="#" data-toggle="modal" data-target="#modal' . esc_html($id_modal) . '" class="sala d-flex align-items-center justify-content-center">Sala ' . $j . '</a>
                                                            </div>
                                                            <!-- Modal -->
                                                            <div class="modal fade detalle-sesion" id="modal' . esc_html($id_modal) . '" tabindex="-1" aria-labelledby="modal' . esc_html($id_modal) . '" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                    <div class="modal-content p-4">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="evolucionGobernanzaLabel">' . esc_html($titulo_sesion) . '</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">×</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <h6>Descripción general de la sesión</h6>
                                                                            <p>' . esc_html($descripcion) . '</p>
                                                                            <h6>Tema</h6>
                                                                            <p>' . esc_html($tema) . '</p>
                                                                            <h6>Objetivo</h6>
                                                                            <p>' . esc_html($objetivo) . '</p>
                                                                            <h6>Proponentes</h6>
                                                                            <p>' . esc_html($proponente) . '</p>
                                                                            <h6>Tipo de sesión</h6>
                                                                            <p>' . esc_html($tipo_sesion) . '</p>
                                                                            <h6>Participantes</h6>';



                                                        $related_posts = new WP_Query(array(
                                                            'post_type' => 'panelista',

                                                        ));

                                                        if ($related_posts->have_posts()) {
                                                            while ($related_posts->have_posts()) {
                                                                $related_posts->the_post();
                                                                $titlerelated = the_title();
                                                                echo '<h1>' . esc_html($titlerelated) . '</h1>';

                                                            }
                                                            wp_reset_postdata();
                                                        }


                                                        echo '<div class="row detalle-panelistas"> 
                                                                              <div class="col-md-6 cada-participante">
                                                                                      <div class="row align-items-center mt-3">
                                                                                          <div class="col-4">
                                                                                              <img class="img-thumbnail foto-panelista mx-auto d-block" src="images/usuario.png" alt="Imagen alusiva a participante">
                                                                                          </div>
                                                                                          <div class="col-8">
                                                                                              <h6 class="nombre-panelista"></h6>
                                                                                              <h6 class="organizacion-panelista">Colnodo</h6>
                                                                                              <h6 class="cargo-panelista">Secretaría LACIGF</h6>
                                                                                          </div>
                                                                                      </div>
                                                                                      <div class="row">
                                                                                          <div class="col-md-12 px-3">
                                                                                              <a data-toggle="collapse" href="#NombreApellido1" role="button" aria-expanded="true" aria-controls="NombreApellido1" class="">
                                                                                                  <img src="images/masinfo1.png" alt="Grafica alusiva a ver más" class="img-fluid">
                                                                                              </a>
                                                                                              <div class="collapse" id="NombreApellido1">
                                                                                                  <p class="card-text"><strong>Máximo 60 palabras</strong> Ingeniera Electrónica de la Pontificia Universidad Javeriana, con especialización en Gerencia Comercial de la Universidad de la Sabana y Executive M.B.A de la IE Business School, España. Cuenta con más de 20 años de experiencia en el sector de telecomunicaciones, tiempo en el cual se ha desempeñado profesionalmente en el sector público y privado.</p>
                                                                                              </div>
                                                                                          </div>
                                                                                      </div>
                                                                                  </div><!-- cada-participante -->
                                                                              </div><!-- detalle-panelistas -->






                                                                              
                                                                          </div><!-- modal-body -->
                                                                          <div class="modal-footer">
                                                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                          </div>
                                                                      </div><!-- modal-content -->
                                                                  </div><!-- modal-dialog -->
                                                              </div><!-- modal -->
                                                          </div><!-- row -->
                                                      </div><!-- my-2 -->';



                                                        // Mostrar los campos si existen
                                                        /* if ($id_modal || $descripcion || $tema || $objetivo || $proponente || $tipo_sesion) {
                                                             echo '<div class="additional-info">';
                                                             if ($id_modal)
                                                                 echo '<p>ID Modal: ' . esc_html($id_modal) . '</p>';
                                                             if ($descripcion)
                                                                 echo '<p>Descripción: ' . esc_html($descripcion) . '</p>';
                                                             if ($tema)
                                                                 echo '<p>Tema: ' . esc_html($tema) . '</p>';
                                                             if ($objetivo)
                                                                 echo '<p>Objetivo: ' . esc_html($objetivo) . '</p>';
                                                             if ($proponente)
                                                                 echo '<p>Proponente: ' . esc_html($proponente) . '</p>';
                                                             if ($tipo_sesion)
                                                                 echo '<p>Tipo de Sesión: ' . esc_html($tipo_sesion) . '</p>';
                                                             echo '</div>';
                                                         }*/




                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>



                                    <?php else: ?>
                                        <tr>
                                            <td colspan="2">Los arrays no tienen la misma cantidad de elementos.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    endif;
    return ob_get_clean();
}

add_shortcode('agenda_inicio', 'shortcode_agenda_inicio');
