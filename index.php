<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Dario Zarate">
        <meta name="description" content="Hospital San Juan">
        <meta name="keywords" content="hospital san juan doctores especialidad">
        <title>Novaric</title>
        <link href="./css/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
        <link href="./css/main_page.css" rel="stylesheet">
        <link href="./css/fontawesome/css/all.css" rel="stylesheet">
        <link href="./css/features.css" rel="stylesheet">
        <link href="./css/slick-1.8.1/slick/slick.css" rel="stylesheet" type="text/css"/>
        <link href="./css/slick-1.8.1/slick/slick-theme.css" rel="stylesheet" type="text/css"/>
        <script src="./css/bootstrap/js/bootstrap.js"></script>
    </head>
    <body style="position: relative;" data-bs-spy="scroll" data-bs-target="#navbar">
        <nav id="navbar" class="navbar navbar-light bg-light px-3 fixed-top">
            <div class="d-flex">
                <div class="d-flex">
                    <div class="d-flex align-items-center">
                        <i class="icons fas fa-phone p-1"></i>
                        <p class="nav">461 406 2575</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="icons fas fa-mail-bulk p-1"></i>
                        <p class="nav ">contacto@novaric.com</p>
                    </div>
                </div>
            </div>
            <a class="navbar-brand" href="#"><img src="./imagenes/logo.png" alt="logo" width="135" height="45" class="d-inline-block align-text-top"></a>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="#scrollspyHeading1">Presentación</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#scrollspyHeading2">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#scrollspyHeading3">Marcas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#scrollspyHeading4">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#scrollspyHeading5">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login/login.php">Ingresar</a>
                </li>
            </ul>
        </nav>
        <div class="main container-fluid" id="scrollspyHeading1">
            <div class="single-item">
                <div><img class="carousel-item" alt="slider image" src="./imagenes/slide5.jpg"></div>
                <div><img class="carousel-item" alt="slider image" src="./imagenes/slide1.jpg"></div>
                <div><img class="carousel-item" alt="slider image" src="./imagenes/slide3.jpg"></div>
                <div><img class="carousel-item" alt="slider image" src="./imagenes/slide4.jpg"></div>
            </div>
        </div>
        <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example container-fluid" tabindex="0"> <!--Sección-->
            <div class="bg-light text-dark">
                <div class="row presentation">
                    <div class="col-md-5">
                        <div>
                            <img src="./imagenes/logo.png" alt="hospital1" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h2 class="display-6">Sistemas de Riego</h2>
                        <p>
                            Novaric es una empresa que se encarga de soluciones dde riego en el ambito
                            industrial y del hogar, brindando un servicio de calidad y usando materiales
                            de primera, así como la venta de piezas o material para riego
                        </p>
                    </div>
                </div>
            </div>
            <div class="row servicios">
                <h2 class="mb-4 border-bottom display-6" id="scrollspyHeading2">Nuestros Servicios</h2>
                <?php
                error_reporting(0);
                require_once('./admin/controllers/servicios.controller.php');
                $servicios = new Servicio;
                $datos = $servicios -> readAll();
                foreach($datos as $key => $servicio):
                    ?>
                    <div class="col-md-4">
                        <div class="card" style="width: 18rem;">
                            <img src="./archivos/<?=$servicio['fotografia']?>" class="card-img-top" alt="servicio">
                            <div class="card-body">
                                <h5 class="card-title"><?php print_r($servicio['servicio'])?></h5>
                                <p class="card-text"><?=$servicio['descripcion']?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="row servicios bg-light" id="scrollspyHeading3">
                <h2 class="mb-4 border-bottom display-6">Marcas</h2>
                <?php
                error_reporting(0);
                require_once('./admin/controllers/marcas.controller.php');
                $marcas = new Marca;
                $datos = $marcas -> readAll();

                foreach($datos as $key => $marca):
                    ?>
                    <div class="col-md-4">
                        <div class="card" style="width: 18rem;">
                            <img src="./archivos/<?=$marca['fotografia']?>" class="card-img-top" alt="marca">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="row servicios" id="scrollspyHeading4">
                <h2 class="mb-4 border-bottom display-6">Nosotros</h2>
            </div>
            <div class="row text-center pt-4 pb-3">
                <div class="col-md-4">
                    <img src="./imagenes/target.png" alt="mision" class="img-fluid nosotros-img" width="200">
                    <h2>Misión</h2>
                    <p>
                        Proporcionar servicios y materiales de calidad a nuestros clientes
                    </p>
                </div>
                <div class="col-md-4">
                    <img src="./imagenes/vision.png" alt="vision" class="img-fluid nosotros-img" width="200">
                    <h2>Visión</h2>
                    <p>
                        Ser una empresa reconocida en la región por su calidad y por sus servicios, así
                        como la atención y disctribución al cliente.
                    </p>
                </div>
                <div class="col-md-4">
                    <img src="./imagenes/values.png" alt="valores" class="img-fluid nosotros-img" width="200">
                    <h2>Valores</h2>
                    <p>
                        Actitud de Servicio, Ética, Honstidad, Responsabilidad, Igualdad.
                    </p>
                </div>
            </div>

            <div class="row servicios bg-light" id="scrollspyHeading5">
                <h2 class="mb-4 border-bottom display-6">Contacto</h2>
            </div>
            <div class="row border-bottom">
                <div class="col-md-8">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3736.7900588113816!2d-100.79209568495894!3d20.5148308104993!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842cb087cbd96d69%3A0xdafaefa8977fd839!2sSistemas%20de%20Riego%20de%20Celaya%20S.A.%20de%20C.V.!5e0!3m2!1ses!2smx!4v1625629765598!5m2!1ses!2smx"
                            style="width:100%; border:0;" height="450" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="col-md-4">
                    <div class="mx-auto">
                        <div class="d-flex flex-row">
                            <i class="icons fas fa-location-arrow p-1"></i>
                            <p class="nav">Av Tres Guerras 450, 3 Guerras, 38080 Celaya, Gto.</p>
                        </div>
                        <div class="d-flex flex-row">
                            <i class="icons fas fa-phone p-1"></i>
                            <p class="nav">Teléfono: 461 123 4567</p>
                        </div>
                        <div class="d-flex flex-row">
                            <i class="icons fas fa-link p-1"></i>
                            <p class="nav">https://novaric.000webhostapp.com/</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <footer class="container-fluid presentation text-dark" style="background-color: mediumseagreen"> <!--Pie de Página-->
                <div class="row">
                    <div class="col-md-4">
                        <img src="./imagenes/logo.png" alt="logo" class="img-fluid logo">
                    </div>
                    <div class="col-md-4">
                        <ul class="lista_sin_estilo">
                            <li>Av Tres Guerras 450, 3 Guerras, 38080 Celaya, Gto.</li>
                            <li>Recepción: (461) 6120137</li>
                            <li>Contabilidad: (461) 6123905</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li>Goteo</li>
                            <li>Riego</li>
                            <li>Nebulización</li>
                            <li>Diseño</li>
                            <li>Venta de material</li>
                        </ul>
                    </div>
                </div>
            </footer>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.js"></script>
            <script>
            (function () {
                'use strict'
                var forms = document.querySelectorAll('.needs-validation')
                Array.prototype.slice.call(forms)
                    .forEach(function (form) {
                        form.addEventListener('submit', function (event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }
                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
            $('.single-item').slick({
                arrows: false,
                autoplay: true,
                autoplaySpeed: 2000
            })
        </script>
    </body>
</html>