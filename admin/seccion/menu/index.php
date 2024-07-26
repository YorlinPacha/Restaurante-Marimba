<?php
include_once '../../bd.php';

//2) Recepcion del GET
//---me estan enviando un ID POR url? Borrado de un mENU
if(isset($_GET['txtID'])){
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '' ;

    //2.1 Recuperamos el ID = Proceso de borrado que busque la imagen y la borra
    $sentencia=$conexion->prepare("SELECT * FROM `tbl_menu` WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    //2.2 Buscamos el registro = [foto] => 1721585792_team-image1.jpg
    $registroFoto = $sentencia->fetch(PDO::FETCH_LAZY);
    //print_r($registroFoto);
    if(isset($registroFoto["foto"])){
        //Si el archivo existe, me lo borras fisicamente
        if(file_exists("../../../img/menu/".$registroFoto["foto"])){
            unlink("../../../img/menu/".$registroFoto["foto"]);
        }
    }

    //3) Borrar  tambien en la base de datos
    $sentencia = $conexion->prepare("DELETE FROM tbl_menu WHERE id=:id" );
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    // Redireccion
    header("Location: index.php");
}

//1)---Consultar datos para mostrar al inicio
$sentencia=$conexion->prepare("SELECT * FROM `tbl_menu`");
$sentencia->execute();
$listaMenus=$sentencia->fetchAll(PDO::FETCH_ASSOC);

include_once '../../templates/header.php';
?>
<br>

<div class="card">
    <div class="card-header">
    <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar Registros</a>
    </div>
    <div class="card-body">
        <div
            class="table-responsive-sm"
        >
            <table
                class="table"
            >
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre del plato</th>
                        <th scope="col">Ingredientes</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaMenus as $key => $listaMenu) { ?>
                        <tr class="">
                            <td scope="row"><?php echo $listaMenu["id"]?></td>
                            <td><?php echo $listaMenu["nombre"]?></td>
                            <td><?php echo $listaMenu["ingredientes"]?></td>
                            <td>
                                <img src="../../../img/menu/<?php echo $listaMenu["foto"] ?>" alt="Foto Menu" width="150">
                            </td>
                            <td>$<?php echo $listaMenu["precio"]?></td>
                            <td>
                                <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $listaMenu['id']; ?>" role="button">Editar</a>
                                <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $listaMenu['id']; ?>" role="button">Eliminar</a>
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