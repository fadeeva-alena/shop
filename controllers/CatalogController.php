<?php
/**
 * Created by PhpStorm.
 * User: Алёна
 * Date: 11.08.2018
 * Time: 12:52
 */


class CatalogController
{
    public function actionIndex(){
        $categories = array();
        $categories = Category::getCategoryList();

        $latestProduct = array();
        $latestProduct = Product::getLatestProducts(12);

        require_once(ROOT.'/views/catalog/index.php');
        return true;
    }
    public function actionCategory($categoryId, $page=1){
        $categories = array();
        $categories = Category::getCategoryList();
        $categoryProduct = array();
        $categoryProduct = Product::getProductListByCategory($categoryId, $page);

        $total = Product::getTotalProductsInCategory($categoryId);

        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        require_once(ROOT.'/views/catalog/category.php');
        return true;
    }
}