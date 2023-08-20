<?php

namespace App;

class Propiedad{   // funciones adentro de una clase = Metodos

    // Base de Datos
    protected static $db;  // PROTECTED SE ACCEDE SOLO DENTRO DE LA CLASE
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];


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
        $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id) 
        VALUES ('$this->titulo', '$this->precio', '$this->imagen', '$this->descripcion', '$this->habitaciones', '$this->wc', '$this->estacionamiento', '$this->creado', '$this->vendedores_id')";
        //echo $query;
        $resultado = self::$db->query($query);
        debuguear($resultado);
    }

    public function atributos (){   // va a iterar la columnaDB
        $atributos = [];
        foreach(self::$columnasDB as $columna){
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos(){

    }
}