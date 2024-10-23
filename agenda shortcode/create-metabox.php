<?php
/**
 * File: Terraemetabox/include/create-metabox.php
 * 
 * Adiciona las cajas donde se visualizan los campos personalizados en los tipos de publicaciones
 * 
 * @package Lacigf
 * @subpackage Lacigf
 * @since Lacigf V 1.0
 */
/**
 * 1. Registra las cajas personalizadas para los nuevos campos requeridos en el sitio web. Define:
 * Posición de la caja en el momento de añadir un nuevo ítem
 * Tipo de entrada donde se visualiza la caja
 * Función que configura los nuevos campos
 **/


add_action('add_meta_boxes', 'lacigf_register_meta_boxes');
function lacigf_register_meta_boxes()
{
    //metabox lugar y fecha
    add_meta_box('meta_box_lugar', __('Lugar evento', 'lacigf'), 'lugarEventoLacigf', 'lacigfeventos', 'normal', 'high');
    add_meta_box('meta_box_fecha', __('fecha evento', 'lacigf'), 'fechaEventoLacigf', 'lacigfeventos', 'normal', 'high');
    add_meta_box('meta_box_URL', __('URL del evento', 'lacigf'), 'URLEventoLacigf', 'lacigfeventos', 'normal', 'high');
    //metabox order
    add_meta_box('meta_box_order', __('order', 'lacigf'), 'orderNovedad', 'novedad', 'normal', 'high');
    //metabox mapa 
    add_meta_box('meta_box_order', __('mapa', 'lacigf'), 'mapaContent', 'mapa', 'normal', 'high');
    //metabox enlace 
    add_meta_box('meta_box_order', __('Eventos', 'lacigf'), 'urlEvento', 'Eventos', 'normal', 'high');
    add_meta_box('meta_box_order', __('url aliados', 'lacigf'), 'urlEventoAliados', 'aliados', 'normal', 'high');
}
//metabox lugar y fecha

function lugarEventoLacigf($post)
{
    $valor_actual = get_post_meta(get_the_ID(), 'lugar-evento', true);
    $html = '<div class="editor-post-link">';
    $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
    $html .= '<div 	class="components-base-control__field css-1kyqli5 e1puf3u2">';
    $html .= '<label class="components-base-control__label css-4dk55l e1puf3u1" for="campo-enlace-autortestimonio" >' . esc_html__('lugar', 'lacigf') . '</label>';
    $html .= '<input type="text" name="lugar-evento" placeholder="ingrese el lugar del evento" size="22" id="lugar-evento" class="components-text-control__input" value="' . esc_attr($valor_actual) . '" required/>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<p>Escriba el lugar</p>';
    $html .= '</div>';
    echo $html;

}

function fechaEventoLacigf($post)
{
    $valor_actual = get_post_meta(get_the_ID(), 'fecha-evento', true);
    $html = '<div class="editor-post-link">';
    $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
    $html .= '<div 	class="components-base-control__field css-1kyqli5 e1puf3u2">';
    $html .= '<label class="components-base-control__label css-4dk55l e1puf3u1" for="campo-enlace-autortestimonio" >' . esc_html__('fecha', 'lacigf') . '</label>';
    $html .= '<input type="text" name="fecha-evento" placeholder="ingrese la fecha del evento" size="22" id="fecha-evento" class="components-text-control__input" value="' . esc_attr($valor_actual) . '" required/>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<p>Escriba la fecha</p>';
    $html .= '</div>';
    echo $html;

}


function URLEventoLacigf($post)
{
    $valor_actual = get_post_meta(get_the_ID(), 'campo_enlace_evento', true);

    // Comienza a construir el HTML para el campo de entrada
    $html = '<div class="inside">';
    $html .= '<p class="post-attributes-label-wrapper">';
    $html .= '<label class="post-attributes-label" for="campo_enlace_evento">' . esc_html__('Sitio web', 'lacigf') . '</label>';
    $html .= '</p>';
    $html .= '<input type="url" name="campo_enlace_evento" placeholder="http://ejemplo.com" size="90" id="campo_enlace_evento" class="post-attributes-input" value="' . esc_attr($valor_actual) . '" required />';
    $html .= '<p>Ejemplo: <code>https://lacigf.org/lacigf-16/</code> — Debe iniciar con <code>https://</code> o <code>http://</code></p>';
    $html .= '</div>';
    echo $html;
}

