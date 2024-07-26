<!-- mostrar la lista de los registros de la base de datos -->
<?php
include_once '../../bd.php';
// como es por la URL es GET
if(isset($_GET['txtID'])){
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '' ;

    $sentencia = $conexion->prepare("DELETE FROM tbl_banners WHERE id=:id" );
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    // Redireccion
    header("Location: index.php");
}

//---Consultar datos para mostrar al inicio
$sentencia=$conexion->prepare("SELECT * FROM `tbl_banners`");
$sentencia->execute();
$listaBanners=$sentencia->fetchAll(PDO::FETCH_ASSOC);
include_once '../../templates/header.php';
?>
<br>
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">agregar Registros</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Enlace</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaBanners as $key => $banner) { ?>
                        <tr class="">
                            <td scope="row"><?php echo $banner['id']; ?></td>
                            <td><?php echo $banner['titulo']; ?></td>
                            <td><?php echo $banner['descripcion']; ?></td>
                            <td><?php echo $banner['link']; ?></td>
                            <td>
                                <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $banner['id']; ?>" role="button">Editar</a>
                                <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $banner['id']; ?>" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted"></div>
</div>
<br>
<?php include_once '../../templates/footer.php'; ?>