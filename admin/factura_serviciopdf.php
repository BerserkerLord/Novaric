<?php
    require_once '../vendor/autoload.php';
    require('controllers/facturas/factura_servicio.controller.php');
    use Dompdf\Dompdf;

    $dompdf = new Dompdf();
    $factura_servicios = new FacturaServicio;
    $id_factura = $_GET['id_factura'];
    $servicio = $factura_servicios -> readServiciosFactura($id_factura);
    $cliente = $factura_servicios -> readClienteServicio($id_factura);
    $factura = $factura_servicios -> readFacturaServicio($id_factura);

    $html = '
        <head>
            <title>Factura</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                    font-size: 14px;
                }

                body {
                    width: 100%;
                    height: 100%;
                    line-height: 2;
                }
                
                body {
                    background-color: #f6f6f6;
                }
                
                .content {
                    max-width: 600px;
                    margin: 0 auto;
                    display: block;
                    padding: 20px;
                }
                
                .main {
                    background: #fff;
                    border: 1px solid #e9e9e9;
                    border-radius: 3px;
                }
                
                .content-wrap {
                    padding: 20px;
                }
                
                .content-block {
                    padding: 0 0 20px;
                }
                
                h2{
                    font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
                    color: #000;
                    margin: 40px 0 0;
                    line-height: 1.2;
                    font-weight: 400;
                    font-size: 24px;
                } 
                
                .alignright {
                    text-align: right;
                }
                
                .alignleft {
                    text-align: left;
                }
                
                .invoice {
                    margin: 40px auto;
                    text-align: left;
                    width: 80%;
                }
                .invoice td {
                    padding: 5px 0;
                }
                .invoice .invoice-items {
                    width: 100%;
                }
                .invoice .invoice-items td {
                    border-top: #eee 1px solid;
                }
                .invoice .invoice-items .total td {
                    border-top: 2px solid #333;
                    border-bottom: 2px solid #333;
                    font-weight: 700;
                }
            </style>
        </head>
        <body>
            <table class="body-wrap">
                <tbody>
                    <tr>
                        <td class="container" width="600">
                            <div class="content">
                                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td class="content-wrap aligncenter">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="content-block">
                                                                <h2>Factura de Servicios</h2>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="content-block">
                                                                <table class="invoice">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>' . $cliente[0][1] . '<br>' . $cliente[0]['email'] . '<br>Factura #' . $factura[0]['id_factura'] . '<br>' . $factura[0]['fecha'] . '<br>Estatus: ' . $factura[0]['estatus_factura'] . ' . <br>Descripción: ' . $factura[0]['descripcion'] . '. <br>Ubicación: ' . $factura[0]['domicilio'] . '</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="invoice-items" cellpadding="0" cellspacing="0">
                                                                                    <thead>
                                                                                        <tr style="background-color: #e6eaee">
                                                                                            <td>Servicio</td>
                                                                                            <td class="line0 alignright">Monto</td>                                                                                                                                                                                                                                                                                                                                                                                                
                                                                                        </tr>    
                                                                                    </thead>
                                                                                    <tbody>';
                                                                                        $total = 0;
                                                                                        foreach ($servicio as $key => $servicios):
                                                                                            $total += $servicios['monto'];
                                                                                        $html .= '<tr>
                                                                                                    <td>' . $servicios['servicio'] . '</td>
                                                                                                    <td class="alignright">$' . $servicios['monto'] . '</td>
                                                                                                  </tr>';
                                                                                        endforeach;
                                                                                        $html .= '<tr class="total">
                                                                                                    <td class="alignright" width="80%">Total</td>
                                                                                                    <td class="alignright">$' . $total . '</td>
                                                                                                  </tr>';
                                                                          $html .= '</tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="content-block">
                                                                Novaric, 102 int. 302 Sanjuanico, Celaya México
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </body>
    ';
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream("Factura", array("Attachment" => 0));
?>