function orderNovedad($post)
{
    $valor_actual = get_post_meta(get_the_ID(), 'order-novedad', true);
    $html = '<div class="editor-post-link">';
    $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
    $html .= '<div 	class="components-base-control__field css-1kyqli5 e1puf3u2">';
    $html .= '<label class="components-base-control__label css-4dk55l e1puf3u1" for="" >' . esc_html__('orden', 'lacigf') . '</label>';
    $html .= '<input type="text" name="order-novedad" size="50" id="nombre-panelista" class="components-text-control__input" value="' . esc_attr($valor_actual) . '" required/>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<p>Escriba el orden de manera ascendente #</p>';
    $html .= '</div>';
    echo $html;

}

function mapaContent($post)
{
    $valor_actual = get_post_meta($post->ID, 'content-map', true);
    echo '<table>';
    echo '<tr>';
    echo '<td><textarea rows="10" cols="40" name="content-map">' . esc_textarea($valor_actual) . '</textarea></td>';
    echo '</tr>';
    echo '</table>';
}

//enlaces
function urlEvento($post)
{
    $valor_actual = get_post_meta($post->ID, 'url-evento', true);
    echo '<table>';
    echo '<tr>';
    echo '<td><input type="text" name="url-evento" value="' . esc_attr($valor_actual) . '" /></td>';
    echo '</tr>';
    echo '</table>';
}

function urlEventoAliados($post)
{
    $valor_actual = get_post_meta($post->ID, 'url-evento-aliados', true);
    echo '<table>';
    echo '<tr>';
    echo '<td><input type="text" name="url-evento-aliados" value="' . esc_attr($valor_actual) . '" /></td>';
    echo '</tr>';
    echo '</table>';
}


add_action('add_meta_boxes', 'lacigf_register_meta_boxes_panelistas');
function lacigf_register_meta_boxes_panelistas()
{
    add_meta_box('meta_box_nombre_panelista', __('Nombre del panelista', 'lacigf'), 'nombrePanelista', 'panelista', 'normal', 'high');
    add_meta_box('meta_box_cargo_panelista', __('Cargo del panelista', 'lacigf'), 'cargoPanelista', 'panelista', 'normal', 'high');
    add_meta_box('meta_box_organizacion_panelista', __('Organización del panelista', 'lacigf'), 'organizacionPanelista', 'panelista', 'normal', 'high');
    add_meta_box('meta_box_categoria_panelista', __('Categoría del panelista', 'lacigf'), 'categoriaPanelista', ['panelista', 'Agenda'], 'normal', 'high');
    add_meta_box('meta_box_pais_panelista', __('País del panelista', 'lacigf'), 'paisPanelista', 'panelista', 'normal', 'high');
}


function nombrePanelista($post)
{
    $valor_actual = get_post_meta($post->ID, 'nombre-panelista', true);
    $html = '<div class="editor-post-link">';
    $html .= '<div class="components-base-control">';
    $html .= '<div class="components-base-control__field">';
    $html .= '<label class="components-base-control__label" for="nombre-panelista">' . esc_html__('Nombre', 'lacigf') . '</label>';
    $html .= '<input type="text" name="nombre-panelista" size="50" id="nombre-panelista" class="components-text-control__input" value="' . esc_attr($valor_actual) . '" required />';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<p>' . esc_html__('Escriba el nombre', 'lacigf') . '</p>';
    $html .= '</div>';
    echo $html;
}

function organizacionPanelista($post)
{
    $valor_actual = get_post_meta(get_the_ID(), 'organizacion-panelista', true);
    $html = '<div class="editor-post-link">';
    $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
    $html .= '<div 	class="components-base-control__field css-1kyqli5 e1puf3u2">';
    $html .= '<label class="components-base-control__label css-4dk55l e1puf3u1" for="" >' . esc_html__('cargo', 'lacigf') . '</label>';
    $html .= '<input type="text" name="organizacion-panelista" placeholder="" size="50" id="organizacion-panelista" class="components-text-control__input" value="' . esc_attr($valor_actual) . '" required/>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<p>Escriba la organizacion</p>';
    $html .= '</div>';
    echo $html;
}

