<?php

use App\Propiedad;

require '../../includes/app.php';
estaAutenticado();

    // Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: ../index.php');
    }

    // Obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);    // :: llama al metodo 
    


    //Consultar para obtener los vendedores 
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db,  $consulta);

    //Arreglo con mensajes de errores
    $errores =  Propiedad::getErrores();


    //Ejecutar el codigo despues  de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // Asignar los atributos
        $args = $_POST['propiedad'];

        $propiedad->sincronizar($args);

        $errores = $propiedad->validar();

        //Revisar que el array de errores este vacio
        if(empty($errores)){
            //Crear carpeta
            $carpetaImagenes = '../../imagenes/';
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }
            $nombreImagen = '';

            // SUBIDA DE ARCHIVOS
            if($imagen['name']){
                //eliminar la imagen previa
                unlink($carpetaImagenes . $propiedad['imagen']);

                //Generar un nombre único
                $nombreImagen = md5( uniqid( rand(), true )) . ".jpg";

                //Subir la imagen
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen); 
            } else {
                $nombreImagen = $propiedad['imagen'];
            }


            // INSERTAR EN LA BASE DE DATOS
            $query = " UPDATE propiedades SET titulo = '{$titulo}', precio = '{$precio}', imagen = '{$nombreImagen}', descripcion = '{$descripcion}', habitaciones = {$habitaciones}, wc = {$wc}, estacionamiento = {$estacionamiento}, vendedores_id = {$vendedores_id} WHERE id = {$id} ";     

            //echo $query;

            $resultado = mysqli_query($db, $query);

        if ($resultado){
            //Redireccionar al Usuario
            header('Location: ../index.php?resultado=2');
            }
        }

    }

        


    
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>

        <a href="/bienesraices/admin/index.php" class="boton boton-verde">volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        
        <?php endforeach; ?>


        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php include '../../includes/templates/formularios_propiedades.php'; ?>
            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>

    <?php 
    incluirTemplate('footer');
    ?>