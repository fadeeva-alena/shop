<?php
/**
 * Created by PhpStorm.
 * User: Алёна
 * Date: 04.09.2018
 * Time: 19:04
 */

class AdminController
{
    function __construct()
    {
        $userId = User::checkLogged();

        $user = User::getUserById($userId);

        if ($user['role'] == 'admin'){
            return true;
        }

        die('Access denied');
    }

    public function actionIndex(){

        require_once (ROOT.'/views/admin/index.php');
        return true;
    }
}