function cargoPanelista($post)
{
    $valor_actual = get_post_meta($post->ID, 'cargo-panelista', true);
    $html = '<div class="editor-post-link">';
    $html .= '<div class="components-base-control">';
    $html .= '<div class="components-base-control__field">';
    $html .= '<label class="components-base-control__label" for="cargo-panelista">' . esc_html__('Cargo', 'lacigf') . '</label>';
    $html .= '<input type="text" name="cargo-panelista" size="50" id="cargo-panelista" class="components-text-control__input" value="' . esc_attr($valor_actual) . '" required />';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<p>' . esc_html__('Escriba el cargo', 'lacigf') . '</p>';
    $html .= '</div>';
    echo $html;
}

function categoriaPanelista($post)
{
    $valor_categoria = get_post_meta(get_the_ID(), 'campo_categoria_panelista', true);

    $html = '<div class="inside">';
    $html .= '<p class="post-attributes-label-wrapper menu-order-label-wrapper">';
    $html .= '<label class="post-attributes-label" for="campo_categoria_panelista">' . esc_html__('Categoría', 'lacigf') . '</label>';
    $html .= '</p>';

    $html .= '<select id="campo_categoria_panelista" name="campo_categoria_panelista" class="post-attributes-input">';
    $options = [
        'ia' => 'IA y Tecnologías Emergentes',
        'derechos_humanos' => 'Derechos Humanos',
        'ciberseguridad' => 'Ciberseguridad',
        'acceso_universal' => 'Acceso universal y conectividad significativa',
        'gobernanza' => 'Gobernanza y cooperación digital',
        'medio_ambiente' => 'Medio ambiente y sostenibilidad',
        'educacion' => 'Educación y alfabetización digital',
        'genero' => 'Género y diversidad',
        'desafios_eticos' => 'Desafíos éticos y legales'
    ];

    foreach ($options as $value => $label) {
        $selected = selected($valor_categoria, $value, false);
        $html .= '<option value="' . esc_attr($value) . '" ' . $selected . '>' . esc_html($label) . '</option>';
    }

    $html .= '</select>';
    $html .= '<p>Seleccione la categoría de la sesión del panelista</p>';
    $html .= '</div>';

    echo $html;
}


