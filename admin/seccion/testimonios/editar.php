<?php
include_once("../../bd.php");
//1) Recibir ID para editar
// como es por la URL es GET
if(isset($_GET['txtID'])){
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '' ;
    $sentencia=$conexion->prepare("SELECT * FROM `tbl_testimonios` WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $opinion = $registro["opinion"];
    $nombre = $registro["nombre"];
}

// 2) Recepcion de los datos del formulario por post
//i have some problems with the if($_post), check this POST please?
if($_POST){
    //Recolectar cada dato
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : '' ;
    $opinion = (isset($_POST["opinion"])) ? $_POST["opinion"] : "";
    $nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";

    $sentencia = $conexion->prepare("UPDATE `tbl_testimonios`
    SET opinion = :opinion, nombre = :nombre
    WHERE id = :id;");

    $sentencia->bindParam(":opinion",$opinion);
    $sentencia->bindParam(":nombre",$nombre);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    // Redireccion
    header("Location: index.php");
}

include_once("../../templates/header.php");

?>
<br />
<div class="card">
    <div class="card-header">Testimonios</div>
    <div class="card-body">
        <form action="" method="post">
        <div class="mb-3">
                <label for="txtID" class="form-label">Id:</label>
                <input type="text" class="form-control" value="<?php echo $txtID ?>" name="txtID" id="txtID" aria-describedby="helpId" placeholder="Id" />
            </div>
            <div class="mb-3">
                <label for="opinion" class="form-label">Opinion:</label>
                <input type="text" class="form-control" value="<?php echo $opinion ?>" name="opinion" id="opinion" aria-describedby="helpId" placeholder="Escribe tu opinion" />
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" value="<?php echo $nombre ?>" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Escribe tu nombre" />
            </div>
            <button type="submit" class="btn btn-success">Modificar Testimonio</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>



<?php include_once '../../templates/footer.php'; ?>