<?php
/***
 * Classes autoload
 *
 * @param string $className
 */
function autoload(string $className)
{
    $className = ltrim($className, '\\');
    $file = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $file .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        if (file_exists($file)) {
            require $file;
        }
}

spl_autoload_register('autoload');
