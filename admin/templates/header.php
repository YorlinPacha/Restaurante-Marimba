<!-- Primera mitad - Template del menu -->
<!-- Nos va a devolver la URL donde se va alojar el sitio -->
<?php
session_start(); //Viene del login, para la seguridad
// print_r($_SESSION);
$urlBase= "http://localhost/Restaurante/admin/";
//(Ultimo) VALIDAMOS LAS SESIONES, viene del login (si no se ha logueado no te deja ver nada asi copies la url)
if(!isset($_SESSION["usuario"])){
    header("Location:" . $urlBase . "login.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Administrador del sitio</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- (ultimo) - integrar uteleria de filtro con jquery (Para data-table) y lo usamos en FOOTER-->
     <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
     <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>


</head>

<body>
    <header>
        <nav class="navbar navbar-expand navbar-light bg-light">
            <div class="nav navbar-nav">
                <a class="nav-item nav-link active" href="<?php echo $urlBase; ?>index.php" aria-current="page">Administrador <span class="visually-hidden">(current)</span></a>
                <a class="nav-item nav-link" href="<?php echo $urlBase; ?>seccion/banners/">Banners</a>
                <a class="nav-item nav-link" href="<?php echo $urlBase; ?>seccion/colaboradores/">Colaboradores</a>
                <a class="nav-item nav-link" href="<?php echo $urlBase; ?>seccion/testimonios/">Testimonios</a>
                <a class="nav-item nav-link" href="<?php echo $urlBase; ?>seccion/menu/">Menu</a>
                <a class="nav-item nav-link" href="<?php echo $urlBase; ?>seccion/comentarios/">Comentarios</a>
                <a class="nav-item nav-link" href="<?php echo $urlBase; ?>seccion/usuarios/">Usuarios</a>
                <a class="nav-item nav-link" href="<?php echo $urlBase; ?>cerrar.php">Cerrar sesion</a>
            </div>
        </nav>
    </header>
    <main>
    <section class="container">