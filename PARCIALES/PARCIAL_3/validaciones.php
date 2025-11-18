<?php

    function validaLogintudUsuario($username) {
        return strlen($username) >= 3;
    } 
    function validaLogintudPassword($password) {
        return strlen($password) >= 5;
    }
    
?>