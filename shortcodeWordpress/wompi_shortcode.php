

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
    $hash = hash("sha256", "codehash"); //"37c8407747e595535433ef8f6a811d853cd943046624a0ec04662b17bbf33bf5"
    ?>

    <form action="https://checkout.wompi.co/p/" method="GET" id="donationForm" style="
background: #e7e5e5;
border-radius: 5%;
padding: 40px;
margin-left: 7%;
">

        <input type="hidden" name="public-key" value="pub_test_Q5yDA9xoKdePzhSGeVe9HAez7HgGORGf" tabindex="-1" />
        <input type="hidden" name="currency" value="COP" tabindex="-1" />
        <input type="hidden" id="amount-in-cents" name="amount-in-cents" value="" tabindex="-1" />
        <input type="hidden" id="amount" name="amount" value="" tabindex="-1" />
        <input type="hidden" name="reference" value="<?php echo time(); ?>" tabindex="-1" />
        <input type="hidden" id="signature-integrity" name="signature-integrity" value="<?php echo $hash; ?>"
            tabindex="-1" />
        <input type="hidden" id="redirect-url" name="redirect-url" value="" tabindex="-1" />


        <p><strong>Seleccione el monto de la donación:</strong></p>

        <input type="radio" id="" name="donvalue" value="5000">
        <label class="ml-2">$5.000</label><br>

        <input type="radio" id="" name="donvalue" value="10000">
        <label class="ml-2">$10.000</label><br>

        <input type="radio" id="" name="donvalue" value="20000">
        <label class="ml-2">$20.000</label><br>

        <input type="radio" id="" name="donvalue" value="50000">
        <label class="ml-2">$50.000</label><br>

        <input type="radio" id="" name="donvalue" value="100000">
        <label class="ml-2">$100.000</label><br>

        <!-- Button trigger modal -->
        <button type="button" style="border: 0px transparent;
    margin-top: 20px;" class="btn btn-primary" id="submitButton" onclick="validateAmount();">
            <img style="width: 15%;
    margin-right: 15px;"
                src="https://www.ens.org.co/wp-content/uploads/2024/07/photo_2024-07-16_09-04-08-removebg-preview-1.png">
            Quiero donar
        </button>

        <!-- Modal -->
        <div class="modal fade" id="quieroDonar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body form-group">
                        <h2 class="mt-4">Muchas gracias por tu interes</h2>
                        <p><strong id="text-amount"></strong></p>
                        <p><strong>Tu aporte contribuye a mejorar las condiciones laborales de trabajadoras y trabajadores
                                colombianos</strong></p>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="">Nombre y apellido</label>
                                <input type="text" class="form-control" id="name" name="customer-data:full-name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Correo electrónico</label>
                                <input type="text" id="email" class="form-control" name="customer-data:email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Selecione el tipo de documento</label>
                                <select class="form-control" id="tipdoc" name="customer-data:legal-id-type" required>
                                    <option value="TI">Documento identidad</option>
                                    <option value="CC">Cedula ciudadania</option>
                                    <option value="NIT">Nit </option>
                                    <option value="CE">Cedula de extrangeria</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Numero de documento</label>
                                <input class="form-control" id="doc" type="number" name="customer-data:legal-id" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end m-4">
                        <button type="submit" class="btn btn-secondary" onclick="sendPay();" id="btnEnviar">Realizar la
                            donación</button>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            validateAmount();
            var radioButtons = document.querySelectorAll('input[type="radio"][name="donvalue"]');

            radioButtons.forEach(function (radioButton) {
                radioButton.addEventListener('change', function () {
                    if (this.checked) {
                        var valueDonacion = this.value;
                        console.log(valueDonacion);
                        document.querySelector("#amount-in-cents").value = valueDonacion + "00";
                        document.querySelector("#amount").value = valueDonacion;
                        document.querySelector("#text-amount").textContent = "El monto seleccionado es: $" + valueDonacion;


                    }
                });
            });
        });



        function validateAmount() {
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


        function sendPay() {
            let nombre = document.querySelector("#name").value;
            let email = document.querySelector("#email").value;
            let tipdoc = document.querySelector("#tipdoc").value;
            let doc = document.querySelector("#doc").value;
            var url1 = "https://www.ens.org.co/wompi/intoTable.php?nombre=" + nombre + "&email=" + email + "&tipdoc=" + tipdoc + "&doc=" + doc;
            let encoded = encodeURI(url1);
            document.querySelector("#redirect-url").value = encoded;
        }


    </script>
    <?php
    wp_reset_postdata();
    return ob_get_clean();
}

add_shortcode('pagoWompiShortcode', 'pagoWompi');
