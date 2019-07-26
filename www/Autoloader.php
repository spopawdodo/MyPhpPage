<?php

spl_autoload_register(function ($class_name) {
    $pathComponents = explode("\\", $class_name);
    array_unshift($pathComponents, __DIR__);
    $classPath = implode(DIRECTORY_SEPARATOR, $pathComponents);
    $classPath .= ".php";
    require($classPath);
});
