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
        $req = self::$_bdd->prepare('CALL add_ingredient (:name)');
        $req->execute(array("name" => $productName));
        $req->closeCursor(); // release the server connection so it's possible to do other query
        $req2 = self::$_bdd->query("SELECT LAST_INSERT_ID();"); 
        $req2->execute();
        $last_id=$req2->fetch()[0];
        return $last_id;
    }
    
}