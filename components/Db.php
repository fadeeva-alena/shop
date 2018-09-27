<?php
/**
 * Created by PhpStorm.
 * User: Алёна
 * Date: 07.08.2018
 * Time: 16:26
 */

class Db
{
    public static function getConnection(){
        $paramsPath = ROOT.'/config/db_params.php';
        $params = include($paramsPath);

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);

        return $db;
    }
}