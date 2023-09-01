<?php 
    require '../../includes/app.php';

    use App\Vendedor;

    estaAutenticado();

$vendedor = new Vendedor;

    //Arreglo con mensajes de errores
    $errores = Vendedor::getErrores();

    //Ejecutar el codigo despues  de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    }

    incluirTemplate('header');
?>

<main class="contenedor seccion">
        <h1>Actualizar Vendedor</h1>

        <a href="/bienesraices/admin/index.php" class="boton boton-verde">volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        
        <?php endforeach; ?>


        <form class="formulario" method="POST" action="/admin/vendedores/actualizar.php">
            <?php include '../../includes/templates/formularios_vendedores.php'; ?>

            <input type="submit" value="Guardar Cambios" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>