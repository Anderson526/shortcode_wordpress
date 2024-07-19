//shortcode wompi 

add_shortcode('donacionesBoton', 'btndonaciones');
function btndonaciones()
{
    ob_start();
    ?>

    <style>
        @media only screen and (max-width: 600px) {
            #submitButton {
                width: 100% !important;
            }
        }

        /* Media query para tablets (max-width: 768px) */
        @media only screen and (max-width: 768px) {
            #submitButton {
                width: 100% !important;
            }
        }
    </style>
    <button type="button" class="btn btn-primary" style="border: 0px transparent;
    margin-top: 20px;" id="submitButton"><a href="#">
            <div class="row">
                <div class="col-3">
                    <img
                        src="https://www.ens.org.co/wp-content/uploads/2024/07/photo_2024-07-16_09-04-08-removebg-preview-1.png">
                </div>
                <div class="col-9">
                    <p style="font-size:18px; color:#ffffff; height:0;">Apoyenos con una</p>
                    <p style="font-size:28px; color:#ffffff; height:0;">DONACIÓN</p>
                </div>
            </div>
        </a>
    </button>

    <?php
    wp_reset_postdata();
    return ob_get_clean();

}

function pagoWompi($atts, $content = null)
{
    ob_start();
    $signaturet = time();

    $amountInCents = 500000; 
    $currency = "COP";
    $integritySecret = "prod_integrity_llave";


    $hash = hash("sha256", $signaturet . $amountInCents . $currency . $integritySecret);


    ?>
    <form action="https://checkout.wompi.co/p/" method="GET" id="donationForm" style="background: #e7e5e5; border-radius: 5%; padding: 40px; margin-left: 7%;">
        <input type="hidden" name="public-key" value="pub_prod_llave" tabindex="-1" />
        <input type="hidden" name="currency" value="COP" tabindex="-1" />
        <input type="hidden" id="amount-in-cents" name="amount-in-cents" value="" tabindex="-1" />
        <input type="hidden" id="amount" name="amount" value="" tabindex="-1" />
        <input type="hidden" name="reference" value="<?php echo $signaturet; ?>" tabindex="-1" />
        <input type="hidden" id="signature-integrity" name="signature-integrity" value="<?php echo $hash; ?>" tabindex="-1" />
        <input type="hidden" id="redirect-url" name="redirect-url" value="" tabindex="-1" />

        <p><strong>Selecciona el monto de la donación:</strong></p>
        <input type="radio" name="donvalue" value="5000"><label class="ml-2">$5.000</label><br>
        <input type="radio" name="donvalue" value="10000"><label class="ml-2">$10.000</label><br>
        <input type="radio" name="donvalue" value="20000"><label class="ml-2">$20.000</label><br>
        <input type="radio" name="donvalue" value="50000"><label class="ml-2">$50.000</label><br>
        <input type="radio" name="donvalue" value="100000"><label class="ml-2">$100.000</label><br>

        <button type="button" style="border: 0px transparent; margin-top: 20px;" class="btn btn-primary" id="submitButton" onclick="validateAmount();">
            <img style="width: 15%; margin-right: 15px;" src="https://www.ens.org.co/wp-content/uploads/2024/07/photo_2024-07-16_09-04-08-removebg-preview-1.png"> Quiero donar
        </button>
        <small id="helptext"></small>

        <div class="modal fade" id="quieroDonar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body form-group">
                        <h2 class="mt-4">Muchas gracias por tu interés</h2>
                        <p><strong id="text-amount"></strong></p>
                        <p><strong>Tu aporte contribuye a mejorar las condiciones laborales de trabajadoras y trabajadores colombianos</strong></p>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nombre y apellido</label>
                                <input type="text" class="form-control" id="name" name="customer-data:full-name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Correo electrónico</label>
                                <input type="email" id="email" class="form-control" name="customer-data:email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Seleccione el tipo de documento</label>
                                <select class="form-control" id="tipdoc" name="customer-data:legal-id-type" required>
                                    <option value="TI">Documento identidad</option>
                                    <option value="CC">Cédula ciudadanía</option>
                                    <option value="NIT">Nit</option>
                                    <option value="CE">Cédula de extranjería</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Número de documento</label>
                                <input class="form-control" id="doc" type="number" name="customer-data:legal-id" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end m-4">
                        <button type="button" class="btn btn-secondary" onclick="sendPay();">Realizar la donación</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            validatefirst();
            var radioButtons = document.querySelectorAll('input[type="radio"][name="donvalue"]');

            radioButtons.forEach(function (radioButton) {
                radioButton.addEventListener('change', function () {
                    if (this.checked) {
                        var valueDonacion = this.value;
                        document.querySelector("#amount-in-cents").value = valueDonacion + "00";
                        document.querySelector("#amount").value = valueDonacion;
                        document.querySelector("#text-amount").textContent = "El monto seleccionado es: $" + valueDonacion;
                    }
                });
            });
        });

        function validatefirst() {
            var radioButtons = document.querySelectorAll('input[type="radio"][name="donvalue"]');
            var submitButton = document.getElementById('submitButton');

            radioButtons.forEach(function (radioButton) {
                radioButton.addEventListener('change', function () {
                    if (this.checked) {
                        submitButton.setAttribute('data-toggle', 'modal');
                        submitButton.setAttribute('data-target', '#quieroDonar');
                    } else {
                        submitButton.removeAttribute('data-toggle', 'modal');
                        submitButton.removeAttribute('data-target', '#quieroDonar');
                    }
                });
            });
        }

        function validateAmount() {
            var radioButtons = document.querySelectorAll('input[type="radio"][name="donvalue"]');
            var submitButton = document.getElementById('submitButton');
            var selected = false;
            let helpText = document.querySelector('#helptext');

            radioButtons.forEach(function (radioButton) {
                if (radioButton.checked) {
                    selected = true;
                }
            });

            if (selected) {
                helpText.textContent = ' ';
                submitButton.setAttribute('data-toggle', 'modal');
                submitButton.setAttribute('data-target', '#quieroDonar');
            } else {
                helpText.textContent = 'Recuerda seleccionar un monto para la donación';
                submitButton.removeAttribute('data-toggle', 'modal');
                submitButton.removeAttribute('data-target', '#quieroDonar');
            }
        }

        function sendPay() {
            let nombre = document.querySelector("#name").value;
            let email = document.querySelector("#email").value;
            let tipdoc = document.querySelector("#tipdoc").value;
            let doc = document.querySelector("#doc").value;
            var url1 = "https://www.ens.org.co/wompi/intoTable.php?nombre=" + nombre + "&email=" + email + "&tipdoc=" + tipdoc + "&doc=" + doc;
            let encoded = encodeURI(url1);
            document.querySelector("#redirect-url").value = encoded;
            document.getElementById('donationForm').submit();
        }
    </script>
    <?php
    wp_reset_postdata();
    return ob_get_clean();
}

