<?php 
namespace App;

class ActiveRecord{
     // funciones adentro de una clase = Metodos

    // Base de Datos
    protected static $db;  // PROTECTED SE ACCEDE SOLO DENTRO DE LA CLASE
    protected static $columnasDB = [];
    protected static $tabla = '';


    // Errores
    protected static $errores = [];


    // Definir la conexion a la bd
    public static function setDB($database){
        self::$db = $database;    // self se utiliza solo para los metodos estaticos
    }

    

    public function guardar() {                     
        if(!is_null($this->id)){
            // Actualizar
            $this->actualizar();
        } else{
            // creando un nuevo registro
            $this->crear();
        }
    }

    public function crear(){ // Metodo
        echo "Guardando en la base de datos";
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        
        // INSERTAR EN LA BASE DE DATOS
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .=  join(', ', array_keys($atributos));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";
        //echo $query;
        $resultado = self::$db->query($query);
        
        // mensaje de exito
        if ($resultado){
            //Redireccionar al Usuario
            header("Location: ../index.php?resultado=1");
            }
        
    }

    public function actualizar(){
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores); 
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";     
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);
        if ($resultado){
            $this->borrarImagen();
            //Redireccionar al Usuario
            header('Location: ../index.php?resultado=2');
            }
        
    }

    //Eliminar un registro
    public function eliminar(){
        // Eliminar el registro
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        if($resultado){
            header('location:/bienesraices/admin/index.php?resultado=3');
        }
    }

    public function atributos (){   // va a iterar la columnaDB
        $atributos = [];
        foreach(self::$columnasDB as $columna){
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value){
            $sanitizado[$key]= self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Subida de archivos 
    public function setImagen($imagen){
        // Eliminar la imagen previa
        if(!is_null($this->id)){
            $this->borrarImagen();
        }
        // asignar al atributo de imagen el nombre de imagen
        if($imagen){
            $this->imagen = $imagen; 
        }
    }
    // Elimina el archivo (imagen)
    public function  borrarImagen() {
        // comprobar si existe el archivo
        $existeArchivo= file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo){
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    public static function getErrores(){
        return self::$errores;
    }

    public function validar(){
        if(!$this->titulo){
            self::$errores[]= "Debes añadir un titulo";
        }

        if(!$this->precio){
            self::$errores[]= "El Precio es obligatorio";
        }

        if( strlen($this->descripcion) < 30 ){
            self::$errores[]= "La Descripción es obligatoria y debe tener al menos 50 caracteres";
        }

        if(!$this->habitaciones){
            self::$errores[]= "El Número de habitaciones es obligatorio";
        }

        if(!$this->wc){
            self::$errores[]= "El Número de baños es obligatorio";
        }

        if(!$this->estacionamiento){
            self::$errores[]= "El Número de lugares de Estacionamiento es obligatorio";
        }

        if(!$this->vendedores_id){
            self::$errores[]= "Elige un vendedor";
        }

        if(!$this->imagen){                   
            self::$errores[]= "La Imagen es Obligatoria";
        }

        return self::$errores;
    }

    //lista todos los registros 
    public static function all(){
        $query = "SELECT * FROM " . static::$tabla; // retorna un arreglo asosiativo
        $resultado =  self::consultarSQL($query);
        return $resultado;
    }

    // Busca una registro(propiedad) por su id
    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado);  // array_shift: retorna el primer elemento de un arreglo
        }


    public static function consultarSQL($query)  {
        // Consulta db
        $resultado = self::$db->query($query);
        // iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){  // arreglo asosiativo
            $array[] = self::crearObjeto($registro); // creando un nuevo metodo que formatea ese arreglo hacia objeto para seguir principios de ActiveRecord
        }
        // liberar la memoria
        $resultado->free();
        // retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro){
        $objeto = new static;
        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //Sincronizar el objeto en memoria con los cambios realizados por el usuario 
    public function sincronizar($args = []){
        foreach($args as $key => $value){
            if(property_exists($this, $key) && !is_null($value) ){
                $this->$key = $value;
            }
        }
    }
}
