<?php
class OrderDAO extends ModelDAO
{
    public function getOrders()
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM order_request');
        $req->execute();
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
           
            foreach ($data as $row) {
                $order = new Order();
                $order->hydration($row);
                $var[] = $order;
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        // var_dump($var);
        return $var;
    }

    public function getOrderLines($idOrder)
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM order_line WHERE id_order=:id');
        $req->execute(array("id" => $idOrder));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $orderLine=new OrderLine();
                $var[] = $orderLine->hydration($row);;
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

}