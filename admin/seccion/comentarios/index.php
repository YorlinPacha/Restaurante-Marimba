<?php
include_once("../../bd.php");

//2) como es por la URL es GET (Para eliminar)
if(isset($_GET['txtID'])){
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '' ;

    $sentencia = $conexion->prepare("DELETE FROM tbl_comentarios WHERE id=:id" );
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    // Redireccion
    header("Location: index.php");
}

//1) Consultar Comentarios
$sentencia = $conexion->prepare("SELECT * FROM tbl_comentarios ORDER BY id ");
$sentencia->execute();
$listaComentarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
// print_r($listaComentarios);

include_once("../../templates/header.php");
?>
<br />

<div class="card">
    <div class="card-header">Bandeja de comentarios</div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Mensaje</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($listaComentarios as $listaComentario){ ?>
                        <tr class="">
                            <td><?php echo $listaComentario["id"]?></td>
                            <td><?php echo $listaComentario["nombre"]?></td>
                            <td><?php echo $listaComentario["correo"]?></td>
                            <td><?php echo $listaComentario["mensaje"]?></td>
                            <td>
                                <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $listaComentario['id']; ?>" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>

    </div>
    <div class="card-footer text-muted"></div>
</div>


<?php include_once("../../templates/footer.php"); ?>