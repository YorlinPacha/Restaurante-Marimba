<?php
include_once '../../bd.php';

//1) Capturamos los datos SI HAY UN ENVIO del formulario
if($_POST){

    $nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
    $ingredientes = (isset($_POST["ingredientes"])) ? $_POST["ingredientes"] : "";
    $precio = (isset($_POST["precio"])) ? $_POST["precio"] : "";

    //2) Crear la insercion
    $sentencia = $conexion->prepare("INSERT INTO `tbl_menu` (`id`, `nombre`, `ingredientes`, `foto`, `precio`)
    VALUES (NULL, :nombre, :ingredientes, :foto, :precio);");

    //3) Recolectar del adjunto la FOTO y la moveremos
    $foto = (isset($_FILES["foto"]["name"])) ? $_FILES["foto"]["name"] : "";
    //Renombrar el archivo, evitar que se reescriba por si se suben 2 fotos con el mismo nombre
    $fechaFoto = new DateTime();
    $nombreFoto = $fechaFoto->getTimestamp()."_".$foto;
    //Subir la foto en algun lugar - recolectar del campo foto el temporal name - adjuntamos a la carpeta
    $temporalFoto = $_FILES["foto"]["tmp_name"];

    if($temporalFoto!=""){
        //Mover la fotografia a una carpeta
        move_uploaded_file($temporalFoto, "../../../img/menu/". $nombreFoto);
    }

    //4) Poner datos y ejecutar sentencia
    $sentencia->bindParam(":foto",$nombreFoto);
    $sentencia->bindParam(":nombre",$nombre);
    $sentencia->bindParam(":ingredientes",$ingredientes);
    $sentencia->bindParam(":precio",$precio);

    $sentencia->execute();

     // Redireccion
     header("Location: index.php");
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
                <label for="nombre" class="form-label">Nombre del plato:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre" />
            </div>
            <div class="mb-3">
                <label for="ingredientes" class="form-label">Ingredientes ( Separados por "," ):</label>
                <input type="text" class="form-control" name="ingredientes" id="ingredientes" aria-describedby="helpId" placeholder="Ingredientes" />
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label>
                <input type="file" class="form-control" name="foto" id="foto" placeholder="Seleccione la foto" aria-describedby="fileHelpId" />
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio (Sin simbolos):</label>
                <input type="text" class="form-control" name="precio" id="precio" aria-describedby="helpId" placeholder="Precio" />
            </div>
            <button type="submit" class="btn btn-success">Agregar Menu</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>



<?php include_once '../../templates/footer.php'; ?>