<?php
/**
 * Created by PhpStorm.
 * User: Алёна
 * Date: 11.08.2018
 * Time: 19:10
 */

class Product
{
    const SHOW_BY_DEFAULT = 6;

    public static function getLatestProducts($page=1){
        $page = intval($page);
        $offset = ($page-1)* self::SHOW_BY_DEFAULT;

        $db = Db::getConnection();

        $productList = array();
        $result = $db->query('SELECT id, name, price, image, is_new FROM product '
        . 'WHERE status = "1" '
        . "ORDER BY id DESC "
        . 'LIMIT '. self::SHOW_BY_DEFAULT
        . " OFFSET ". $offset);
        $i = 0;
        while($row = $result->fetch()){
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['image'] = $row['image'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $productList;
    }
    public static function getProductList(){
        $db = Db::getConnection();

        $productList = array();
        $result = $db->query('SELECT id, name, price, code FROM product '
            . "ORDER BY id ");
        $i = 0;
        while($row = $result->fetch()){
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['code'] = $row['code'];
            $i++;
        }
        return $productList;
    }
    public static function getRecommendedProducts(){
        $db = Db::getConnection();

        $recommendedList = array();
        $result = $db->query('SELECT id, name, price, image, is_new FROM product '
            . 'WHERE status = "1" AND is_recommended = "1" '
            . "ORDER BY id ");
        $i = 0;
        while($row = $result->fetch()){
            $recommendedList[$i]['id'] = $row['id'];
            $recommendedList[$i]['name'] = $row['name'];
            $recommendedList[$i]['image'] = $row['image'];
            $recommendedList[$i]['price'] = $row['price'];
            $recommendedList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $recommendedList;
    }
    public static function getProductListByCategory($categoryId=false, $page=1){
        if($categoryId){

            $page = intval($page);
            $offset = ($page-1)* self::SHOW_BY_DEFAULT;

            $db = Db::getConnection();

            $products = array();

            $result = $db->query("SELECT id, name, price, image, is_new FROM product "
                . "WHERE status = '1' AND category_id = '$categoryId' "
                . "ORDER BY id DESC "
                . "LIMIT ". self::SHOW_BY_DEFAULT
                . " OFFSET ". $offset);
            $i = 0;
            while($row = $result->fetch()){
                $products[$i]['id'] = $row['id'];
                $products[$i]['name'] = $row['name'];
                $products[$i]['image'] = $row['image'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['is_new'] = $row['is_new'];
                $i++;
            }
            return $products;
        }
    }
    public static function getProductById($id){
        $id = intval($id);
        if ($id){
            $db = Db::getConnection();

            $result = $db->query('SELECT * FROM product WHERE id='.$id);
            $result->setFetchMode(PDO::FETCH_ASSOC);

            return$result->fetch();
        }
    }

    public static function getTotalProductsInCategory($categoryId){
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM product'
        .' WHERE status="1" AND category_id="'.$categoryId.'"');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];

    }

    public static function getTotalProducts(){
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM product'
            .' WHERE status="1"');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];

    }
    public static function getProductsByIds($idsArray)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Превращаем массив в строку для формирования условия в запросе
        $idsString = implode(',', $idsArray);
        // Текст запроса к БД
        $sql = "SELECT * FROM product WHERE status='1' AND id IN ($idsString)";
        $result = $db->query($sql);
        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);
        // Получение и возврат результатов
        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $i++;
        }
        return $products;
    }
    public static function deleteProductById($id){
        $db = Db::getConnection();
        $sql = 'DELETE FROM product WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }
    public static function createProduct($options)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = 'INSERT INTO product '
            . '(name, code, price, category_id, brand, availability,'
            . 'description, is_new, is_recommended, status)'
            . 'VALUES '
            . '(:name, :code, :price, :category_id, :brand, :availability,'
            . ':description, :is_new, :is_recommended, :status)';
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        if ($result->execute()) {
            // Если запрос выполенен успешно, возвращаем id добавленной записи
            return $db->lastInsertId();
        }
        // Иначе возвращаем 0
        return 0;
    }
    public static function updateProductById($id, $options)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = "UPDATE product
            SET 
                name = :name, 
                code = :code, 
                price = :price, 
                category_id = :category_id, 
                brand = :brand, 
                availability = :availability, 
                description = :description, 
                is_new = :is_new, 
                is_recommended = :is_recommended, 
                status = :status
            WHERE id = :id";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        return $result->execute();
    }

}