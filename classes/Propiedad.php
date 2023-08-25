<?php

namespace App;

class Propiedad{   // funciones adentro de una clase = Metodos

    // Base de Datos
    protected static $db;  // PROTECTED SE ACCEDE SOLO DENTRO DE LA CLASE
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    // Errores
    protected static $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    // Definir la conexion a la bd
    public static function setDB($database){
        self::$db = $database;    // self se utiliza solo para los metodos estaticos
    }

    public function __construct($args = [])         
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function guardar(){ // Metodo
        echo "Guardando en la base de datos";

        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        
        // INSERTAR EN LA BASE DE DATOS
        $query = " INSERT INTO propiedades ( ";
        $query .=  join(', ', array_keys($atributos));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";
        //echo $query;
        $resultado = self::$db->query($query);
        
        return $resultado;
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
        // asignar al atributo de imagen el nombre de imagen
        if($imagen){
            $this->imagen = $imagen; 
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

    //lista todas las propiedades
    public static function all(){
        $query = "SELECT * FROM propiedades"; // retorna un arreglo asosiativo
        $resultado =  self::consultarSQL($query);
        return $resultado;

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
        $objeto = new self;

        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }
}