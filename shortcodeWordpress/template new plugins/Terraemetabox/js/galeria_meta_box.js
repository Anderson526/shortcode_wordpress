/**
 * File: ESDmetabox/js/galeria_meta_box.js
 * 
 * Jquery para la apertura de la biblioteca de medios para las imagenes alojadas en la galeria de recursos
 * 
 */


jQuery(document).ready(function($){
	var meta_gallery_frame;

	$( '#boton_crear_galeria' ).click(function(e) {
		e.preventDefault();
		// Si el frame existe abre la modal.
        if ( meta_gallery_frame ) {
            meta_gallery_frame.open();
            return;
		}
		// Si no hay valores crea una galería de cero, si los hay edita la actual.
		var ids_galeria = $( '#ids_galeria' ).val();
		if ( !( ids_galeria ) ) {
			// Crea un nuevo frame de tipo galería
			meta_gallery_frame = wp.media.frames.wp_media_frame = wp.media( {
				title: 'Galería de fotografías',
				frame: "post",
				state: 'gallery-library',
				library: {
					type: 'image'
				},
				multiple: true
			} );
			// Abre la modal con el frame
			meta_gallery_frame.open();
		} else {
			// Abre la modal con el frame y con los attachment de la galería cargados
			meta_gallery_frame = wp.media.gallery.edit( "[gallery ids='" + ids_galeria + "']" );
		}
		// Cuando se actualice la galería, pulsando el botón correspondiente de la modal, 
		// actualiza las miniaturas y los valores que se guardarán en el input oculto.
		meta_gallery_frame.on("update", function(selection) {
			var $vista_previa = $( '#mb-vista-previa-galeria' )
			$vista_previa.html( '' );
			// La función map itera sobre selection.models, crea el código html y devuelve los ids.
			var ids = selection.models.map(
				function( e ) {
					elemento = e.toJSON();
					imagen_url = typeof elemento.sizes.thumbnail !== 'undefined' ? elemento.sizes.thumbnail.url : elemento.url;
					html = "<div class='mb-miniatura-galeria'><img src='" + imagen_url + "'></div>";
					$vista_previa.append( html );
					return e.id;
				}
			);
			$( '#ids_galeria' ).val( ids.join( ',' ) ).trigger( 'change' );
		});
	});

	$('#boton_eliminar_galeria').click(function(e) {
		e.preventDefault();
		// Elimina los ids del input.
		$( '#ids_galeria' ).val( '' ).trigger( 'change' );
		// Elimina las miniaturas.
		$( '#mb-vista-previa-galeria' ).html( '' );
		return;
	});

});





/*

jQuery(document).ready(function($){
    var custom_uploader;

    $('#boton_crear_galeria').click(function(e) {
        e.preventDefault();

        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        custom_uploader = wp.media({
            title: 'Seleccionar Imagen',
            button: {
                text: 'Usar esta imagen'
            },
            multiple: true  // Permitir la selección de múltiples imágenes
        });

        custom_uploader.on('select', function() {
            var images = custom_uploader.state().get('selection');

            var imageUrls = [];
            images.each(function(image) {
                var imageUrl = image.toJSON().url;
                imageUrls.push(imageUrl);
            });

            // Unir las URL de las imágenes seleccionadas y separarlas por comas
            var selectedImages = imageUrls.join(',');

            // Asignar las URL de las imágenes al campo de texto
            $('#imagen_personalizada').val(selectedImages);
        });

        custom_uploader.open();
    });
});
*/