function paisPanelista($post)
{
    $valor_pais = get_post_meta(get_the_ID(), 'campo_pais_panelistas', true);
    $arg_selected = '';

    // Determina la selección del país
    switch ($valor_pais) {
        case "argentina.svg":
            $arg_selected = " selected";
            break;
        case "Bahamas.svg":
            $bahamas_selected = " selected";
            break;
        case "Barbados.svg":
            $barbados_selected = " selected";
            break;
        case "Belize.svg":
            $belize_selected = " selected";
            break;
        case "Bolivia.svg":
            $bolivia_selected = " selected";
            break;
        case "Brazil.svg":
            $brazil_selected = " selected";
            break;
        case "Caicos_Islands.svg":
            $caicos_selected = " selected";
            break;
        case "Cayman_Islands.svg":
            $cayman_selected = " selected";
            break;
        case "Chile.svg":
            $chile_selected = " selected";
            break;
        case "Colombia.svg":
            $colombia_selected = " selected";
            break;
        case "Costa_Rica.svg":
            $costa_rica_selected = " selected";
            break;
        case "Cuba.svg":
            $cuba_selected = " selected";
            break;
        case "Dominica.svg":
            $dominica_selected = " selected";
            break;
        case "Dominican_Republic.svg":
            $dominican_selected = " selected";
            break;
        case "Ecuador.svg":
            $ecuador_selected = " selected";
            break;
        case "El_Salvador.svg":
            $el_salvador_selected = " selected";
            break;
        case "Grenada.svg":
            $grenada_selected = " selected";
            break;
        case "Guatemala.svg":
            $guatemala_selected = " selected";
            break;
        case "Guiana.svg":
            $guiana_selected = " selected";
            break;
        case "Guyana.svg":
            $guyana_selected = " selected";
            break;
        case "Haiti.svg":
            $haiti_selected = " selected";
            break;
        case "Honduras.svg":
            $honduras_selected = " selected";
            break;
        case "Jamaica.svg":
            $jamaica_selected = " selected";
            break;
        case "Martinique.svg":
            $martinique_selected = " selected";
            break;
        case "Mexico.svg":
            $mexico_selected = " selected";
            break;
        case "Nicaragua.svg":
            $nicaragua_selected = " selected";
            break;
        case "Panama.svg":
            $panama_selected = " selected";
            break;
        case "Paraguay.svg":
            $paraguay_selected = " selected";
            break;
        case "Peru.svg":
            $peru_selected = " selected";
            break;
        case "Puerto_Rico.svg":
            $puerto_rico_selected = " selected";
            break;
        case "Saint_Barthelemy.svg":
            $saint_barthelemy_selected = " selected";
            break;
        case "Saint_Kitts_and_Nevis.svg":
            $saint_kitts_selected = " selected";
            break;
        case "Saint_Lucia.svg":
            $saint_lucia_selected = " selected";
            break;
        case "Saint_Vincent_and_the_Grenadines.svg":
            $saint_vincent_selected = " selected";
            break;
        case "Suriname.svg":
            $suriname_selected = " selected";
            break;
        case "Trinidad_and_Tobago.svg":
            $trinidad_selected = " selected";
            break;
        case "Uruguay.svg":
            $uruguay_selected = " selected";
            break;
        case "Venezuela.svg":
            $venezuela_selected = " selected";
            break;
    }

    $html = '<div class="inside">';
    $html .= '<p class="post-attributes-label-wrapper menu-order-label-wrapper">';
    $html .= '<label class="post-attributes-label" for="campo_pais_panelistas">' . esc_html__('Pais', 'lacigf') . '</label>';
    $html .= '</p>';
    $html .= '<select id="campo_pais_panelistas" name="campo_pais_panelistas" class="post-attributes-input">';
    $html .= '<option value="argentina.svg"' . $arg_selected . '>Argentina</option>';
    $html .= '<option value="Bahamas.svg"' . $bahamas_selected . '>Bahamas</option>';
    $html .= '<option value="Barbados.svg"' . $barbados_selected . '>Barbados</option>';
    $html .= '<option value="Belize.svg"' . $belize_selected . '>Belice</option>';
    $html .= '<option value="Bolivia.svg"' . $bolivia_selected . '>Bolivia</option>';
    $html .= '<option value="Brazil.svg"' . $brazil_selected . '>Brasil</option>';
    $html .= '<option value="Caicos_Islands.svg"' . $caicos_selected . '>Islas Turcas y Caicos</option>';
    $html .= '<option value="Cayman_Islands.svg"' . $cayman_selected . '>Islas Caimán</option>';
    $html .= '<option value="Chile.svg"' . $chile_selected . '>Chile</option>';
    $html .= '<option value="Colombia.svg"' . $colombia_selected . '>Colombia</option>';
    $html .= '<option value="Costa_Rica.svg"' . $costa_rica_selected . '>Costa Rica</option>';
    $html .= '<option value="Cuba.svg"' . $cuba_selected . '>Cuba</option>';
    $html .= '<option value="Dominica.svg"' . $dominica_selected . '>Dominica</option>';
    $html .= '<option value="Dominican_Republic.svg"' . $dominican_selected . '>República Dominicana</option>';
    $html .= '<option value="Ecuador.svg"' . $ecuador_selected . '>Ecuador</option>';
    $html .= '<option value="El_Salvador.svg"' . $el_salvador_selected . '>El Salvador</option>';
    $html .= '<option value="Grenada.svg"' . $grenada_selected . '>Grenada</option>';
    $html .= '<option value="Guatemala.svg"' . $guatemala_selected . '>Guatemala</option>';
    $html .= '<option value="Guiana.svg"' . $guiana_selected . '>Guyana Francesa</option>';
    $html .= '<option value="Guyana.svg"' . $guyana_selected . '>Guyana</option>';
    $html .= '<option value="Haiti.svg"' . $haiti_selected . '>Haití</option>';
    $html .= '<option value="Honduras.svg"' . $honduras_selected . '>Honduras</option>';
    $html .= '<option value="Jamaica.svg"' . $jamaica_selected . '>Jamaica</option>';
    $html .= '<option value="Martinique.svg"' . $martinique_selected . '>Martinica</option>';
    $html .= '<option value="Mexico.svg"' . $mexico_selected . '>México</option>';
    $html .= '<option value="Nicaragua.svg"' . $nicaragua_selected . '>Nicaragua</option>';
    $html .= '<option value="Panama.svg"' . $panama_selected . '>Panamá</option>';
    $html .= '<option value="Paraguay.svg"' . $paraguay_selected . '>Paraguay</option>';
    $html .= '<option value="Peru.svg"' . $peru_selected . '>Perú</option>';
    $html .= '<option value="Puerto_Rico.svg"' . $puerto_rico_selected . '>Puerto Rico</option>';
    $html .= '<option value="Saint_Barthelemy.svg"' . $saint_barthelemy_selected . '>San Bartolomé</option>';
    $html .= '<option value="Saint_Kitts_and_Nevis.svg"' . $saint_kitts_selected . '>San Cristóbal y Nieves</option>';
    $html .= '<option value="Saint_Lucia.svg"' . $saint_lucia_selected . '>Santa Lucía</option>';
    $html .= '<option value="Saint_Vincent_and_the_Grenadines.svg"' . $saint_vincent_selected . '>San Vicente y las Granadinas</option>';
    $html .= '<option value="Suriname.svg"' . $suriname_selected . '>Suriname</option>';
    $html .= '<option value="Trinidad_and_Tobago.svg"' . $trinidad_selected . '>Trinidad y Tobago</option>';
    $html .= '<option value="Uruguay.svg"' . $uruguay_selected . '>Uruguay</option>';
    $html .= '<option value="Venezuela.svg"' . $venezuela_selected . '>Venezuela</option>';
    $html .= '</select>';
    $html .= '<p>Seleccione el país donde se encuentra ubicado el aliado</p>';
    $html .= '</div>';

    echo $html;
}



















