<?php
/**
 * Created by PhpStorm.
 * User: Алёна
 * Date: 30.08.2018
 * Time: 19:12
 */

class Cart
{
    public static function addProduct($id)
    {
        // Приводим $id к типу integer
        $id = intval($id);
        // Пустой массив для товаров в корзине
        $productsInCart = array();
        // Если в корзине уже есть товары (они хранятся в сессии)
        if (isset($_SESSION['products'])) {
            // То заполним наш массив товарами
            $productsInCart = $_SESSION['products'];
        }
        // Проверяем есть ли уже такой товар в корзине
        if (array_key_exists($id, $productsInCart)) {
            // Если такой товар есть в корзине, но был добавлен еще раз, увеличим количество на 1
            $productsInCart[$id] ++;
        } else {
            // Если нет, добавляем id нового товара в корзину с количеством 1
            $productsInCart[$id] = 1;
        }
        // Записываем массив с товарами в сессию
        $_SESSION['products'] = $productsInCart;
        // Возвращаем количество товаров в корзине
        return self::countItems();
    }
    public static function countItems()
    {
        // Проверка наличия товаров в корзине
        if (isset($_SESSION['products'])) {
            // Если массив с товарами есть
            // Подсчитаем и вернем их количество
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            // Если товаров нет, вернем 0
            return 0;
        }
    }
    public static function getProducts(){
        if (isset($_SESSION['products'])){
            return$_SESSION['products'];
        }
        return false;
    }

    public static function getTotalPrice($products){
        $productsInCart = self::getProducts();
        if ($productsInCart){
            $total = 0;
            foreach ($products as $item){
                $total+=$item['price']*$productsInCart[$item['id']];
            }
        }
        return $total;
    }
    public static function clear(){
        if (isset($_SESSION['products'])){
            unset($_SESSION['products']);
        }
    }
    public static function deleteProduct($id){
        unset($_SESSION['products'][$id]);
    }
}