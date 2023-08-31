<fieldset>
                <legend>Información General</legend>
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="propiedad[titulo]" value="<?php echo s($propiedad->titulo); ?>" placeholder="Titulo Propiedad">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="propiedad[precio]" value="<?php echo s($propiedad->precio); ?>" placeholder="Precio">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen"  accept="image/jpg, image/png" name="propiedad[imagen]">
                <?php if($propiedad->imagen) { ?>
                    <img src="/imagenes/<?php echo $propiedad->imagen ?>" class="imagen-small">
                <?php }; ?>
            
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="propiedad[descripcion]" ><?php echo s($propiedad->descripcion); ?></textarea>

            </fieldset>

            <fieldset>
                <legend>Información Propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" id="habitaciones" name="propiedad[habitaciones]" value="<?php echo s($propiedad->habitaciones); ?>" placeholder="Ej: 3" min="1" max="9">
            
                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="propiedad[wc]" value="<?php echo s($propiedad->wc); ?>" placeholder="Ej: 2" min="1" max="6">

                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" value="<?php echo s($propiedad->estacionamiento); ?>" placeholder="Ej: 1" min="1" max="5">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
                <label for="vendedor">Vendedor</label>
                <select name="propiedad[vendedores_id]" id="vendedor">
                    <option selected value="">-- Seleccione --</option>
                    <?php foreach($vendedores as $vendedor) { ?>
                        <option <?php echo $propiedad->vendedores_id === $vendedor->id ? 'selected' : ''; ?>
                            value="<?php echo s($vendedor->id); ?>">
                                <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?>
                        </option>
                    <?php } ?>
                </select>
            

            </fieldset>