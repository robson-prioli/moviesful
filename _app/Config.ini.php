<?php
//
define('BEARER_TOKEN', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpYXQiOjE3MjE1OTgwMDgsImV4cCI6MTcyMTYwMTYwOH0=.P1CPgPYAwvwBmHbL65onksr6F8-XhoywVioIo8hQMEE=');


##############################################################
########################### MYSQL ############################
##############################################################
// your settings from databases
define('DB_HOST', 'localhost');
define('DB_DATABASE', 'moviesful');
define('DB_USERNAME', 'root');
define('DB_USERPASS', '');

##############################################################
########################## FUNCTION ##########################
##############################################################
// autoload
spl_autoload_register(function ($class) {
    $directories = ['Conn', 'Controllers', 'Helpers', 'Models'];

    foreach ($directories as $directory) {
        $classFile = __DIR__ . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $class . '.class.php';

        if (file_exists($classFile)) {
            require_once($classFile);
        }
    }

    //die("Não foi possivel incluir a {$class}.class.php");
});
