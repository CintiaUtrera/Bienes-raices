<?php

    // Incluir la conexion 
    require __DIR__ . '/../config/database.php';
    $db = conectarDB();

    //Consultar 
    $query = "SELECT * FROM propiedades LIMIT {$limite}";

    // obtener los resultados
    $resultado = mysqli_query($db, $query);
?>



<div class="contenedor-anuncios">
    <?php while($propiedad = mysqli_fetch_assoc($resultado)): ?>
            <div class="anuncio">
                <picture>
                    <img loading="lazy" src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="anuncio">
               

                <div class="contenido-anuncio">
                    <h3>Casa con alberca</h3>
                    <p>Casa en el lago con excelente vista, acabados de lujo a un excelente precio</p>
                    <p class="precio">$3,0000,000</p>

                    <ul class="iconos-caracteristicas">
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                            <p>3</p>
                        </li>
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                            <p>3</p>
                        </li>
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                            <p>4</p>
                        </li>
                    </ul>

                    <a href="anuncio.php" class="boton-amarillo-block">
                        Ver Propiedad
                    </a>
                </div><!--.contenido-anuncio-->
            </div><!--anuncio-->
        <?php endwhile; ?>
        </div> <!--.contenedor-anuncios-->

<?php
// Cerrar la conexion

?>