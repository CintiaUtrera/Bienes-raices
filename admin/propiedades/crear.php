<?php 
    require '../../includes/funciones.php';
    $auth = estaAutenticado();
    
    
    if(!$auth){
        header('Location: /');
    }


        // Base de datos
    require '../../includes/config/database.php';
    $db = conectarDB();
    
    //Consultar para obtener los vendedores 
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db,  $consulta);

    //Arreglo con mensajes de errores
    $errores =  [];

        $titulo = '';
        $precio = '';
        $descripcion = '';
        $habitaciones = '';
        $wc = '';
        $estacionamiento = '';
        $vendedores_id= '';



    //Ejecutar el codigo despues  de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        //echo "<pre>";
        //var_dump($_POST);
        //echo "</pre>";

        //echo "<pre>";
        //var_dump($_FILES);
        //echo "</pre>";

        

        $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
        $precio = mysqli_real_escape_string($db, $_POST['precio']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
        $wc = mysqli_real_escape_string($db, $_POST['wc']);
        $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
        $vendedores_id= mysqli_real_escape_string($db, $_POST['vendedor']);
        $creado= date('Y/m/d');

        // Asignar files hacia una variable
        $imagen = $_FILES['imagen'];
        

        if(!$titulo){
            $errores[]= "Debes añadir un titulo";
        }

        if(!$precio){
            $errores[]= "El Precio es obligatorio";
        }

        if( strlen($descripcion) < 30 ){
            $errores[]= "La Descripción es obligatoria y debe tener al menos 50 caracteres";
        }

        if(!$habitaciones){
            $errores[]= "El Número de habitaciones es obligatorio";
        }

        if(!$wc){
            $errores[]= "El Número de baños es obligatorio";
        }

        if(!$estacionamiento){
            $errores[]= "El Número de lugares de Estacionamiento es obligatorio";
        }

        if(!$vendedores_id){
            $errores[]= "Elige un vendedor";
        }

        if(!$imagen['name'] || $imagen['error']){                   
            $errores[]= "La Imagen es Obligatoria";
        }

        // Validar por tamaño  de Imagen 
        $medida= 1000 * 1000;

        if($imagen['size'] > $medida){  
            $errores[] = 'La Imagen es muy pesada'; 

        }

        //Revisar que el array de errores este vacio
        if(empty($errores)){

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
            
            

            // INSERTAR EN LA BASE DE DATOS
        $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id) 
        VALUES ('$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedores_id')";
        //echo $query;

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
            <select name="vendedor">
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