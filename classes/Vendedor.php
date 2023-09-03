<?php

namespace App;

class Vendedor extends ActiveRecord {   // Heredando de la clase activerecord
    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];
    
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])         
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar(){
        if(!$this->nombre){
            self::$errores[] = "El Nombres es Obligatorio";
        }
        if(!$this->apellido){
            self::$errores[] = "El Apellido es Obligatorio";
        }
        if(!$this->telefono){
            self::$errores[] = "El Teléfono es Obligatorio";
        }
        return self::$errores;
    }
}