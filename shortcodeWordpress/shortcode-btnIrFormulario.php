<?php
/**
 * File: lacigfCustomPostType/include/shortcode-btnIrFormulario.php
 * 
 *  Shortcode para redireccion de los formularios
 * 
 * @package lacigf
 * @subpackage lacigf
 * @since lacigf V 1.0
 */

function formButton_shortcode($atts)
{
    //permite iniciar parametros de manera dinamica
    $atts = shortcode_atts(
        array(
            'url' => '#',
        ),
        $atts,
        'boton'
    );
    $buttonForm = '<div class="my-4 text-right">
    <a class="btn-formulario" href="' . esc_url($atts['url']) . '">
      IR AL FORMULARIO
      </a>
  </div>';

    return $buttonForm;

}

add_shortcode('botonIrForm', 'formButton_shortcode');

