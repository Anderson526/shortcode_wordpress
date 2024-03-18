/**
 * File: ESDmetabox/js/archivo_meta_box.js
 * 
 * Jquery para la apertura de la biblioteca de medios
 * 
 */
jQuery(function($){
    $('body').on('click', '.campo_recurso_pdf', function(e){
        e.preventDefault();
        var button = $(this),
        aw_uploader = wp.media({
            title: 'Documento para la biblioteca',
            library : {
                type : 'application/pdf'
            },
            button: {
                text: 'Usar este documento'
            },
            multiple: false
        }).on('select', function() {
            var attachment = aw_uploader.state().get('selection').first().toJSON();
            $('#campo-pdfs').val(attachment.url);
        })
        .open();
    });
});