<?php
include_once("../../bd.php");
include_once '../../templates/header.php';

//---me estan enviando un ID? Borrado de un colaborador
if(isset($_GET['txtID'])){
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '' ;

    //Proceso de borrado que busque la imagen y la boree
    $sentencia=$conexion->prepare("SELECT * FROM `tbl_colaboradores` WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    //Necesitamos el nombre de la foto = [foto] => 1721585792_team-image1.jpg
    $registroFoto = $sentencia->fetch(PDO::FETCH_LAZY);
    //print_r($registroFoto);
    if(isset($registroFoto["foto"])){
        //Si el archivo existe, me lo borras fisicamente
        if(file_exists("../../../img/colaboradores/".$registroFoto["foto"])){
            unlink("../../../img/colaboradores/".$registroFoto["foto"]);
        }
    }

    //Borrar en la base de datos
    $sentencia = $conexion->prepare("DELETE FROM tbl_colaboradores WHERE id=:id" );
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    // Redireccion
    header("Location: index.php");
}
//-----------------
//---Consultar datos para mostrar al inicio
$sentencia=$conexion->prepare("SELECT * FROM `tbl_colaboradores`");
$sentencia->execute();
$listaColaboradores=$sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<br />
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar Registros</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Redes sociales</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaColaboradores as $key => $colaborador) { ?>
                        <tr class="">
                            <td scope="row"><?php echo $colaborador["id"]?></td>
                            <td><?php echo $colaborador["titulo"]?></td>
                            <td>
                                <img src="../../../img/colaboradores/<?php echo $colaborador["foto"]?>" width="100" alt="Foto colaborador">
                            </td>
                            <td><?php echo $colaborador["descripcion"]?></td>
                            <td>
                                <?php echo $colaborador["linkFacebook"]?><br/>
                                <?php echo $colaborador["linkInstagram"]?><br/>
                                <?php echo $colaborador["linkLinkedin"]?>
                            </td>
                            <td>
                                <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $colaborador['id']; ?>" role="button">Editar</a>
                                <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $colaborador['id']; ?>" role="button">Eliminar</a>
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