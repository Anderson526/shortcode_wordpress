/**
 * File: ESDmetabox/js/archivo_meta_box.js
 * 
 * Jquery para la apertura de la biblioteca de medios
 * 
 */
jQuery(function($) {
    $('body').on('click', '.campo_recurso_pdf2', function(e) {
        e.preventDefault();
        var button = $(this);
        var inputName = button.attr('name'); // Obtener el valor del atributo 'data-input-name'

		console.log(inputName);
		
        var aw_uploader = wp.media({
            title: 'Documento para la biblioteca',
            library: {
                type: 'application/pdf'
            },
            button: {
                text: 'Usar este documento'
            },
            multiple: false
        }).on('select', function() {
            var attachment = aw_uploader.state().get('selection').first().toJSON();
            $('#' + inputName).val(attachment.url);
        }).open();
    });
});

