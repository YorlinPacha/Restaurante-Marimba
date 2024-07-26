<?php
include_once 'admin/bd.php';
//1) Consultar solo un registro para luego mostrarlo - BANNERS
$sentencia = $conexion->prepare("SELECT * FROM tbl_banners ORDER BY id DESC LIMIT 1");
$sentencia->execute();
$listaBanners = $sentencia->fetchAll(PDO::FETCH_ASSOC);

//Consultar colaboradores
$sentencia = $conexion->prepare("SELECT * FROM tbl_colaboradores ORDER BY id DESC");
$sentencia->execute();
$listaColaboradores = $sentencia->fetchAll(PDO::FETCH_ASSOC);

//Consultar Testimonios
$sentencia = $conexion->prepare("SELECT * FROM tbl_testimonios ORDER BY id DESC LIMIT 4");
$sentencia->execute();
$listaTestimonios = $sentencia->fetchAll(PDO::FETCH_ASSOC);


//Consultar Menus
$sentencia = $conexion->prepare("SELECT * FROM tbl_menu ORDER BY id ");
$sentencia->execute();
$listaMenus = $sentencia->fetchAll(PDO::FETCH_ASSOC);
// print_r($listaMenus);

// 2) Recepcionar con POST el mensaje del formulario
if($_POST){
    //Cuidar que se inserten datos correctos y no basura
    //$nombre2 = filter_var($_POST["nombre"], FILTER_SANITIZE_STRING); PHP 8.1.0 NO LO ACEPTA - obsoleto
    $_POST = array_map('trim', $_POST); // eliminar espacios innecesarios
    $nombre = filter_var($_POST["nombre"], FILTER_UNSAFE_RAW);
    $correo = filter_var($_POST["correo"], FILTER_SANITIZE_EMAIL);
    $mensaje = filter_var($_POST["mensaje"], FILTER_UNSAFE_RAW);

    if ($nombre && $correo && $mensaje) {
        // Insertar en la base de datos
        $sentencia = $conexion->prepare("INSERT INTO tbl_comentarios (id, nombre, correo, mensaje)
        VALUES (NULL, :nombre, :correo, :mensaje);");

        $sentencia->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $sentencia->bindParam(":correo", $correo, PDO::PARAM_STR);
        $sentencia->bindParam(":mensaje", $mensaje, PDO::PARAM_STR);
        $sentencia->execute();
    }
    // Redireccion
    header("Location: index.php");
}

 ?>
<style>
    .barraNavegacion{
        opacity: .9;
    }
    .tituloBanner{
        font-family:sans-serif;
        font-weight: bold;
        font-size: 90px;
    }
    .descripcionBanner{
        font-size: 30px;
        font-weight:400;
    }
    .sloganFijo{
        opacity: .9;
    }
    .tituloSlogan{
        font-family:sans-serif;
        font-weight: bold;
        font-size: 30px;
    }
    .parrafoSlogan{
        font-family:sans-serif;
        font-weight: bold;
        font-size: 20px;
    }
</style>

<!doctype html>
<html lang="en">
    <head>
        <title>Marimba</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />

        <!-- iconos -->
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
            crossorigin="anonymous"
            referrerpolicy="no-referrer" />
    </head>

    <body>
        <!-- Barra navegacion -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark barraNavegacion">
            <div class="container">
                <a href="index.php" class="navbar-brand"><i class="fas fa-utensils"></i> Marimba</a>
                <!-- El boton activa o no el div con id=navbarNav de mas abajo-->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Div que contiene el menu y responsive-->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#banner">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#menu">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#chefs">Chefs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#testimonios">Testimonio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contacto">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#horario">Horario</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- mostrar Banner -->
        <section id="banner" class="container-fluid p-0">
            <div class="banner-img" style="position: relative; background:url('img/fondoPortada.jpg') center/cover no-repeat; height:44rem">
                <div class="banner-text" style="position: absolute; top:50% ; left:50%; transform: translate(-50%, -50%); text-align: center; color:#fff;">
                    <?php
                        foreach($listaBanners as $banner){
                    ?>
                        <h1 class="tituloBanner"><?php echo $banner["titulo"] ?></h1>
                        <p class="descripcionBanner"><?php echo $banner["descripcion"] ?></p>
                        <a href="<?php echo $banner["link"] ?>" class="btn btn-secondary">Ver Menu</a>
                    <?php }?>
                </div>
            </div>
        </section>

        <!-- slogan -->
        <section id="slogan" class="container mt-4 text-center sloganFijo">
            <div class="jumbotron bg-dark text-white">
                <br>
                <h2 class="tituloSlogan">¡Bienvenidos a la variedad de sabores!</h2>
                <p class="parrafoSlogan">
                    Descubre una experiencia culinaria de toda latinoamerica
                </p>
                <br>
            </div>
        </section>

        <!-- contenido importante chef-->
        <section id="chefs" class="container mt-4 text-center">
            <h2>Nuestros Chefs</h2>
            <div class="row">
                <!-- pantalla tiene 12, asi lo dividimos en 4 y sale para 3 chef -->
                 <?php foreach($listaColaboradores as $listaColaborador){?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="img/colaboradores/<?php echo $listaColaborador["foto"]?>" alt="chef 1" class="card-img-top">
                        <div class="card_body">
                            <h5 class="card-title"><?php echo $listaColaborador["titulo"] ?></h5>
                            <p class="card-text"><?php echo $listaColaborador["descripcion"] ?></p>
                            <div class="social-icons mt-3">
                                <a href="<?php echo $listaColaborador["linkFacebook"] ?>" class="text-dark me-2"><i class="fab fa-facebook"></i></a>
                                <a href="<?php echo $listaColaborador["linkLinkedin"] ?>" class="text-dark me-2"><i class="fab fa-linkedin"></i></a>
                                <a href="<?php echo $listaColaborador["linkInstagram"] ?>" class="text-dark me-2"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </section>

        <!-- testimonios -->
        <section id="testimonios" class="bg-light py-5">
            <div class="container">
                <h2 class="text-center mb-4"> Testimonios </h2>
                <div class="row">
                    <?php foreach($listaTestimonios as $listaTestimonio){?>
                    <div class="col-md-6 d-flex">
                        <div class="card mb-4 w-100">
                            <div class="card-body">
                                <p class="card-text"><?php echo $listaTestimonio["opinion"]?></p>
                            </div>
                            <div class="card-footer text-muted">
                            <?php echo $listaTestimonio["nombre"]?>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </section>

        <!-- Menu del restaurante -->
        <section id="menu" class="container mt-4">
            <h2 class="text-center">Menu (Nuestra recomendacion)</h2>
            <br>
            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php foreach($listaMenus as $listaMenu){?>
                    <div class="col d-flex">
                        <div class="card">
                            <img src="img/menu/<?php echo $listaMenu["foto"] ?>" alt="Foto menu" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $listaMenu["nombre"] ?></h5>
                                <p class="card-text small">
                                    <strong>Ingredientes: </strong><?php echo $listaMenu["ingredientes"] ?>
                                </p>
                                <p class="card-text"><strong>Precio: </strong>$<?php echo $listaMenu["precio"] ?></p>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </section>
        <br>
        <br>

        <!-- contacto -->
         <section class="container mt-4" id="contacto">
            <h2>Contacto</h2>
            <p>Estamos para servirte</p>
            <form action="?" method="post">
                <div class="mb-3">
                    <label for="nombre">Nombre:</label><br/>
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Escribe tu nombre..."required><br/>
                </div>
                <div class="mb-3">
                    <label for="correo">Email:</label><br>
                    <input type="email" class="form-control" name="correo" id="correo" placeholder="Escribe tu email..."required><br/>
                </div>
                <div class="mb-3">
                    <label for="mensaje">Mensaje:</label><br>
                    <textarea name="mensaje" class="form-control" id="mensaje" cols="30" rows="6" style="resize:none;"></textarea><br/>
                </div>
                <input type="submit" class="btn btn-primary" value="Enviar Mensaje">
            </form>
         </section>
         <br>

        <!-- Horario, sera estatico -->
         <div class="text-center bg-light p-4" id="horario">
            <h3 class="mb-4">Horario de atencion</h3>
            <div>
                <p class="dia"><strong>Martes a Viernes</strong></p>
                <p class="dia"><strong>6:00 pm - 2:00 am</strong></p>
            </div>
            <div>
                <p class="dia"><strong>Sabado</strong></p>
                <p class="dia"><strong>4:00 pm - 2:00 am</strong></p>
            </div>
            <div>
                <p class="dia"><strong>Domindo</strong></p>
                <p class="dia"><strong>4:00 pm - 2:00 am</strong></p>
            </div>
         </div>


        <!-- Pie de pagina -->
        <footer class="bg-dark text-light text-center py-3">
            <!-- place footer here -->
            <p>&copy; 2024 Marimba, Todos los derechos reservados </p>
        </footer>

        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
