<?php
##############################################################
############################# API ############################
##############################################################
// settings api
define('JWT_TOKEN', 123);
define('BEARER_TOKEN', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3MjE2MDYwMDUsImV4cCI6MTcyMTYwOTYwNSwic3ViIjoxMjM0NSwibmFtZSI6IkpvaG4gRG9lIiwicm9sZSI6ImFkbWluIn0.9DMayrFyo2y8RAqfO357vk_9NhKV6BFyRqnNEUW-bMY');

define('API_SORT_DEFAULT', 'asc');
define('API_PAGE_DEFAULT', 1);
define('API_LIMIT_DEFAULT', 10);

##############################################################
########################### MYSQL ############################
##############################################################
// settings database
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

    foreach ($directories as $directory):
        $classFile = __DIR__ . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $class . '.class.php';

        if (file_exists($classFile)):
            require_once($classFile);
        endif;
    endforeach;
});
