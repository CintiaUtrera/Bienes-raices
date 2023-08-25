<fieldset>
                <legend>Información General</legend>
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo s($propiedad->titulo); ?>" placeholder="Titulo Propiedad">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" value="<?php echo s($propiedad->precio); ?>" placeholder="Precio">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen"  accept="image/jpg, image/png" name="imagen">
            
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" ><?php echo s($propiedad->descripcion); ?></textarea>

            </fieldset>

            <fieldset>
                <legend>Información Propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" id="habitaciones" name="habitaciones" value="<?php echo s($propiedad->habitaciones); ?>" placeholder="Ej: 3" min="1" max="9">
            
                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc" value="<?php echo s($propiedad->wc); ?>" placeholder="Ej: 2" min="1" max="6">

                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" id="estacionamiento" name="estacionamiento" value="<?php echo s($propiedad->estacionamiento); ?>" placeholder="Ej: 1" min="1" max="5">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
            

            </fieldset>