add_shortcode('pagoWompiShortcode', 'pagoWompi');


function registerWompiDatabase()
{

    add_menu_page(
        'Base de datos wompi',
        'BD Wompi',
        'manage_options',
        'my_custom-page',
        'my_custom_page_content',
        'dashicons-admin-site',
        6

    );
}

add_action('admin_menu', 'registerWompiDatabase');

function my_custom_page_content()
{

    global $wpdb;

    $query = 'SELECT * FROM wp_wompiData';
    $results = $wpdb->get_results($query);


    echo '<div class="wrap">';
    echo '<h1>Título de la Página</h1>';
    echo '<table class="widefat fixed" cellspacing="0">';
    echo '<thead><tr>';
    echo '<th>Referencia</th>';
    echo '<th>Nombre</th>';
    echo '<th>Correo</th>';
    echo '<th>Tipo documento</th>';
    echo '<th>Documento</th>';
    echo '<th>Metodo de pago</th>';
    echo '<th>Valor de pago </th>';
    echo '<th>Estado</th>';
    echo '</tr></thead>';
    echo '<tbody>';

    if ($results) {
        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . esc_html($row->reference_sale) . '</td>';
            echo '<td>' . esc_html($row->nombre) . '</td>';
            echo '<td>' . esc_html($row->correo) . '</td>';
            echo '<td>' . esc_html($row->tipo_documento) . '</td>';
            echo '<td>' . esc_html($row->documento) . '</td>';
            echo '<td>' . esc_html($row->payment_method_type) . '</td>';
            echo '<td>' . esc_html($row->valorpagado) . '</td>';
            echo '<td>' . esc_html($row->state_pol) . '</td>';


            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="3">No se encontraron resultados.</td></tr>';
    }

    echo '</tbody></table>';
    echo '</div>';
}