add_action('add_meta_boxes', 'lacigf_register_meta_boxes_agenda');
function lacigf_register_meta_boxes_agenda()
{
    add_meta_box('meta_box_fecha_agenda', __('fecha de la agenda', 'lacigf'), 'fechaAgenda', 'Agenda', 'normal', 'high');
    add_meta_box('meta_box_hora_panelista', __('hora del panelista', 'lacigf'), 'horaAgenda', 'Agenda', 'normal', 'high');
    add_meta_box('meta_box_actividad_panelista', __('actividad del panelista', 'lacigf'), 'actividadAgenda', 'Agenda', 'normal', 'high');




}


























function horaAgenda($post)
{
    $valor_actual = get_post_meta(get_the_ID(), 'hora-agenda', true);
    if (!is_array($valor_actual)) {
        $valor_actual = array('');
    }

    $html = '<div class="editor-post-link">';
    $html .= '<div id="hora-actividades">';

    // Loop para generar los inputs de horas.
    foreach ($valor_actual as $index => $hora) {
        $html .= '<div class="hora-item">';
        $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
        $html .= '<div class="components-base-control__field css-1kyqli5 e1puf3u2">';
        $html .= '<label class="components-base-control__label css-4dk55l e1puf3u1" for="" >' . esc_html__('Hora agenda', 'lacigf') . '</label>';
        $html .= '<input type="text" name="hora-agenda[' . $index . ']" size="50" class="components-text-control__input" value="' . esc_attr($hora) . '" required/>';
        $html .= '</div>';
        $html .= '<button type="button" class="remove-hora">' . esc_html__('Eliminar', 'lacigf') . '</button>'; // Botón para eliminar
        $html .= '</div>';
        $html .= '</div>';
    }

    $html .= '</div>';
    $html .= '<button type="button" id="add-hora">' . esc_html__('Añadir hora', 'lacigf') . '</button>';
    $html .= '</div>';

    // Incluye el script para añadir y eliminar campos.
    $html .= '<script>
        document.getElementById("add-hora").addEventListener("click", function() {
            var container = document.getElementById("hora-actividades");
            var count = container.children.length;
            var div = document.createElement("div");
            div.classList.add("hora-item");
            div.innerHTML = \'<div class="components-base-control css-1wzzj1a e1puf3u3">\' +
                \'<div class="components-base-control__field css-1kyqli5 e1puf3u2">\' +
                \'<label class="components-base-control__label css-4dk55l e1puf3u1" for="">\' + "' . esc_html__('Hora agenda', 'lacigf') . '" + \'</label>\' +
                \'<input type="text" name="hora-agenda[\' + count + \']" size="50" class="components-text-control__input" required />\' +
                \'</div>\' +
                \'<button type="button" class="remove-hora">' . esc_html__('Eliminar', 'lacigf') . '</button>\' +
                \'</div>\';
            container.appendChild(div);
        });

        // Funcionalidad para eliminar horas
        document.addEventListener("click", function(e) {
            if (e.target.classList.contains("remove-hora")) {
                e.target.closest(".hora-item").remove();
            }
        });
    </script>';

    echo $html;
}



