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
        $this->imagen = $args['imagen'] ?? 'imagen.jpg';
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
        debuguear($resultado);
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

        //if(!$this->imagen['name'] || $this->imagen['error']){                   
        //    $errores[]= "La Imagen es Obligatoria";
        //}

        // Validar por tamaño  de Imagen 
        //$medida= 1000 * 1000;

        //if($this->imagen['size'] > $medida){  
         //   $errores[] = 'La Imagen es muy pesada'; 

        //}

        return self::$errores;
    }
}