<?php
spl_autoload_register(function ($class){
    // replace namespace backslashes with directory separators
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    // build the full path to the class file
    $fullPath = __DIR__ . '/' . $classPath . '.php';
    if (file_exists($fullPath)) {
        require_once $fullPath;
        return true;
    } else {
        echo 'Class not found: ' . $class;
        return false;
    }
});