function guardarHoraAgenda($post_id)
{
    if (isset($_POST['hora-agenda'])) {
        $horas = array_map('sanitize_text_field', $_POST['hora-agenda']);
        update_post_meta($post_id, 'hora-agenda', $horas);
    }
}
add_action('save_post', 'guardarHoraAgenda');





//actividad agenda importante







function fechaAgenda($post)
{
    $valor_actual = get_post_meta(get_the_ID(), 'fecha-agenda', true);
    $html = '<div class="editor-post-link">';
    $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
    $html .= '<div 	class="components-base-control__field css-1kyqli5 e1puf3u2">';
    $html .= '<label class="components-base-control__label css-4dk55l e1puf3u1" for="" >' . esc_html__('orden', 'lacigf') . '</label>';
    $html .= '<input type="date" name="fecha-agenda" size="50" id="fecha-agenda" class="components-text-control__input" value="' . esc_attr($valor_actual) . '" required/>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<p>Escriba la fecha de la sesion(es importante que coincida para la correcta agrupación)</p>';
    $html .= '</div>';
    echo $html;

}




function actividadAgenda($post)
{
    // Inicializar arrays para cada sesión
    $valor_actual = get_post_meta(get_the_ID(), 'actividad-agenda', true);
    $sesiones = [];



    $opciones_categoria = [
        'ia' => 'IA y Tecnologías Emergentes',
        'derechos_humanos' => 'Derechos Humanos',
        'ciberseguridad' => 'Ciberseguridad',
        'acceso_universal' => 'Acceso universal y conectividad significativa',
        'gobernanza' => 'Gobernanza y cooperación digital',
        'medio_ambiente' => 'Medio ambiente y sostenibilidad',
        'educacion' => 'Educación y alfabetización digital',
        'genero' => 'Género y diversidad',
        'desafios_eticos' => 'Desafíos éticos y legales',
    ];


    // Si el valor actual no es un array, inicializar uno vacío
    if (!is_array($valor_actual)) {
        $valor_actual = [];
    }

    foreach ($valor_actual as $index => $actividad) {
        for ($i = 0; $i < 3; $i++) {
            $sesiones[$index][$i]['categoria'] = get_post_meta(get_the_ID(), "categoria_{$index}_{$i}", true);
            $sesiones[$index][$i]['descripcion'] = get_post_meta(get_the_ID(), "descripcion_{$index}_{$i}", true);
            $sesiones[$index][$i]['tema'] = get_post_meta(get_the_ID(), "tema_{$index}_{$i}", true);
            $sesiones[$index][$i]['objetivo'] = get_post_meta(get_the_ID(), "objetivo_{$index}_{$i}", true);
            $sesiones[$index][$i]['proponente'] = get_post_meta(get_the_ID(), "proponente_{$index}_{$i}", true);
            $sesiones[$index][$i]['tipo_sesion'] = get_post_meta(get_the_ID(), "tipo_sesion_{$index}_{$i}", true);

            $sesiones[$index][$i]['id_modal'] = get_post_meta(get_the_ID(), "id_modal_{$index}_{$i}", true);
            $sesiones[$index][$i]['titulo_sesion'] = get_post_meta(get_the_ID(), "titulo_sesion_{$index}_{$i}", true);

        }
    }

    $html = '<div class="editor-post-link"><div id="agenda-actividades">';
    foreach ($valor_actual as $index => $actividad) {
        $html .= '<div class="actividad-item">';
        $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
        $html .= '<label>' . esc_html__('Actividad', 'lacigf') . '</label>';
        $html .= '<input type="text" name="actividad-agenda[' . $index . ']" value="' . esc_attr($actividad) . '" required />';
        $html .= '</div>';

        for ($i = 0; $i < 3; $i++) {

            $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
            $html .= '<label>' . esc_html__('Categoría', 'lacigf') . '</label>';
            $html .= '<select name="categoria[' . $index . '][' . $i . ']">';

            foreach ($opciones_categoria as $key => $label) {
                $selected = selected($sesiones[$index][$i]['categoria'], $key, false);
                $html .= '<option value="' . esc_attr($key) . '" ' . $selected . '>' . esc_html($label) . '</option>';
            }

            $html .= '</select></div>';

            $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
            $html .= '<label>' . esc_html__('titulo_sesion', 'lacigf') . '</label>';
            $html .= '<input type="text" name="titulo_sesion[' . $index . '][' . $i . ']" value="' . esc_attr($sesiones[$index][$i]['titulo_sesion']) . '" />';
            $html .= '</div>';

            $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
            $html .= '<label>' . esc_html__('idmodal', 'lacigf') . '</label>';
            $html .= '<input type="text" name="id_modal[' . $index . '][' . $i . ']" value="' . esc_attr($sesiones[$index][$i]['id_modal']) . '" />';
            $html .= '</div>';

            $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
            $html .= '<label>' . esc_html__('Descripción', 'lacigf') . '</label>';
            $html .= '<input type="text" name="descripcion[' . $index . '][' . $i . ']" value="' . esc_attr($sesiones[$index][$i]['descripcion']) . '" />';
            $html .= '</div>';

            $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
            $html .= '<label>' . esc_html__('Tema', 'lacigf') . '</label>';
            $html .= '<input type="text" name="tema[' . $index . '][' . $i . ']" value="' . esc_attr($sesiones[$index][$i]['tema']) . '" />';
            $html .= '</div>';

            $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
            $html .= '<label>' . esc_html__('Objetivo', 'lacigf') . '</label>';
            $html .= '<input type="text" name="objetivo[' . $index . '][' . $i . ']" value="' . esc_attr($sesiones[$index][$i]['objetivo']) . '" />';
            $html .= '</div>';

            $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
            $html .= '<label>' . esc_html__('Proponente', 'lacigf') . '</label>';
            $html .= '<textarea name="proponente[' . $index . '][' . $i . ']">' . esc_textarea($sesiones[$index][$i]['proponente']) . '</textarea>';
            $html .= '</div>';

            $html .= '<div class="components-base-control css-1wzzj1a e1puf3u3">';
            $html .= '<label>' . esc_html__('Tipo de sesión', 'lacigf') . '</label>';
            $html .= '<input type="text" name="tipo_sesion[' . $index . '][' . $i . ']" value="' . esc_attr($sesiones[$index][$i]['tipo_sesion']) . '" />';
            $html .= '</div>';
        }

        $html .= '<button type="button" class="remove-actividad">' . esc_html__('Eliminar', 'lacigf') . '</button>';
        $html .= '</div>'; // Fin de actividad-item
    }

    $html .= '</div>';
    $html .= '<button type="button" id="add-actividad">' . esc_html__('Añadir actividad', 'lacigf') . '</button>';
    $html .= '</div>';

    // JavaScript para agregar nuevas actividades
    $html .= '<script>
        document.getElementById("add-actividad").addEventListener("click", function() {
            var container = document.getElementById("agenda-actividades");
            var count = container.children.length;
            var div = document.createElement("div");
            div.classList.add("actividad-item");
            div.innerHTML = \'<div class="components-base-control css-1wzzj1a e1puf3u3">\' +
                \'<label>\' + "' . esc_html__('Actividad', 'lacigf') . '" + \'</label>\' +
                \'<input type="text" name="actividad-agenda[\' + count + \']" required />\' +
                \'</div>\';
            for (var i = 0; i < 3; i++) {
                div.innerHTML += \'<div class="components-base-control css-1wzzj1a e1puf3u3">\' +

                     \'<label>\' + "' . esc_html__('Categoría', 'lacigf') . '" + \'</label>\' +
                    \'<select name="categoria[\' + count + \'][\' + i + \']">\' +
                    ' . json_encode(array_map(function ($key, $label) {
        return "<option value='$key'>' $label '</option>";
    }, array_keys($opciones_categoria), $opciones_categoria)) . ' +
                    \'</select>\' +
                    \'</div>\' +

                    \'<label>\' + "' . esc_html__('titulo_sesion', 'lacigf') . '" + \'</label>\' +
                    \'<input type="text" name="titulo_sesion[\' + count + \'][\' + i + \']" />\' +
                    \'</div>\' +
                    \'<label>\' + "' . esc_html__('id modal', 'lacigf') . '" + \'</label>\' +
                    \'<input type="text" name="id_modal[\' + count + \'][\' + i + \']" />\' +
                    \'</div>\' +
                    \'<label>\' + "' . esc_html__('Descripción', 'lacigf') . '" + \'</label>\' +
                    \'<input type="text" name="descripcion[\' + count + \'][\' + i + \']" />\' +
                    \'</div>\' +
                    \'<div class="components-base-control css-1wzzj1a e1puf3u3">\' +
                    \'<label>\' + "' . esc_html__('Tema', 'lacigf') . '" + \'</label>\' +
                    \'<input type="text" name="tema[\' + count + \'][\' + i + \']" />\' +
                    \'</div>\' +
                    \'<div class="components-base-control css-1wzzj1a e1puf3u3">\' +
                    \'<label>\' + "' . esc_html__('Objetivo', 'lacigf') . '" + \'</label>\' +
                    \'<input type="text" name="objetivo[\' + count + \'][\' + i + \']" />\' +
                    \'</div>\' +
                    \'<div class="components-base-control css-1wzzj1a e1puf3u3">\' +
                    \'<label>\' + "' . esc_html__('Proponente', 'lacigf') . '" + \'</label>\' +
                    \'<textarea name="proponente[\' + count + \'][\' + i + \']"></textarea>\' +
                    \'</div>\' +
                    \'<div class="components-base-control css-1wzzj1a e1puf3u3">\' +
                    \'<label>\' + "' . esc_html__('Tipo de sesión', 'lacigf') . '" + \'</label>\' +
                    \'<input type="text" name="tipo_sesion[\' + count + \'][\' + i + \']" />\' +
                    \'</div>\';
            }
            div.innerHTML += \'<button type="button" class="remove-actividad">' . esc_html__('Eliminar', 'lacigf') . '</button>\';
            container.appendChild(div);
        });

        document.addEventListener("click", function(e) {
            if (e.target.classList.contains("remove-actividad")) {
                e.target.closest(".actividad-item").remove();
            }
        });
    </script>';

    echo $html;
}

