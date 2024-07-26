<?php
include_once("../../bd.php");

if($_POST){
    $titulo = (isset($_POST["titulo"])) ? $_POST["titulo"] : "";
    $descripcion = (isset($_POST["descripcion"])) ? $_POST["descripcion"] : "";
    $linkFacebook = (isset($_POST["linkFacebook"])) ? $_POST["linkFacebook"] : "";
    $linkInstagram = (isset($_POST["linkInstagram"])) ? $_POST["linkInstagram"] : "";
    $linkLinkedin = (isset($_POST["linkLinkedin"])) ? $_POST["linkLinkedin"] : "";

   //Recolecta toda la info que viene de un archivo, colo campo tipo input
   //print_r($_FILES);

   $sentencia = $conexion->prepare(
    "INSERT INTO `tbl_colaboradores` (`id`, `titulo`, `descripcion`, `linkFacebook`, `linkInstagram`, `linkLinkedin`, `foto`) 
   VALUES (NULL, :titulo, :descripcion, :linkFacebook, :linkInstagram, :linkLinkedin, :nombreFoto);");
    //-----------
    //FOTO -> nombre o valor del archivo = $_FILES["foto"]["name"]
    $foto = (isset($_FILES["foto"]["name"])) ? $_FILES["foto"]["name"] : "";
    //Renombrar el archivo, evitar que se reescriba por si se suben 2 fotos con el mismo nombre
    $fechaFoto = new DateTime();
    $nombreFoto = $fechaFoto->getTimestamp()."_".$foto;
    //Subir la foto en algun lugar - recolectar del campo foto el temporal name - adjuntamos a la carpeta
    $temporalFoto = $_FILES["foto"]["tmp_name"];

    if($temporalFoto!=""){
        //Mover la fotografia a una carpeta
        move_uploaded_file($temporalFoto, "../../../img/colaboradores/". $nombreFoto);
    }
    //-----------
    $sentencia->bindParam(":nombreFoto",$nombreFoto);
    $sentencia->bindParam(":titulo",$titulo);
    $sentencia->bindParam(":descripcion",$descripcion);
    $sentencia->bindParam(":linkFacebook",$linkFacebook);
    $sentencia->bindParam(":linkInstagram",$linkInstagram);
    $sentencia->bindParam(":linkLinkedin",$linkLinkedin);
    $sentencia->execute();
     // Redireccion
     header("Location: index.php");
}
include_once("../../templates/header.php");
?>
<br />
<div class="card">
    <div class="card-header">Colaboradores</div>
    <div class="card-body">
         <!-- porque vamos a enviar una foto - encriptar - adjuntar foto (enctype) -->
         <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label>
                <input type="file" class="form-control" name="foto" id="foto" placeholder="Seleccione la foto" aria-describedby="fileHelpId" />
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Titulo" />
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion:</label>
                <input type="text" class="form-control" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Descripcion" />
            </div>
            <div class="mb-3">
                <label for="linkFacebook" class="form-label">Facebook:</label>
                <input type="text" class="form-control" name="linkFacebook" id="linkFacebook" aria-describedby="helpId" placeholder="Facebook" />
            </div>
            <div class="mb-3">
                <label for="linkInstagram" class="form-label">Instagram:</label>
                <input type="text" class="form-control" name="linkInstagram" id="linkInstagram" aria-describedby="helpId" placeholder="Instagram" />
            </div>
            <div class="mb-3">
                <label for="linkLinkedin" class="form-label">Linkedin:</label>
                <input type="text" class="form-control" name="linkLinkedin" id="linkLinkedin" aria-describedby="helpId" placeholder="Linkedin" />
            </div>
            <button type="submit" class="btn btn-success">Agregar Colaborador</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted">
    </div>
</div>



<?php include_once("../../templates/footer.php"); ?>