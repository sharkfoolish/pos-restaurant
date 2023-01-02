<?php

spl_autoload_register(function ($_path) {

    $_path = str_replace('\\', '/', $_path);
    $path = ltrim($_path, '/');
    $namespace = '';

    if ($lastBackslash = strrpos($path, '/')) {
        $namespace = substr($path, 0, $lastBackslash);
        $class = substr($path, $lastBackslash + 1);
    }

    $path = empty($namespace)
        ? "$class.php"
        : $namespace . '/' . $class . '.php';

    require_once $path;
});
