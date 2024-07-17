<?php
require_once ('../wp-load.php');


// Inicializamos las variables
$nombre = "";
$email = "";
$tipdoc = "";
$doc = "";

// Verificamos si se han enviado los parámetros por GET y asignamos los valores correspondientes
if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
}

if (isset($_GET['email'])) {
    $email = $_GET['email'];
}

if (isset($_GET['tipdoc'])) {
    $tipdoc = $_GET['tipdoc'];
}

if (isset($_GET['doc'])) {
    $doc = $_GET['doc'];
}

// Verificamos si se ha enviado el parámetro 'id' por GET
if (isset($_GET['id'])) {
    // Obtener y limpiar el valor del parámetro 'id' para prevenir inyecciones SQL
    $idtransaccion = $_GET['id']; // Convertimos a entero para asegurarnos que sea un número

    $url = "https://sandbox.wompi.co/v1/transactions/" . urlencode($idtransaccion);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Realizamos la solicitud GET y obtenemos la respuesta
    $response = curl_exec($ch);
    curl_close($ch);

    // Decodificamos la respuesta JSON
    $transaccion = json_decode($response, true);

    // Verificar si se obtuvo correctamente la transacción
    if ($transaccion && isset($transaccion['data'])) {
        // Obtener los valores individuales de la transacción
        $reference_pol = $transaccion['data']['reference'];
        $costo = $transaccion['data']['amount_in_cents'] / 100;
        $valorpagado = number_format($costo, 2);
        $estadotransaccion = $transaccion['data']['status'];
        $payment_method_type = $transaccion['data']['payment_method']['type'];

        // Asignar el estado_pol según el estado de la transacción
        $state_pol = ($estadotransaccion == "APPROVED") ? '4' : '6';

        // Asignar el payment_method_type según el tipo de método de pago
        switch ($payment_method_type) {
            case "NEQUI":
                $payment_method_type_value = '11';
                break;
            case "PSE":
                $payment_method_type_value = '4';
                break;
            case "BANCOLOMBIA_TRANSFER":
                $payment_method_type_value = '12';
                break;
            case "BANCOLOMBIA_QR":
                $payment_method_type_value = '13';
                break;
            case "PCOL":
                $payment_method_type_value = '14';
                break;
            case "CARD":
                $payment_method_type_value = '2';
                break;
            default:
                $payment_method_type_value = '15';
        }

        // aca guardar la tabla
        echo "Reference Pol: " . $reference_pol . "<br>";
        echo "Valor Pagado: " . $valorpagado . "<br>";
        echo "Estado Transacción: " . $estadotransaccion . "<br>";
        echo "Tipo Método de Pago: " . $payment_method_type . "<br>";
        echo "State Pol: " . $state_pol . "<br>";
        echo "Nombre: " . $nombre . "<br>";
        echo "Email: " . $email . "<br>";
        echo "Tipo de documento: " . $tipdoc . "<br>";
        echo "Documento: " . $doc . "<br>";


        global $wpdb; // Acceder a la base de datos de WordPress
        if (isset($wpdb)) {
            echo 'se ingreso a la funcion';
            // Insertar datos en la tabla
            $tabla = 'wp_wompiData'; // Nombre de la tabla
            $datos = array(
                'reference_sale' => $reference_pol,
                'nombre' => $nombre,
                'correo' => $email,
                'tipo_documento' => $tipdoc,
                'documento' => $doc,
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
                '%d', // valorpagado
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








        // Verificar si todos los campos ocultos están completos
        $fieldsAreValid = true; // Suponiendo que todos los campos están completos
        $hiddenInputs = array('reference_pol', 'valorpagado', 'state_pol', 'payment_method_type');
        foreach ($hiddenInputs as $input) {
            if (empty($$input)) {
                $fieldsAreValid = false;
                break;
            }
        }

        if ($fieldsAreValid) {
            echo "Todos los campos ocultos están completos.<br>";

            $confirmationurl = 'https://www.ens.org.co/gracias-por-su-donacion/';
            header('Location:' . $confirmationurl);
            exit();


        } else {
            echo 'Por favor, complete todos los campos ocultos antes de enviar.<br>';
        }
    } else {
        echo "No se pudo obtener la transacción o no hay datos disponibles.";
    }
} else {
    // En caso de que no se haya enviado el parámetro 'id'
    echo "No se ha enviado el parámetro 'id'";
}
