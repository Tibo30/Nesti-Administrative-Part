<?php
class ProductDAO extends ModelDAO
{
    /**
     * get product
     * int $idProduct
     */
    public function getProduct($idProduct)
    {
        $req = self::$_bdd->prepare('SELECT * FROM products WHERE id_products=:id');
        $req->execute(array("id" => $idProduct));
        $productObject = new Product();
        if($product =  $req->fetch()){
            $productObject->hydration($product);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $productObject;
    }

    /**
     * get type of a product
     * int $idProduct
     */
    public function getType($idProduct)
    {
        $type="";
        $req = self::$_bdd->prepare('SELECT * FROM ingredients WHERE id_ingredients=:id');
        $req->execute(array("id" => $idProduct));
        if ($req->rowcount()==1) {
            $type = "Ingredient";
        } else {
            $type="Utensile";
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $type;
    }
}