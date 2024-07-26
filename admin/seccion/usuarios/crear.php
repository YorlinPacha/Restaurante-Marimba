<?php
include_once("../../bd.php");

if($_POST){
    $usuario = (isset($_POST["usuario"])) ? $_POST["usuario"] : "";
    $password = (isset($_POST["password"])) ? $_POST["password"] : "";
    //Para encriptar la contraseña de una forma sencilla
    $password = md5($password);
    $correo = (isset($_POST["correo"])) ? $_POST["correo"] : "";

    $sentencia = $conexion->prepare("INSERT INTO tbl_usuarios (id, usuario, password, correo)
    VALUES (NULL, :usuario, :password, :correo)");

    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $password);
    $sentencia->bindParam(":correo", $correo);
    $sentencia->execute();

    // Redireccion
    header("Location: index.php");
}

include_once("../../templates/header.php");
?>
<br />

<div class="card">
    <div class="card-header">Usuarios</div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre de usuario: </label>
                <input type="text" class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Ingrese el usuario" />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password: </label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Ingrese el password" />
                <input type="checkbox" id="mostraPassword">Mostrar password.
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo: </label>
                <input type="email" class="form-control" name="correo" id="correo" aria-describedby="emailHelpId" placeholder="correo@mail.com" />
            </div>
            <button type="submit" class="btn btn-success">Agregar usuario</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>


<script>
    const password = document.getElementById("password");
    const check = document.getElementById("mostraPassword");

    check.onchange = function(e){
        password.type = check.checked ? "text" : "password";
    };
</script>



<?php include_once '../../templates/footer.php'; ?>