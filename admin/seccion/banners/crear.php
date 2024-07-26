<!-- Creacion de los registros de la base de datos -->
<?php
include_once '../../bd.php';
if($_POST){
    print_r($_POST);
    $titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : '' ;
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
    $link = (isset($_POST['link'])) ? $_POST['link'] : '';

    $sentencia = $conexion->prepare("INSERT INTO `tbl_banners` (`id`, `titulo`, `descripcion`, `link`)
    VALUES (NULL, :titulo, :descripcion, :link);" );
    $sentencia->bindParam(":titulo",$titulo);
    $sentencia->bindParam(":descripcion",$descripcion);
    $sentencia->bindParam(":link",$link);
    $sentencia->execute();
    // Redireccion
    header("Location: index.php");
}

include_once '../../templates/header.php';
?>
<br>
<div class="card">
    <div class="card-header">Banners</div>
        <div class="card-body">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Titulo</label>
                    <input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Escriba su titulo del banner" />
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Escriba la descripcion del banner" />
                </div>
                <div class="mb-3">
                    <label for="link" class="form-label">Enlace</label>
                    <input type="text" class="form-control" name="link" id="link" aria-describedby="helpId" placeholder="Escriba el enlace del banner" />
                </div>
                <button type="submit" class="btn btn-success">Crear Banner</button>
                <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
            </form>
        </div>
    <div class="card-footer text-muted">

    </div>
</div>

<br>
<?php include_once '../../templates/footer.php'; ?>