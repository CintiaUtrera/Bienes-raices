<?php 
    require '../../includes/app.php';

    use App\Propiedad;
    
    estaAutenticado();
    

    $db = conectarDB();
    
    //Consultar para obtener los vendedores 
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db,  $consulta);

    //Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();
     

        $titulo = '';
        $precio = '';
        $descripcion = '';
        $habitaciones = '';
        $wc = '';
        $estacionamiento = '';
        $vendedores_id= '';



    //Ejecutar el codigo despues  de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $propiedad  = new Propiedad($_POST);
        $errores = $propiedad->validar();

        //Revisar que el array de errores este vacio
        if(empty($errores)){

            $propiedad->guardar();

            // Asignar files hacia una variable
            $imagen = $_FILES['imagen'];
            
            //SUBIDA DE ARCHIVOS

            //Crear carpeta
            $carpetaImagenes = '../../imagenes/';
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            //Generar un nombre único
            $nombreImagen = md5( uniqid(rand(), true)) . ".jpg";

            //Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
            
            

            

        $resultado = mysqli_query($db, $query);

        if ($resultado){
            //Redireccionar al Usuario
            header("Location: ../index.php?resultado=1");
            }
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
            <fieldset>
                <legend>Información General</legend>
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo $titulo; ?>" placeholder="Titulo Propiedad">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" value="<?php echo $precio; ?>" placeholder="Precio">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen"  accept="image/jpg, image/png" name="imagen">
            
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" ><?php echo $descripcion; ?></textarea>

            </fieldset>

            <fieldset>
                <legend>Información Propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" id="habitaciones" name="habitaciones" value="<?php echo $habitaciones; ?>" placeholder="Ej: 3" min="1" max="9">
            
                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc" value="<?php echo $wc; ?>" placeholder="Ej: 2" min="1" max="6">

                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" id="estacionamiento" name="estacionamiento" value="<?php echo $estacionamiento; ?>" placeholder="Ej: 1" min="1" max="5">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
            <select name="vendedorId">
                <option value="">-- Seleccione --</option>
                <?php while($vendedor= mysqli_fetch_assoc($resultado) ):  ?>
                    <option <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : '';  ?>    value="<?php echo $vendedor['id']; ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                <?php endwhile; ?>
                
            </select>

            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

    <?php 
    incluirTemplate('footer');
    ?>