<?php
require_once ('../wp-load.php');

// Verificamos la transacción enviada por wompi
if (isset($_GET['id'])) {
    $idtransaccion = $_GET['id'];

    // URL para obtener los detalles de la transacción
    $url = "https://production.wompi.co/v1/transactions/" . urlencode($idtransaccion);

    // Inicializamos cURL para realizar la solicitud GET
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Realizamos la solicitud GET y obtenemos la respuesta
    $response = curl_exec($ch);
    curl_close($ch);

    // Verificamos si hubo un error en la solicitud
    if ($response === false) {
        die('Error al realizar la solicitud a Wompi.');
    }

    // Decodificamos la respuesta JSON
    $transaccion = json_decode($response, true);

    // Verificamos si se obtuvo correctamente la transacción
    if ($transaccion && isset($transaccion['data'])) {

        // Obtenemos el ID de referencia de la transacción
        $reference_pol = $transaccion['data']['reference'];

        // URL para consultar la referencia obtenida
        $url_consulta = 'https://production.wompi.co/v1/transactions?reference=' . $reference_pol;

        // Token Bearer 
        $token = 'Bearer prv_prod_llave';

        // Inicializamos cURL para realizar la solicitud POST
        $ch_consulta = curl_init($url_consulta);

        // Configuramos opciones de cURL para la consulta
        curl_setopt($ch_consulta, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_consulta, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: ' . $token, // Token Bearer
        ]);

        // Ejecutamos la solicitud cURL y obtenemos la respuesta
        $response_consulta = curl_exec($ch_consulta);

        // Verificamos si hubo un error en la solicitud
        if ($response_consulta === false) {
            echo 'Error de cURL: ' . curl_error($ch_consulta);
        } else {
            // Decodificamos la respuesta JSON
            $transaccion_consulta = json_decode($response_consulta, true);

            if ($transaccion_consulta && isset($transaccion_consulta['data'][0])) {
                $transaccion_data = $transaccion_consulta['data'][0]; // Accedemos al primer elemento del array
                $reference_pol = $transaccion_data['reference'];
                $costo = $transaccion_data['amount_in_cents'] / 100;
                $valorpagado = number_format($costo, 2);
                $estadotransaccion = $transaccion_data['status'];
                $payment_method_type = $transaccion_data['payment_method']['type'];
                $correoelectronico = $transaccion_data['customer_email'];
                $nombre = $transaccion_data['customer_data']['full_name'];
                $tipodocumento = $transaccion_data['customer_data']['legal_id_type'];
                $numerodocumento = $transaccion_data['customer_data']['legal_id'];
                $telefono = $transaccion_data['customer_data']['phone_number'];

                // Imprimir para verificar los valores obtenidos
                echo "Reference Pol: " . $reference_pol . "<br>";
                echo "Valor Pagado: " . $valorpagado . "<br>";
                echo "Estado Transacción: " . $estadotransaccion . "<br>";
                echo "Tipo Método de Pago: " . $payment_method_type . "<br>";
                echo "Correo Electrónico: " . $correoelectronico . "<br>";
                echo "Nombre: " . $nombre . "<br>";
                echo "Tipo de Documento: " . $tipodocumento . "<br>";
                echo "Número de Documento: " . $numerodocumento . "<br>";
                echo "Teléfono: " . $telefono . "<br>";

                global $wpdb; // Acceder a la base de datos de WordPress
                if (isset($wpdb)) {
                    // Insertar datos en la tabla
                    $tabla = 'wp_wompiData'; // Nombre de la tabla
                    $datos = array(
                        'reference_sale' => $reference_pol,
                        'nombre' => $nombre,
                        'correo' => $correoelectronico,
                        'tipo_documento' => $tipodocumento,
                        'documento' => $numerodocumento,
                        'payment_method_type' => $payment_method_type,
                        'valorpagado' => $valorpagado,
                        'state_pol' => $estadotransaccion
                    );

                    $formatos = array(
                        '%s', // reference_sale
                        '%s', // nombre
                        '%s', // correo
                        '%s', // tipo_documento
                        '%s', // documento
                        '%s', // payment_method_type
                        '%s', // valorpagado
                        '%d'  // state_pol
                    );

                    // Insertar datos en la tabla usando $wpdb
                    $wpdb->insert($tabla, $datos, $formatos);

                    // Comprobar si ha ocurrido algún error
                    if ($wpdb->last_error) {
                        echo "Error al insertar datos: " . $wpdb->last_error;
                    } else {
                        echo "Datos insertados correctamente.";
                    }
                } else {
                    echo "Error: No se pudo acceder a la base de datos de WordPress.";
                }
            } else {
                echo "No se encontró información válida para la transacción con la referencia proporcionada.";
            }
        }

        // Cerramos la sesión cURL de la consulta
        curl_close($ch_consulta);

    } else {
        echo "No se encontró información válida para la transacción con el ID proporcionado.";
    }

} else {
    // En caso de que no se haya enviado el parámetro 'id'
    echo "No se ha enviado el parámetro 'id'";
}

// Redireccionar al checkout de Wompi con los datos y el hash
header("Location: paginadedonacion.com");
exit;

?>
