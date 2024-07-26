<?php
include_once("../../bd.php");
include_once '../../templates/header.php';

//2)  RECUPERAR LOS DATOS POST
//Recepcionar los datos del POST (Formulario)
if($_POST){
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : '' ;
    $titulo = (isset($_POST["titulo"])) ? $_POST["titulo"] : "";
    $descripcion = (isset($_POST["descripcion"])) ? $_POST["descripcion"] : "";
    $linkFacebook = (isset($_POST["linkFacebook"])) ? $_POST["linkFacebook"] : "";
    $linkInstagram = (isset($_POST["linkInstagram"])) ? $_POST["linkInstagram"] : "";
    $linkLinkedin = (isset($_POST["linkLinkedin"])) ? $_POST["linkLinkedin"] : "";

    //Vamos a actualizar la informacion
    $sentencia = $conexion->prepare("UPDATE `tbl_colaboradores`
    SET titulo=:titulo,
    descripcion= :descripcion,
    linkFacebook=:linkFacebook,
    linkInstagram=:linkInstagram,
    linkLinkedin=:linkLinkedin
    WHERE id=:id");

    $sentencia->bindParam(":id",$txtID);
    $sentencia->bindParam(":titulo",$titulo);
    $sentencia->bindParam(":descripcion",$descripcion);
    $sentencia->bindParam(":linkFacebook",$linkFacebook);
    $sentencia->bindParam(":linkInstagram",$linkInstagram);
    $sentencia->bindParam(":linkLinkedin",$linkLinkedin);
    $sentencia->execute();


    //PROCESO ACTUALIZAR FOTO (Quitar foto, recuperar foto, preguntar si hay foto y update)
    // 2.1) Recepcionar la foto
    //FOTO -> nombre o valor del archivo = $_FILES["foto"]["name"]
    $foto = (isset($_FILES["foto"]["name"])) ? $_FILES["foto"]["name"] : "";
    //Subir la foto en algun lugar - recolectar del campo foto el temporal name - adjuntamos a la carpeta
    $temporalFoto = $_FILES["foto"]["tmp_name"];
    if($foto!=""){
        //Renombrar el archivo, evitar que se reescriba por si se suben 2 fotos con el mismo nombre
        $fechaFoto = new DateTime();
        $nombreFotoNueva = $fechaFoto->getTimestamp()."_".$foto;
        //Mover la fotografia a una carpeta
        move_uploaded_file($temporalFoto, "../../../img/colaboradores/". $nombreFotoNueva);
        // 2.2)  Seleccionar la foto antigua
        //Proceso de borrado que busque la imagen y la boree
        $sentencia=$conexion->prepare("SELECT * FROM `tbl_colaboradores` WHERE id=:id");
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
        //Necesitamos el nombre de la foto = [foto] => 1721585792_team-image1.jpg
        $registroFoto = $sentencia->fetch(PDO::FETCH_LAZY);
        // 2.3) Proceso de borrado
        if(isset($registroFoto["foto"])){
            //Si el archivo existe, me lo borras fisicamente
            if(file_exists("../../../img/colaboradores/".$registroFoto["foto"])){
                unlink("../../../img/colaboradores/".$registroFoto["foto"]);
            }
        }

        // 3) Actualizacion NUEVAMENTE para la foto
        //Vamos a actualizar la informacion
        $sentencia = $conexion->prepare("UPDATE `tbl_colaboradores`
        SET foto=:foto
        WHERE id=:id");

        $sentencia->bindParam(":foto",$nombreFotoNueva);
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
        }

     // Redireccion
     header("Location: index.php");
}
//----------

//1)  RECUPERAR LOS DATOS
// Get po recibir por url (CONSULTAR LOS DATOS)
if(isset($_GET['txtID'])){
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '' ;

    $sentencia=$conexion->prepare("SELECT * FROM `tbl_colaboradores` WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    //Recuperar datos que se mostraran en el formulario
    $titulo = $registro["titulo"];
    $descripcion = $registro["descripcion"];
    $foto = $registro["foto"];
    $linkFacebook = $registro["linkFacebook"];
    $linkInstagram = $registro["linkInstagram"];
    $linkLinkedin = $registro["linkLinkedin"];

}

?>
<br />
<div class="card">
    <div class="card-header">Colaboradores</div>
    <div class="card-body">
         <!-- porque vamos a enviar una foto - encriptar - adjuntar foto (enctype) -->
        <!-- POST -> Recolectamos y enviamos -->
        <!-- action es vacio -> se va a la misma pagina -->
         <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Id</label>
                <input type="text" class="form-control" value="<?php echo $txtID ?>" name="txtID" id="txtID" aria-describedby="helpId" placeholder="Id" />
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label><br/>
                <img src="../../../img/colaboradores/<?php echo $foto ?>" width="200" alt="Foto colaborador">
                <input type="file" class="form-control" name="foto" id="foto" placeholder="Seleccione la foto" aria-describedby="fileHelpId" />
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo:</label>
                <input type="text" class="form-control" value="<?php echo $titulo ?>" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Titulo" />
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion:</label>
                <input type="text" class="form-control" value="<?php echo $descripcion ?>" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Descripcion" />
            </div>
            <div class="mb-3">
                <label for="linkFacebook" class="form-label">Facebook:</label>
                <input type="text" class="form-control" value="<?php echo $linkFacebook ?>" name="linkFacebook" id="linkFacebook" aria-describedby="helpId" placeholder="Facebook" />
            </div>
            <div class="mb-3">
                <label for="linkInstagram" class="form-label">Instagram:</label>
                <input type="text" class="form-control" value="<?php echo $linkInstagram ?>" name="linkInstagram" id="linkInstagram" aria-describedby="helpId" placeholder="Instagram" />
            </div>
            <div class="mb-3">
                <label for="linkLinkedin" class="form-label">Linkedin:</label>
                <input type="text" class="form-control" value="<?php echo $linkLinkedin ?>" name="linkLinkedin" id="linkLinkedin" aria-describedby="helpId" placeholder="Linkedin" />
            </div>
            <button type="submit" class="btn btn-success">Modificar Colaborador</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted">
    </div>
</div>


<?php include_once '../../templates/footer.php'; ?>