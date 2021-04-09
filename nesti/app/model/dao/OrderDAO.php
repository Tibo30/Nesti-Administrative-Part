<?php
class OrderDAO extends ModelDAO
{
    // get all the orders
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

    // get all the orderlines for an order
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

    // get all the orderlines for an article
    public function getOrderLinesArticle($idArticle)
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM order_line WHERE id_article=:id');
        $req->execute(array("id" => $idArticle));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $orderLine=new OrderLine();
                $var[] = $orderLine->hydration($row);;
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    // get all the orders from a user
    public function getOrdersUser($idUser)
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM order_request WHERE id_users=:id');
        $req->execute(array("id" => $idUser));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $order = new Order();
                $order->hydration($row);
                $var[] = $order;
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }


    public function getLastOrder($idUser)
    {
        $req = self::$_bdd->prepare('SELECT * FROM order_request WHERE id_users=:id ORDER BY creation_date DESC LIMIT 1');
        $req->execute(array("id" => $idUser));
        $lastOrder = new Order();
        if ($order = $req->fetch()) {
            $lastOrder->hydration($order);
        }       
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $lastOrder;
    }

    // get all the orders by day
    public function getOrdersByDay($day)
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM order_request WHERE creation_date LIKE :date"%" AND state="a"');
        $req->execute(array("date" => $day));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $order = new Order();
                $order->hydration($row);
                $var[] = $order;
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

}