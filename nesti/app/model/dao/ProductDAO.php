<?php
class ProductDAO extends ModelDAO
{
    public function getProduct($idProduct)
    {
        $req = self::$_bdd->prepare('SELECT * FROM products WHERE id_products=:id');
        $req->execute(array("id" => $idProduct));
        $product =  $req->fetch();
        $productObject = new Product();
        $productObject->hydration($product);
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $productObject;
    }
}