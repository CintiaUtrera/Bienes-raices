<?php 
    require '../../includes/app.php';

    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;
    
    estaAutenticado();
    
    $propiedad = new Propiedad;
    
    // consulta para obtener todos los vendedores
    $vendedores = Vendedor::all();

    //Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();


    //Ejecutar el codigo despues  de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        //Crea una nueva instancia 
        $propiedad  = new Propiedad($_POST['propiedad']);

        //SUBIDA DE ARCHIVOS
        
        //Generar un nombre único
        $nombreImagen = md5( uniqid( rand(), true) ) . ".jpg";

        // SETEAR la imagen
        // Realiza un resize a la imagen con intervention 
        if($_FILES['propiedad']['tmp_name']['imagen']){
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }
        

        //Validar
        $errores = $propiedad->validar();

        if(empty($errores)){
            //Crear carpeta
            $carpetaImagenes = '../../imagenes/';
                if(!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES);
                }
            // guarda la imagen en el servidor 
            $image->save(CARPETA_IMAGENES . $nombreImagen);
            // Guarda en la base de datos 
            $propiedad->guardar();

            }

    }

        



    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/bienesraices/admin/index.php" class="boton boton-verde">volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        
        <?php endforeach; ?>


        <form class="formulario" method="POST" action="crear.php" enctype="multipart/form-data">
            <?php include '../../includes/templates/formularios_propiedades.php'; ?>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

    <?php 
    incluirTemplate('footer');
    ?>