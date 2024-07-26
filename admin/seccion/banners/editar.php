<!-- mostrar interfaz que conecte la base de datos -->
<?php
include_once '../../bd.php';
// Buscaremos los datos de un registro en especifico
// como es por la URL es GET
if(isset($_GET['txtID'])){
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '' ;
    $sentencia=$conexion->prepare("SELECT * FROM `tbl_banners` WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $titulo = $registro["titulo"];
    $descripcion = $registro["descripcion"];
    $link = $registro["link"];
}
// Recibiremos lod datos post del formulario para recolectar los datos
if($_POST){
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : '' ;
    $titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : '' ;
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
    $link = (isset($_POST['link'])) ? $_POST['link'] : '';

    //Vamos a actualizar la informacion
    $sentencia = $conexion->prepare("UPDATE `tbl_banners`
    SET titulo=:titulo, descripcion= :descripcion, link=:link
    WHERE id=:id");

    $sentencia->bindParam(":id",$txtID);
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
    <div class="card-header">Edita el Banner</div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="titulo" class="form-label">Id</label>
                <input type="text" class="form-control" value="<?php echo $txtID ?>" name="txtID" id="txtID" aria-describedby="helpId" placeholder="Id" />
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" value="<?php echo $titulo ?>" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Escriba su titulo del banner" />
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion</label>
                <input type="text" class="form-control" value="<?php echo $descripcion ?>" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Escriba la descripcion del banner" />
            </div>
            <div class="mb-3">
                <label for="link" class="form-label">Enlace</label>
                <input type="text" class="form-control" value="<?php echo $link ?>" name="link" id="link" aria-describedby="helpId" placeholder="Escriba el enlace del banner" />
            </div>
            <button type="submit" class="btn btn-success">Editar Banner</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted">

    </div>
</div>

<br>
<?php include_once '../../templates/footer.php'; ?>