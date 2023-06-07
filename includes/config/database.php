<?php

function conectarDB(){
    $db = mysqli_connect('localhost', 'root', '', 'bienesraices_crud');

    if($db){
        echo 'se conecto';
    }else{
        echo 'no se conecto';
    }
}
?>