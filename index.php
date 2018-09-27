<?php
/**
 * Created by PhpStorm.
 * User: Алёна
 * Date: 06.08.2018
 * Time: 12:34
 */
//  FRONT CONTROLLER
// 1. Общие настройки
ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();
// 2. Подключение файлов системы
define('ROOT',dirname(__FILE__));
require_once (ROOT.'/components/Autoload.php');

// 3. Установка соединения с БД

// 4. Вызов роутер
$router=new Router();
$router->run();
?>