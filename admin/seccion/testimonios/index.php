<?php
include_once("../../bd.php");
include_once("../../templates/header.php");

//Proceso de borrado
if(isset($_GET["txtID"])){
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";

    $sentencia = $conexion->prepare("DELETE FROM tbl_testimonios WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    // Redireccion - importante para nocontinar con el parametro en la URL
    header("Location: index.php");
}


//---Consultar datos para mostrar al inicio
$sentencia=$conexion->prepare("SELECT * FROM `tbl_testimonios`");
$sentencia->execute();
$listaTestimonios=$sentencia->fetchAll(PDO::FETCH_ASSOC);

?>
<br />
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar Testimonio</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Opinion</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaTestimonios as $key => $testimonio) { ?>
                        <tr class="">
                            <td scope="row"><?php echo $testimonio["id"]?></td>
                            <td><?php echo $testimonio["opinion"]?></td>
                            <td><?php echo $testimonio["nombre"]?></td>
                            <td>
                                <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $testimonio['id']; ?>" role="button">Editar</a>
                                <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $testimonio['id']; ?>" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
    <div class="card-footer text-muted"></div>
</div>




<?php include_once '../../templates/footer.php'; ?>