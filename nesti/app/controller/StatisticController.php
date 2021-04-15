<?php
require_once(BASE_DIR.PATH_VIEW . 'View.php');

class StatisticController extends BaseController
{
    private $statisticsDAO;

    public function initialize()
    {
        $this->statistic();
    }

    private function statistic()
    {
        $this->statisticsDAO = new StatisticDAO();

        $statistic = $this->statisticsDAO->getStatistics();
        $data[] = null;
        $this->statisticsDAO = new StatisticDAO();


        //  ------------------------------ GET ALL THE LOGS --------------------------------- //

        $userLogDAO = new UserLogsDAO();
        $allLogs = $userLogDAO->getLogs(); // get all the logs

        foreach ($allLogs as $log) {
            $format = 'Y-m-d H:i:s';
            $logDate = DateTime::createFromFormat($format, $log->getConnectionDate()); // format each connection date
            $hoursLog[$logDate->format('H')][] = $log; // sort the list of the logs by hours (hour is the key of the array $hoursLog)
        }

        foreach ($hoursLog as $key => $logs) {
            $connectionPerHour[] = (object) array('name' => $key, 'data' => count($logs)); // count the number of logs for a given hour
        }

        array_multisort($connectionPerHour, SORT_ASC);


        //  ------------------------------ GET ALL THE USERS --------------------------------- //

        $userDAO = new UserDAO();
        $users = $userDAO->getUsers(); // get all the users

        usort($users, function ($u1, $u2) { // sort the array DESC according to the number of logs for each user
            return count($u2->getLogs()) <=> count($u1->getLogs());
        });
        $users = array_slice($users, 0, 10); // we keep the first 10

        $mostConnectedUsers = [];
        foreach ($users as $user) {
            $mostConnectedUsers[] = ["id" => $user->getIdUser(), "name" => $user->getLastName() . ' ' . $user->getFirstName()];
        }

        //  ------------------------------ GET THE TOP CHIEFS --------------------------------- //

        $chiefs = $userDAO->getChiefs();
        usort($chiefs, function ($c1, $c2) { // sort the array DESC according to the average grade of recipes for each chief
            return $c2->getAverageGrade() <=> $c1->getAverageGrade();
        });
        $chiefs = array_slice($chiefs, 0, 10); // we keep the first 10

        //  ------------------------------ GET ALL THE RECIPES --------------------------------- //
        $recipeDAO = new RecipeDAO();
        $recipes = $recipeDAO->getRecipes();
        usort($recipes, function ($r1, $r2) { // sort the array DESC according to the grade of the recipe
            return $r2->getGrade() <=> $r1->getGrade();
        });
        $recipes = array_slice($recipes, 0, 10); // we keep the first 10


        //  ------------------------------ GET ALL THE ORDERS --------------------------------- //
        $orderDAO = new OrderDAO();
        $orders = $orderDAO->getOrders();
        usort($orders, function ($o1, $o2) { // sort the array DESC according to the price of the order
            return $o2->getAmount() <=> $o1->getAmount();
        });
        $orders = array_slice($orders, 0, 3); // we keep the first 3


        //  ------------------------------ GET ALL THE ORDERS REQUEST COST/LOTS RECEIVED COST --------------------------------- //
        $startDate = new DateTime;
        $startDate->add(DateInterval::createFromDateString("-10 days"));

        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime("-1 days"));

        $totalSoldPerDay = [];
        $totalPurchasedPerDay = [];
        $lotDAO = new LotDAO();

        for ($i = 9; $i >= 0; $i--) {
            $dayDate = date('Y-m-d', strtotime("-" . $i . " days"));

            $ordersByDay = $orderDAO->getOrdersByDay($dayDate);
            $lotsByDay = $lotDAO->getLotsByDay($dayDate);

            $totalSold = 0;
            $totalPurchased = 0;
            foreach ($ordersByDay as $order) {
                $totalSold += $order->getAmount();
            }
            foreach ($lotsByDay as $lot) {
                $totalPurchased += $lot->getUnitCost() * $lot->getBoughtQuantity();
            }
            $totalPurchasedPerDay[] = $totalPurchased;
            $totalSoldPerDay[] = $totalSold;
        }


        //  ------------------------------ GET ALL THE ORDERS/LOTS --------------------------------- //
        $articleDAO = new ArticleDAO();
        $articles = $articleDAO->getArticles();
        $articlesWithKey = [];

        $articleOutOfStock = [];
        $articleInStock = [];
        foreach ($articles as $article) {
            if ($article->getStock() == 0) {
                $articleOutOfStock[] = $article;
            } else {
                $articleInStock[] = $article;
            }
            $articlesWithKey[$article->getProduct()->getProductName()] = $article;
        }

        $articleSold = [];
        $articleBought = [];
        foreach ($articles as $article) {
            $articleSold[] = $article->getTotalSales();
            $articleBought[] = $article->getTotalBought();
        }

        $this->_view = new View('statistic');
        $data["mostConnectedUsers"]=$mostConnectedUsers;
        $data["biggestOrders"]=$orders;
        $data["topChiefs"]=$chiefs;
        $data["topRecipes"]=$recipes;
        $data["connectionPerHour"] = $connectionPerHour;
        $data["totalPurchasedPerDay"] = $totalPurchasedPerDay;
        $data["totalSoldPerDay"] = $totalSoldPerDay;
        $data["articles"] = $articlesWithKey;
        $data["articleInStock"] = $articleInStock;
        $data["articleOutOfStock"] = $articleOutOfStock;
        $data["articleSold"] = $articleSold;
        $data["articleBought"] = $articleBought;
        $data["title"] = "Statistic";
        $data["url"] = $this->_url;
        $this->_data = $data;
    }
}
