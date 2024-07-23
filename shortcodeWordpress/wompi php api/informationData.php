<?php

// Obtener los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name_reference = $_POST['reference'];
    $payment_amount = $_POST['amount'];
    $nombre = $_POST['customer-data:full-name'];
    $correo = $_POST['customer-data:email'];
    $tipodocumento = $_POST['customer-data:legal-id-type'];
    $numdocumento = $_POST['customer-data:legal-id'];

    // Verificar los campos requeridos
    if (empty($name_reference) || empty($payment_amount) || empty($nombre) || empty($correo) || empty($tipodocumento) || empty($numdocumento)) {
        die('Error: Campos obligatorios no fueron recibidos.');
    }

    // Monto en centavos
    $amount = intval($payment_amount) * 100;
    $currency = 'COP';

    //generar referencia random
    $random_part = uniqid('', true);
    $name_reference .= $random_part . '_ENS_Womp1';
    $secreto_integridad = 'prod_integrity_llave'; // Secreto de integridad proporcionado
    $llave_publica_comercio = 'pub_prod_llave'; // Llave pública del comercio proporcionada
    $redirect_url = 'https://www.ens.org.co/wompi/intoTable.php';

    // Construir el string para generar el hash
    $string_hash = "{$name_reference}{$amount}{$currency}{$secreto_integridad}";

    // Generar el hash SHA-256
    $hash = hash('sha256', $string_hash);

    // Construir el final_url con los parámetros requeridos
    $final_url = http_build_query([
        'public-key' => $llave_publica_comercio,
        'amount' => $payment_amount,
        'amount-in-cents' => $amount,
        'reference' => $name_reference,
        'currency' => $currency,
        'signature:integrity' => $hash,
        'customer-data:full-name' => $nombre,
        'customer-data:email' => $correo,
        'customer-data:legal-id-type' => $tipodocumento,
        'customer-data:legal-id' => $numdocumento,
        'redirect-url' => $redirect_url
    ]);

    // Redireccionar al checkout de Wompi con los datos y el hash
    header("Location: https://checkout.wompi.co/p/VPOS_3l0Fiz?{$final_url}");
    exit;
}

?>
