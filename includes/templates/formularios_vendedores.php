<fieldset>

<legend>Información General</legend>
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="vendedor[nombre]" value="<?php echo s($vendedor->nombre); ?>" placeholder="Nombre Vendedor">

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" value="<?php echo s($vendedor->apellido); ?>" placeholder="Apellido Vendedor">


</fieldset>

<fieldset>
    <legend>Información General</legend>
    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="vendedor[telefono]" value="<?php echo s($vendedor->telefono); ?>" placeholder="Ej: (3537) 15689874">

</fieldset>