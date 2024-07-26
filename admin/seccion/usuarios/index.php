<?php
include_once("../../bd.php");

//2) Proceso de borrado
if(isset($_GET["txtID"])){
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";

    $sentencia = $conexion->prepare("DELETE FROM tbl_usuarios WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    // Redireccion - importante para nocontinar con el parametro en la URL
    header("Location: index.php");
}

//1) ---Consultar datos para mostrar al inicio
$sentencia = $conexion->prepare("SELECT * FROM `tbl_usuarios`");
$sentencia->execute();
$listaUsuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include_once("../../templates/header.php");
?>
<br />

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar usuario</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Password</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaUsuarios as $listaUsuario) { ?>
                        <tr class="">
                            <td><?php echo $listaUsuario["id"] ?></td>
                            <td><?php echo $listaUsuario["usuario"] ?></td>
                            <td>******</td>
                            <td><?php echo $listaUsuario["correo"] ?></td>
                            <td>
                                <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $listaUsuario['id']; ?>" role="button">Eliminar</a>
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