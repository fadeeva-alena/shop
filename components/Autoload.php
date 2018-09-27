<?php
/**
 * Created by PhpStorm.
 * User: Алёна
 * Date: 27.08.2018
 * Time: 16:06
 */
    spl_autoload_register('myAutoloader');
    function myAutoloader($class_name)
    {
        $array_paths = array(
            '/models/',
            '/components/'
        );
        foreach ($array_paths as $path){
            $path = ROOT.$path.$class_name.'.php';
            if(is_file($path)){
                include_once  $path;
            }
        }
    }