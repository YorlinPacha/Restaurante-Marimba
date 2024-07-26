<?php
include_once '../../bd.php';

//2)  RECUPERAR LOS DATOS POST (Formulario)
if($_POST){
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
    $ingredientes = (isset($_POST["ingredientes"])) ? $_POST["ingredientes"] : "";
    $precio = (isset($_POST["precio"])) ? $_POST["precio"] : "";

     //3) Crear la insercion
    $sentencia = $conexion->prepare("UPDATE `tbl_menu`
    SET nombre = :nombre,
    ingredientes = :ingredientes,
    precio = :precio
    WHERE id=:id");

    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":ingredientes", $ingredientes);
    $sentencia->bindParam(":precio", $precio);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

     //PROCESO ACTUALIZAR FOTO (Quitar foto, recuperar foto, preguntar si hay foto y update)
    // 3) Recepcionar la foto
    //FOTO -> nombre o valor del archivo = $_FILES["foto"]["name"]
    $foto = (isset($_FILES["foto"]["name"])) ? $_FILES["foto"]["name"] : "";
    //Subir la foto en algun lugar - recolectar del campo foto el temporal name - adjuntamos a la carpeta
    $temporalFoto = $_FILES["foto"]["tmp_name"];

    //Pregunta si hay foto
    if($foto!=""){
        //Renombrar el archivo, evitar que se reescriba por si se suben 2 fotos con el mismo nombre
        $fechaFoto = new DateTime();
        $nombreFotoNueva = $fechaFoto->getTimestamp()."_".$foto;
        //Mover la fotografia a una carpeta
        move_uploaded_file($temporalFoto, "../../../img/menu/". $nombreFotoNueva);
        // 4)  Seleccionar la foto antigua
        //Buscar la foto para despues borrarla
        $sentencia=$conexion->prepare("SELECT * FROM `tbl_menu` WHERE id=:id");
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
        //Necesitamos el nombre de la foto = [foto] => 1721585792_team-image1.jpg
        $registroFoto = $sentencia->fetch(PDO::FETCH_LAZY);

        // 5) Proceso de borrado
        if(isset($registroFoto["foto"])){
            //Si el archivo existe, me lo borras fisicamente
            if(file_exists("../../../img/menu/".$registroFoto["foto"])){
                unlink("../../../img/menu/".$registroFoto["foto"]);
            }
        }

        // 6) Actualizacion NUEVAMENTE para la foto
        //Vamos a actualizar la informacion
        $sentencia = $conexion->prepare("UPDATE `tbl_menu`
        SET foto=:foto
        WHERE id=:id");

        $sentencia->bindParam(":foto",$nombreFotoNueva);
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
    }
    // Redireccion
    header("Location: index.php");
}


//1 RECUPERAR LOS DATOS
// Get po recibir por url (CONSULTAR LOS DATOS)
if(isset($_GET['txtID'])){
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '' ;
    //Devuelve los registros ligados al ID
    $sentencia=$conexion->prepare("SELECT * FROM `tbl_menu` WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    //Recuperar datos que se mostraran en el formulario
    $nombre = $registro["nombre"];
    $ingredientes = $registro["ingredientes"];
    $foto = $registro["foto"];
    $precio = $registro["precio"];

}

include_once '../../templates/header.php';
?>
<br>

<div class="card">
    <div class="card-header">Menu de Comida</div>
    <div class="card-body">
        <!-- Muy importante cuando hay una imagen o archivo = enctype="multipart/form-data" -->
        <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
                <label for="titulo" class="form-label">Id</label>
                <input type="text" value="<?php echo $txtID ?>" class="form-control" name="txtID" id="txtID" aria-describedby="helpId" placeholder="Id" />
            </div>
             <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del plato:</label>
                <input type="text" value="<?php echo $nombre ?>" class="form-control" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre" />
            </div>
            <div class="mb-3">
                <label for="ingredientes" class="form-label">Ingredientes ( Separados por "," ):</label>
                <input type="text" value="<?php echo $ingredientes ?>" class="form-control" name="ingredientes" id="ingredientes" aria-describedby="helpId" placeholder="Ingredientes" />
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label><br/>
                <img src="../../../img/menu/<?php echo $foto ?>" width="200" alt="Foto colaborador">
                <input type="file" class="form-control" name="foto" id="foto" placeholder="Seleccione la foto" aria-describedby="fileHelpId" />
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio (Sin simbolos):</label>
                <input type="text" value="<?php echo $precio ?>" class="form-control" name="precio" id="precio" aria-describedby="helpId" placeholder="Precio" />
            </div>
            <button type="submit" class="btn btn-success">Actualizar Menu</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>




<?php include_once '../../templates/footer.php'; ?>