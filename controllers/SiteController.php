<?php
/**
 * Created by PhpStorm.
 * User: Алёна
 * Date: 11.08.2018
 * Time: 12:52
 */

class SiteController
{
    public function actionIndex($page=1)
    {
        $categories = array();
        $categories = Category::getCategoryList();

        $latestProduct = array();
        $latestProduct = Product::getLatestProducts($page);

        $total = Product::getTotalProducts();

        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        $recommendedProduct = array();
        $recommendedProduct = Product::getRecommendedProducts();
        require_once(ROOT . '/views/site/index.php');
        return true;
    }
    public function actionContact(){
        $userEmail = '';
        $userText = '';
        $result = false;

        if (isset($_POST['submit'])){
             $userEmail=$_POST['userEmail'];
             $userText = $_POST['userText'];

             $errors = false;

             if (!User::checkEmail($userEmail)){
                 $errors[]='Неправильный email';
             }

             if ($errors==false){
                 $adminEmail='fadaljona@gmail.com';
                 $message = "Текст: {$userText}. От {$userEmail}";
                 $subject = 'Тема письма';
                 $result= mail($adminEmail,$subject, $message);
                 $result = true;
             }
        }

        require_once (ROOT.'/views/site/contact.php');
        return true;
    }
}