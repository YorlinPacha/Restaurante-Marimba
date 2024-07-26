<!-- Para entrar a administrar todas las secciones que existen -->

<?php include_once 'templates/header.php'; ?>
<br>
<div class="row align-items-md-stretch">
    <div class="col-md-12">
        <div class="h-100 p-5 border rounded-3">
            <h2>Bienvenid@ al administrador: <?php echo $_SESSION["usuario"]  ?></h2>
            <p>
                Este espacio es para administrar tu sitio web
            </p>
            <button class="btn btn-outline-primary" type="button">
                Iniciar ahora
            </button>
        </div>
    </div>
</div>
<br>

<?php include_once 'templates/footer.php'; ?>