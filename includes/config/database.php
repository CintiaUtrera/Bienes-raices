<?php

function conectarDB(){
    $db = mysqli_connect('localhost', 'root', 'root', 'bienes_raices');

    if($db){
        echo 'se conecto';
    }else{
        echo 'no se conecto';
    }
}
?>