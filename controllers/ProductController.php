<?php
/**
 * Created by PhpStorm.
 * User: Алёна
 * Date: 11.08.2018
 * Time: 13:27
 */

class ProductController{
    public function actionView($id){
        $categories = array();
        $categories = Category::getCategoryList();

        $product = Product::getProductById($id);
        require_once(ROOT.'/views/product/view.php');
        return true;
    }
}