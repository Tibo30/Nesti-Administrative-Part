<?php
class IngredientDAO extends ModelDAO
{
    /**
     * get an ingredient according to its name
     * String $nameIngredient
     */
    public function getIngredientByName($nameIngredient){
        $req = self::$_bdd->prepare('SELECT p.id_products, p.product_name FROM products p JOIN ingredients i ON p.id_products=i.id_ingredients WHERE p.product_name=:name');
        $req->execute(array("name" => $nameIngredient));
        $productIngredient = new Product();
        if ($data = $req->fetch()) {
            $productIngredient->hydration($data);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $productIngredient;
    }

    /**
     * create ingredient
     * String $productName
     */
    public function createProductIngredient($productName)
    {
        $req = self::$_bdd->prepare('INSERT INTO products (product_name) VALUES (:name)');
        $req->execute(array("name" => $productName));
        $req->closeCursor(); // release the server connection so it's possible to do other query
        $last_id = self::$_bdd->lastInsertId();
        $req2 = self::$_bdd->prepare('INSERT INTO ingredients (id_ingredients) VALUES (:id)');
        $req2->execute(array("id" => $last_id));
        $req2->closeCursor(); // release the server connection so it's possible to do other query
        $last_id2 = self::$_bdd->lastInsertId();
        return $last_id2;
    }
    
}