function guardarActividadAgenda($post_id)
{
    if (isset($_POST['actividad-agenda'])) {
        // Sanitize and save actividad-agenda
        $actividades = array_map('sanitize_text_field', $_POST['actividad-agenda']);
        update_post_meta($post_id, 'actividad-agenda', $actividades);

        foreach ($actividades as $index => $actividad) {
            for ($i = 0; $i < 3; $i++) {
                // Asegúrate de que cada campo existe y limpia los datos
                if (isset($_POST["descripcion"][$index][$i], $_POST["tema"][$index][$i], $_POST["objetivo"][$index][$i], $_POST["proponente"][$index][$i], $_POST["tipo_sesion"][$index][$i], $_POST["id_modal"][$index][$i])) {

                    // Limpieza de datos con el índice correspondiente a la actividad

                    $categoria = sanitize_text_field($_POST['categoria'][$index][$i]);
                    $titulo_sesion = sanitize_text_field($_POST["titulo_sesion"][$index][$i]);
                    $id_modal = sanitize_text_field($_POST["id_modal"][$index][$i]);
                    $descripcion = sanitize_text_field($_POST["descripcion"][$index][$i]);
                    $tema = sanitize_text_field($_POST["tema"][$index][$i]);
                    $objetivo = sanitize_text_field($_POST["objetivo"][$index][$i]);
                    $proponente = sanitize_textarea_field($_POST["proponente"][$index][$i]);
                    $tipo_sesion = sanitize_text_field($_POST["tipo_sesion"][$index][$i]);



                    // Guardar los campos con el índice de la actividad y el subíndice $i

                    update_post_meta($post_id, "categoria_{$index}_{$i}", $categoria);
                    update_post_meta($post_id, "titulo_sesion_{$index}_{$i}", $titulo_sesion);
                    update_post_meta($post_id, "id_modal_{$index}_{$i}", $id_modal);
                    update_post_meta($post_id, "descripcion_{$index}_{$i}", $descripcion);
                    update_post_meta($post_id, "tema_{$index}_{$i}", $tema);
                    update_post_meta($post_id, "objetivo_{$index}_{$i}", $objetivo);
                    update_post_meta($post_id, "proponente_{$index}_{$i}", $proponente);
                    update_post_meta($post_id, "tipo_sesion_{$index}_{$i}", $tipo_sesion);
                }
            }
        }
    }
}

add_action('save_post', 'guardarActividadAgenda');
